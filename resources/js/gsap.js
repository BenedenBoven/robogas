import {gsap} from 'gsap';
import {ScrollTrigger} from 'gsap/ScrollTrigger';

gsap.registerPlugin(ScrollTrigger);

document.querySelectorAll('[data-knowledge-section]').forEach((section) => {
    const titleBlock = section.querySelector('[data-title-block]');

    gsap.fromTo(titleBlock,
        {
            y:       60,
            opacity: 0,
            filter:  'blur(8px)',
            scale:   0.97
        },
        {
            y:             0,
            opacity:       1,
            filter:        'blur(0px)',
            scale:         1,
            duration:      1.2,
            ease:          'power3.out',
            scrollTrigger: {
                trigger:       section,
                start:         'top 45%',
                toggleActions: 'play none none reverse'
            }
        }
    );
});

document.querySelectorAll('[data-floating-shape]').forEach((shape) => {
    gsap.to(shape, {
        y:        48,
        x:        0,
        rotation: 0.5,
        duration: 6,
        ease:     'sine.inOut',
        repeat:   -1,
        yoyo:     true
    });
});

document.addEventListener('DOMContentLoaded', () => {
    const hotspots = document.querySelectorAll('[data-hotspot]');

    hotspots.forEach((hotspot) => {
        const button  = hotspot.querySelector('button');
        const plus    = hotspot.querySelector('[data-plus]');
        const icon    = hotspot.querySelector('[data-icon]');
        const content = hotspot.querySelector('[data-content]');
        const isOpen  = hotspot.dataset.open === 'true';

        gsap.set(plus, {
            autoAlpha: isOpen ? 0 : 1,
            scale:     isOpen ? 0.5 : 1
        });

        gsap.set(icon, {
            autoAlpha: isOpen ? 1 : 0,
            scale:     isOpen ? 1 : 0.5
        });

        gsap.set(content, {
            autoAlpha: isOpen ? 1 : 0,
            y:         isOpen ? 0 : 10
        });

        button.addEventListener('click', () => {
            if(hotspot.dataset.open === 'true') {
                return;
            }

            hotspots.forEach((otherHotspot) => {
                if(otherHotspot === hotspot) return;

                closeHotspot(otherHotspot);
            });

            openHotspot(hotspot);
        });
    });

    function openHotspot(hotspot) {
        const button  = hotspot.querySelector('button');
        const plus    = hotspot.querySelector('[data-plus]');
        const icon    = hotspot.querySelector('[data-icon]');
        const content = hotspot.querySelector('[data-content]');

        hotspot.dataset.open = 'true';
        button.setAttribute('aria-expanded', 'true');

        gsap.to(plus, {
            autoAlpha: 0,
            scale:     0.5,
            duration:  0.25,
            ease:      'power2.out'
        });

        gsap.to(icon, {
            autoAlpha: 1,
            scale:     1,
            duration:  0.45,
            delay:     0.05,
            ease:      'back.out(1.7)'
        });

        gsap.to(content, {
            autoAlpha: 1,
            y:         0,
            duration:  0.5,
            delay:     0.1,
            ease:      'power3.out'
        });
    }

    function closeHotspot(hotspot) {
        if(hotspot.dataset.open !== 'true') return;

        const button  = hotspot.querySelector('button');
        const plus    = hotspot.querySelector('[data-plus]');
        const icon    = hotspot.querySelector('[data-icon]');
        const content = hotspot.querySelector('[data-content]');

        hotspot.dataset.open = 'false';
        button.setAttribute('aria-expanded', 'false');

        gsap.to(content, {
            autoAlpha: 0,
            y:         10,
            duration:  0.25,
            ease:      'power2.in'
        });

        gsap.to(icon, {
            autoAlpha: 0,
            scale:     0.5,
            duration:  0.2,
            ease:      'power2.in'
        });

        gsap.to(plus, {
            autoAlpha: 1,
            scale:     1,
            duration:  0.35,
            delay:     0.1,
            ease:      'back.out(1.7)'
        });
    }
});