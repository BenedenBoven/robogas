import 'breakpoint-hint/src/tailwind';

import './bootstrap';
import './submit-form.js';
import './file-upload.js';
import './form-choices.js';
import './knowledge.js';
import './nav.js';
import './modulobox.js';
import './gsap.js';
import './carousels.js';
import './plugins/gridzy.min.js';


/*
VIDEO ON HOVER PLAY OP INDEX
*/
document.addEventListener('DOMContentLoaded', () => {

    const videoHovers = document.querySelectorAll('.video-hover');

    if(!videoHovers.length) return;

    videoHovers.forEach(container => {

        const video = container.querySelector('.hover-video');

        if(!video) return;

        container.addEventListener('mouseenter', () => {
            video.play().catch(() => {
            });
        });

        container.addEventListener('mouseleave', () => {
            video.pause();
        });

    });

});
