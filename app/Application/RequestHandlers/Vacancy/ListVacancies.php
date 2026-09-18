<?php declare(strict_types=1);

namespace App\Application\RequestHandlers\Vacancy;

use App\Domains\Page\Models\Page;
use App\Domains\Vacancy\Contracts\VacancyRepositoryInterface;
use BenedenBoven\Atom\Application\Models\Taxonomy;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Response;

final readonly class ListVacancies {

    public function __construct(
        private ResponseFactory            $responseFactory,
        private VacancyRepositoryInterface $vacancyRepository
    ) {}

    public function __invoke(): Response {
        $taxonomy = Taxonomy::getCurrentInstance();

        /** @var Page $page */
        $page = $taxonomy->getModel();
        $page->loadMissing(['header', 'images']);

        return $this->responseFactory->view('vacancies.list', [
            'taxonomy'  => $taxonomy,
            'page'      => $page,
            'vacancies' => $this->vacancyRepository->getAll(),
        ]);
    }
}
