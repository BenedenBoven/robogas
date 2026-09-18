<?php declare(strict_types=1);

namespace App\Infrastructure\ViewComposers;

use App\Infrastructure\Attributes\ComposerDescription;
use App\Infrastructure\Attributes\ComposesViews;
use App\Support\Services\CompanyDetails;
use Illuminate\Cache\CacheManager;
use Illuminate\View\View;

#[ComposesViews(
    'components.footer',
    'contact.show',
    'form-pages.show',
    'knowledge.faq',
    'vacancies.list',
    'vacancies.show'
)]
#[ComposerDescription('De bedrijfsgegevens uit de instellingen, met config/company.php als terugval.', 'company')]
final readonly class CompanyDetailsComposer extends AbstractMemoizedComposer {

    public function __construct(
        CacheManager           $cacheManager,
        private CompanyDetails $companyDetails
    ) {
        parent::__construct($cacheManager);
    }

    public function compose(View $view): void {
        $this->addToViewIfMissing($view, 'company', $this->companyDetails);
    }
}
