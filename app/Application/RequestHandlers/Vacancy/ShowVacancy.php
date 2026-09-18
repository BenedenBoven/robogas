<?php declare(strict_types=1);

namespace App\Application\RequestHandlers\Vacancy;

use App\Domains\Vacancy\Models\Vacancy;
use BenedenBoven\Atom\Application\Models\Taxonomy;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Response;

final readonly class ShowVacancy {

    public function __construct(
        private ResponseFactory $responseFactory
    ) {}

    public function __invoke(): Response {
        $taxonomy = Taxonomy::getCurrentInstance();

        /** @var Vacancy $vacancy */
        $vacancy = $taxonomy->getModel();
        $vacancy->loadMissing('header');

        return $this->responseFactory->view('vacancies.show', [
            'taxonomy' => $taxonomy,
            'vacancy'  => $vacancy,
        ]);
    }
}
