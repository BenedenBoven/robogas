<?php declare(strict_types=1);

namespace Database\Seeders;

use App\Domains\Article\Models\Article;
use App\Domains\Article\Models\ArticleTheme;
use App\Domains\Audience\Models\Audience;
use App\Domains\Page\Models\Page;
use App\Support\TaxonomyMap;
use Illuminate\Database\Seeder;

/**
 * Vult Onze kennis: thema's, artikelen en de teksten van de pagina's Onze
 * kennis en Veelgestelde vragen.
 *
 * Titels, thema's en kleuren komen uit het ontwerp in Claude Design; de tekst
 * van het eerste artikel ook, de rest is dummytekst. De labels uit het ontwerp
 * zijn gekoppeld aan de doelgroepen uit Voor wie; "Bakkerijen" bestaat daar niet
 * en valt weg.
 *
 * Opnieuw draaien is veilig: bestaande thema's en artikelen blijven staan, en
 * alleen lege paginavelden worden gevuld.
 *
 * Draaien met: php artisan db:seed --class=ArticleSeeder
 */
final class ArticleSeeder extends Seeder {

    private const THEMES = ['Basiskennis', 'Installatie', 'Bestellen', 'Veiligheid', 'Biogas', 'Klantverhalen'];

    private const DUMMY = '<p>Hier komt het artikel. Deze tekst is een plaatshouder en wordt vervangen door de tekst van RoboGas.</p>'
        . '<p>Een goed kennisartikel beantwoordt één vraag, zoals de klant hem aan de telefoon stelt, en eindigt met wat de lezer nu kan doen.</p>';

    private const FIRST_BODY = '<p>Propaangas is een vloeibaar gemaakt gas dat je opslaat in een tank of fles op je eigen terrein. Je bent er niet mee afhankelijk van het aardgasnet, en dat maakt het de logische keuze voor woningen, bedrijven en locaties buiten de bebouwde kom.</p>'
        . '<h4>Waar wordt het voor gebruikt?</h4><ul><li>Verwarming en warm water in woningen en chalets</li><li>Ovens en fornuizen in bakkerijen en de horeca</li><li>Droogvloeren, heaters en keetverwarming op de bouw</li><li>Heftrucks en interne transportmiddelen</li></ul>'
        . '<h4>Tank of fles?</h4><table><tbody><tr><td>Toepassing</td><td>Levering</td></tr><tr><td>Gastank</td><td>Automatisch bijvullen</td></tr><tr><td>Gasfles</td><td>Afhalen bij een verkooppunt</td></tr></tbody></table>'
        . '<p>Twijfel je over wat bij je past? We rekenen je verbruik door en komen ter plaatse meten.</p>';

    /** titel, thema, kleur, doelgroepen */
    private const ARTICLES = [
        ['Wat is propaangas?', 'Basiskennis', 'blauw', ['Particulier']],
        ['Hoe je jouw cv-ketel ombouwt zodat hij werkt op propaangas', 'Installatie', 'blauw', ['Particulier', 'Bouw & industrie']],
        ['Niet aangesloten op het aardgasnetwerk?', 'Basiskennis', 'geel', ['Particulier', 'Agrarisch', 'Recreatie']],
        ['Hoe wij werken met biopropaan', 'Biogas', 'blauw', ['Particulier']],
        ['Bakkerij Broodje werkt met ovens op propaangas', 'Klantverhalen', 'navy', []],
        ['Hoe word ik onafhankelijk van het overbelaste stroomnet?', 'Basiskennis', 'navy', ['Particulier']],
    ];

    private const PAGES = [
        'KNOWLEDGE' => [
            'long_title'     => 'Onze kennis',
            'subtitle'       => 'Andere vraag? Wij beantwoorden hem!',
            'summary'        => 'Alles wat we uitleggen aan de telefoon, staat hier ook. Van wat propaan eigenlijk is tot hoe je je ketel ombouwt.',
            'block_title'    => 'Staat je vraag er niet bij?',
            'block_subtitle' => 'Andere vraag? Wij beantwoorden hem!',
        ],
        'FAQ'       => [
            'subtitle' => 'Wat we het vaakst gevraagd krijgen',
            'summary'  => 'De vragen die we het vaakst aan de telefoon krijgen, met het antwoord dat we dan ook geven.',
            'body'     => '<p>Werkdagen 8.00 - 17.00 uur. Buiten kantoortijd is de storingsdienst bereikbaar op hetzelfde nummer.</p>',
        ],
    ];

    public function run(): void {
        $themes = [];

        foreach(self::THEMES as $priority => $title) {
            $theme = ArticleTheme::query()->firstOrNew(['title' => $title]);

            if(!$theme->exists) {
                $theme->forceFill(['title' => $title, 'priority' => $priority, 'published' => 1])->save();
            }

            $themes[$title] = $theme;
        }

        $audiences = Audience::query()->pluck('id', 'title');

        foreach(self::ARTICLES as $priority => [$title, $theme, $color, $audienceTitles]) {
            $article = Article::query()->firstOrNew(['title' => $title]);

            if($article->exists) {
                $this->command?->line('Bestaat al: ' . $title);
                continue;
            }

            $article->forceFill([
                'title'            => $title,
                'article_theme_id' => $themes[$theme]->id,
                'summary'          => null,
                'body'             => $priority === 0 ? self::FIRST_BODY : self::DUMMY,
                'color'            => $color,
                'priority'         => $priority,
                'published'        => 1,
            ])->save();

            $article->createTaxonomy(parentId: TaxonomyMap::KNOWLEDGE->value);
            $article->audiences()->sync(array_values(array_filter(array_map(fn(string $name) => $audiences[$name] ?? null, $audienceTitles))));

            $this->command?->info('Aangemaakt: ' . $title);
        }

        foreach(self::PAGES as $case => $values) {
            $map  = constant(TaxonomyMap::class . '::' . $case);
            $page = Page::query()->findOrFail(Page::query()->joined()->where('atom_taxonomies.id', $map->value)->value('atom_pages.id'));

            // Ruwe waarden: de accessor van long_title valt terug op title en is dus nooit leeg.
            foreach($values as $column => $value) {
                if(empty($page->getAttributes()[$column] ?? null)) {
                    $page->{$column} = $value;
                }
            }

            $page->save();
        }

        $this->command?->warn('Let op: titels komen uit het ontwerp, de artikelteksten zijn plaatshouders.');
    }
}
