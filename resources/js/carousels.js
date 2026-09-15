import Flickity from 'flickity';

document.querySelectorAll('.gallery-carousel').forEach((carousel) => {

    const flkty = new Flickity(carousel, {
        cellAlign:          'center',
        contain:            false,
        wrapAround:         true,
        prevNextButtons:    false,
        pageDots:           true,
        draggable:          true,
        selectedAttraction: 0.025,
        friction:           0.28
    });

    const updateCarouselSpacing = () => {
        const cells = [...carousel.querySelectorAll('.gallery-carousel-cell')];

        if(!cells.length) return;

        const styles = getComputedStyle(carousel);

        const normalScale = parseFloat(
            styles.getPropertyValue('--normal-scale')
        );

        const selectedScale = parseFloat(
            styles.getPropertyValue('--selected-scale')
        );

        const selectedIndex = flkty.selectedIndex;
        const total         = cells.length;

        const selectedImage = cells[selectedIndex].querySelector('.gallery-carousel-image');

        /*
         * offsetWidth geeft de originele breedte,
         * dus vóór de scale().
         */
        const imageWidth = selectedImage.offsetWidth;

        /*
         * Hoeveel breder wordt de geselecteerde afbeelding
         * aan iedere kant?
         */
        const shift = imageWidth * (selectedScale - normalScale) / 2;

        cells.forEach((cell, index) => {
            const offsetElement = cell.querySelector('.gallery-carousel-offset');

            let difference = index - selectedIndex;

            /*
             * Nodig vanwege wrapAround:
             * bepaal of een slide visueel links of rechts staat.
             */
            if(difference > total / 2) {
                difference -= total;
            }

            if(difference < -total / 2) {
                difference += total;
            }

            let offset = 0;

            if(difference < 0) {
                offset = -shift;
            }

            if(difference > 0) {
                offset = shift;
            }

            offsetElement.style.setProperty(
                '--carousel-offset',
                `${offset}px`
            );
        });
    };

    flkty.on('select', updateCarouselSpacing);

    window.addEventListener('resize', updateCarouselSpacing);

    updateCarouselSpacing();
});