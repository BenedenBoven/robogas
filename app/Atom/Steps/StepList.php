<?php declare(strict_types=1);

namespace App\Atom\Steps;

/**
 * De lijsten die het stappen-tabblad kan beheren. Elke lijst krijgt een eigen
 * tabblad met eigen velden; in rg_steps staat de waarde in de kolom list.
 *
 * Een regel heeft altijd een titel. Het label (kort, vóór de titel) en de
 * toelichting (eronder) verschijnen alleen als de lijst er een placeholder
 * voor heeft.
 */
enum StepList: string {

    case STEPS      = 'steps';
    case FACTS      = 'facts';
    case MILESTONES = 'milestones';

    public function tabTitle(): string {
        return match ($this) {
            self::STEPS      => 'Stappen',
            self::FACTS      => 'Kerncijfers',
            self::MILESTONES => 'Mijlpalen',
        };
    }

    public function icon(): string {
        return match ($this) {
            self::STEPS      => 'fa-regular fa-list-ol',
            self::FACTS      => 'fa-regular fa-chart-simple',
            self::MILESTONES => 'fa-regular fa-timeline',
        };
    }

    public function help(): string {
        return match ($this) {
            self::STEPS      => 'De stappen verschijnen op de website, in de volgorde die hier staat. Het nummer telt vanzelf.',
            self::FACTS      => 'De kerncijfers staan in een blauwe band over de volle breedte. Drie of vier staat het mooist.',
            self::MILESTONES => 'De mijlpalen vormen de tijdlijn, van links naar rechts in de volgorde die hier staat. Vier staat het mooist.',
        };
    }

    /** Tekst op de knop om een regel toe te voegen. */
    public function addLabel(): string {
        return match ($this) {
            self::STEPS      => 'Stap toevoegen',
            self::FACTS      => 'Kerncijfer toevoegen',
            self::MILESTONES => 'Mijlpaal toevoegen',
        };
    }

    /** Null: deze lijst heeft geen label. */
    public function labelPlaceholder(): ?string {
        return match ($this) {
            self::STEPS      => null,
            self::FACTS      => 'Getal, bijvoorbeeld 66',
            self::MILESTONES => 'Jaar, bijvoorbeeld 1960',
        };
    }

    public function titlePlaceholder(): string {
        return match ($this) {
            self::STEPS      => 'Bijvoorbeeld We plannen de rit',
            self::FACTS      => 'Bijvoorbeeld jaar ervaring',
            self::MILESTONES => 'Bijvoorbeeld Eerste eigen tankwagen',
        };
    }

    /** Null: deze lijst heeft geen toelichting. */
    public function summaryPlaceholder(): ?string {
        return match ($this) {
            self::STEPS      => 'Korte toelichting op deze stap',
            self::FACTS      => null,
            self::MILESTONES => 'Wat er dat jaar gebeurde, in één of twee zinnen',
        };
    }

    /** Alleen stappen tonen een volgnummer; bij de andere lijsten zegt het niets. */
    public function numbered(): bool {
        return $this === self::STEPS;
    }
}
