<?php declare(strict_types=1);

namespace App\Application\RequestHandlers\Form;

use App\Domains\Audience\Contracts\AudienceRepositoryInterface;
use App\Domains\Faq\Contracts\FaqThemeRepositoryInterface;
use App\Domains\Page\Models\Page;
use App\Support\FormType;
use App\Support\TaxonomyMap;
use BenedenBoven\Atom\Application\Models\Taxonomy;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Response;

/**
 * De pagina's met een formulier: Contact, Gas bestellen, Offerte aanvragen en
 * Storing melden. Eén handler, omdat ze dezelfde gegevens nodig hebben en alleen
 * in formulier en opbouw verschillen.
 */
final readonly class ShowFormPage {

    public function __construct(
        private ResponseFactory             $responseFactory,
        private FaqThemeRepositoryInterface $faqThemeRepository,
        private AudienceRepositoryInterface $audienceRepository
    ) {}

    public function __invoke(): Response {
        $taxonomy = Taxonomy::getCurrentInstance();

        /** @var Page $page */
        $page = $taxonomy->getModel();
        $page->loadMissing(['header', 'steps']);

        $formType = match ($taxonomy->id) {
            TaxonomyMap::ORDER->value       => FormType::ORDER,
            TaxonomyMap::QUOTE->value       => FormType::QUOTE,
            TaxonomyMap::MALFUNCTION->value => FormType::MALFUNCTION,
            default                         => FormType::CONTACT,
        };

        return $this->responseFactory->view($formType === FormType::CONTACT ? 'contact.show' : 'form-pages.show', [
            'taxonomy'  => $taxonomy,
            'page'      => $page,
            'formType'  => $formType,
            'faqThemes' => $this->faqThemeRepository->getForPage((int)$page->id),
            'audiences' => $formType === FormType::QUOTE ? $this->audienceRepository->getAll() : collect(),
        ]);
    }
}
