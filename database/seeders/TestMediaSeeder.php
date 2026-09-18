<?php declare(strict_types=1);

namespace Database\Seeders;

use App\Domains\Article\Models\Article;
use App\Domains\Audience\Models\Audience;
use App\Domains\Page\Models\Page;
use App\Domains\Service\Models\Service;
use App\Domains\Vacancy\Models\Vacancy;
use App\Support\TaxonomyMap;
use BenedenBoven\Atom\Modules\Media\Models\Media;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

/**
 * Tijdelijke afbeeldingen, zodat zichtbaar is waar beeld komt voordat RoboGas
 * eigen foto's aanlevert. Naar het voorbeeld van Van Lee.
 *
 * Alles staat in public/uploads/media/demo-*; de seeder ruimt die bestanden en
 * mediarijen eerst op, dus opnieuw draaien is veilig. Alleen opruimen:
 *
 *     LEEGMAKEN=1 php artisan db:seed --class=TestMediaSeeder
 *
 * Draaien met: php artisan db:seed --class=TestMediaSeeder
 */
final class TestMediaSeeder extends Seeder {

    private const MAP         = 'uploads/media';
    private const VOORVOEGSEL = 'demo-';

    /** De enige foto uit het ontwerp; alle plekken krijgen dezelfde. */
    private const BEELD = 'demo-foto.jpg';

    /** Kennisartikelen die in het ontwerp een foto hebben; de rest toont een kleur. */
    private const ARTIKELEN_MET_FOTO = [
        'Hoe je jouw cv-ketel ombouwt zodat hij werkt op propaangas',
        'Hoe wij werken met biopropaan',
        'Bakkerij Broodje werkt met ovens op propaangas',
    ];

    /** Vaste pagina's met een headerbeeld in het ontwerp. */
    private const PAGINAS_MET_HEADER = [TaxonomyMap::SERVICES, TaxonomyMap::AUDIENCES, TaxonomyMap::CONTACT];

    public function run(): void {
        $this->ruimOp();

        if(env('LEEGMAKEN')) {
            $this->command?->info('Testafbeeldingen verwijderd.');

            return;
        }

        if(!is_dir(public_path(self::MAP))) {
            mkdir(public_path(self::MAP), 0755, true);
        }

        copy(resource_path('img/default.jpg'), public_path(self::MAP . '/' . self::BEELD));

        // Diensten: de beeldband op de detailpagina.
        foreach(Service::query()->get() as $service) {
            $this->zetHeader($service);
        }

        // Doelgroepen: de header en het beeld naast de leeskolom.
        foreach(Audience::query()->get() as $audience) {
            $this->zetHeader($audience);
            $this->maakMedia($audience, 'Beeld ' . $audience->title);
        }

        foreach(Article::query()->whereIn('title', self::ARTIKELEN_MET_FOTO)->get() as $article) {
            $this->zetHeader($article);
        }

        foreach(self::PAGINAS_MET_HEADER as $map) {
            $this->zetHeader($this->pagina($map));
        }

        // Vacatures: twee foto's onder de lijst, en een beeldband per vacature.
        $vacatures = $this->pagina(TaxonomyMap::CAREERS);
        $this->maakMedia($vacatures, 'Werkplaats 1');
        $this->maakMedia($vacatures, 'Werkplaats 2');
        $this->zetHeader($vacatures);

        foreach(Vacancy::query()->get() as $vacancy) {
            $this->zetHeader($vacancy);
        }

        // Doelgroepenoverzicht: de beeldband onder de kaarten.
        $this->maakMedia($this->pagina(TaxonomyMap::AUDIENCES), 'Beeldband doelgroepen');

        $this->command?->info('Testafbeeldingen: ' . Media::query()->where('file', 'like', '%/' . self::VOORVOEGSEL . '%')->count() . ' mediarijen.');
        $this->command?->warn('Tijdelijk beeld. Verwijderen: LEEGMAKEN=1 php artisan db:seed --class=TestMediaSeeder');
    }

    /** Verwijdert alles wat deze seeder eerder maakte: rijen, verwijzingen en bestanden. */
    private function ruimOp(): void {
        $ids = Media::query()->where('file', 'like', '%/' . self::VOORVOEGSEL . '%')->pluck('id')->all();

        if($ids !== []) {
            foreach([Page::class, Service::class, Audience::class, Article::class, Vacancy::class] as $klasse) {
                $klasse::query()->whereIn('header_id', $ids)->update(['header_id' => null]);
            }

            Media::query()->whereIn('id', $ids)->delete();
        }

        foreach(glob(public_path(self::MAP . '/' . self::VOORVOEGSEL . '*')) ?: [] as $bestand) {
            unlink($bestand);
        }
    }

    /**
     * Type header, zoals het beheer een headerupload opslaat; daardoor staat hij
     * niet ook in het tabblad Afbeeldingen. Het model verwijst ernaar via header_id.
     */
    private function zetHeader(Model $model): void {
        $media = $this->maakMedia($model, 'Header ' . $model->title, 'header');

        $model->forceFill(['header_id' => $media->id])->save();
    }

    private function maakMedia(Model $model, string $titel, string $type = 'image'): Media {
        // Atom rekent de afmetingen alleen uit voor type image; media-img heeft ze nodig voor width en height.
        [$breedte, $hoogte] = getimagesize(public_path(self::MAP . '/' . self::BEELD));

        return Media::query()->create([
            'title'      => $titel,
            'alt'        => '',
            'file'       => '/' . self::MAP . '/' . self::BEELD,
            'mimetype'   => 'image/jpeg',
            'type'       => $type,
            'size'       => filesize(public_path(self::MAP . '/' . self::BEELD)),
            'model_type' => $model->getMorphClass(),
            'model_id'   => $model->getKey(),
            'original_width'  => $breedte,
            'original_height' => $hoogte,
            'is_public'  => 1,
            'prio'       => 0,
            // Geen ja/nee-vlag maar het pad waarop de resizer reageert. Leeg geeft '0?w=1920' als src.
            'resizeable' => '/' . self::MAP . '/cache/' . self::BEELD,
        ]);
    }

    private function pagina(TaxonomyMap $map): Page {
        return Page::query()->findOrFail(Page::query()->joined()->where('atom_taxonomies.id', $map->value)->value('atom_pages.id'));
    }
}
