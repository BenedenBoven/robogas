// ───────────────────────────────────────────────
// Navigatie smart sticky scroll
// ───────────────────────────────────────────────

document.addEventListener('DOMContentLoaded', function() {

    const nav                   = document.getElementById('nav');
    const logo                  = document.getElementById('nav-logo');
    const servicesDropdownGroup = document.querySelector('.services-dropdown-trigger')?.closest('.group');

    if(!nav) {
        console.warn('Navbar element niet gevonden.');
        return;
    }

    let lastScroll = 0;

    // ───────────────────────────────────────────────
    // Logo shrink functie
    // ───────────────────────────────────────────────

    function updateLogoState() {

        if(!logo) return;

        const scrollTop = window.scrollY || document.documentElement.scrollTop;

        if(scrollTop > 0) {
            logo.classList.add('nav-logo-shrink');
        } else {
            logo.classList.remove('nav-logo-shrink');
        }

    }

    // ───────────────────────────────────────────────
    // Eerste load check
    // ───────────────────────────────────────────────

    requestAnimationFrame(() => {
        updateLogoState();
    });

    // ───────────────────────────────────────────────
    // Services dropdown hover: nav altijd zichtbaar
    // ───────────────────────────────────────────────

    if(servicesDropdownGroup) {

        servicesDropdownGroup.addEventListener('mouseenter', () => {
            nav.style.transform = 'translateY(0)';
        });

    }

    // ───────────────────────────────────────────────
    // Desktop scroll behaviour
    // ───────────────────────────────────────────────

    window.addEventListener('scroll', () => {

        const currentScroll = window.pageYOffset || document.documentElement.scrollTop;

        updateLogoState();

        if(currentScroll <= 0) {

            nav.style.transform = 'translateY(0)';
            lastScroll          = 0;

            return;

        }

        if(currentScroll > lastScroll) {

            // Naar beneden scrollen
            nav.style.transform = 'translateY(-100%)';

        } else {

            // Naar boven scrollen
            nav.style.transform = 'translateY(0)';

        }

        lastScroll = currentScroll <= 0 ? 0 : currentScroll;

    });

    // ───────────────────────────────────────────────
    // Mouse near top of screen: show nav
    // ───────────────────────────────────────────────

    window.addEventListener('mousemove', (e) => {

        if(e.clientY < 100) {
            nav.style.transform = 'translateY(0)';
        }

    });

});


// ───────────────────────────────────────────────
// Mobiele navigatie toggle met animatie
// ───────────────────────────────────────────────

const toggleButton = document.getElementById('mobile-menu-toggle');
const mobileMenu   = document.getElementById('mobile-menu');
const openIcon     = toggleButton?.querySelector('svg:nth-child(1)');
const closeIcon    = toggleButton?.querySelector('svg:nth-child(2)');
const nav          = document.getElementById('nav');
const logo         = document.getElementById('nav-logo');

let isOpen        = false;
let lastScrollTop = 0;

// ───────────────────────────────────────────────
// Logo update functie mobiel
// ───────────────────────────────────────────────

function updateLogoState() {

    const scrollTop = window.scrollY || document.documentElement.scrollTop;

    if(scrollTop > 0) {
        logo?.classList.add('nav-logo-shrink');
    } else {
        logo?.classList.remove('nav-logo-shrink');
    }

}

// ───────────────────────────────────────────────
// Mobile menu toggle
// ───────────────────────────────────────────────

toggleButton?.addEventListener('click', () => {

    isOpen = !isOpen;

    if(isOpen) {

        mobileMenu?.classList.remove('hidden');

        requestAnimationFrame(() => {

            mobileMenu?.classList.add(
                'opacity-100',
                'max-h-[1000px]'
            );

            mobileMenu?.classList.remove(
                'opacity-0',
                'max-h-0'
            );

        });

        openIcon?.classList.add('hidden');
        closeIcon?.classList.remove('hidden');

        nav?.style.setProperty('transform', 'translateY(0)');

    } else {

        mobileMenu?.classList.add(
            'opacity-0',
            'max-h-0'
        );

        mobileMenu?.classList.remove(
            'opacity-100',
            'max-h-[1000px]'
        );

        setTimeout(() => {
            mobileMenu?.classList.add('hidden');
        }, 300);

        openIcon?.classList.remove('hidden');
        closeIcon?.classList.add('hidden');

        requestAnimationFrame(() => {
            updateLogoState();
        });

    }

});

mobileMenu?.classList.add('hidden');


// ───────────────────────────────────────────────
// Mobile scroll behaviour
// ───────────────────────────────────────────────

window.addEventListener('scroll', () => {

    const currentScroll = window.pageYOffset || document.documentElement.scrollTop;

    if(!nav) return;

    updateLogoState();

    if(isOpen) {

        nav.style.transform = 'translateY(0)';

        lastScrollTop = currentScroll <= 0
            ? 0
            : currentScroll;

        return;

    }

    if(currentScroll > lastScrollTop) {

        nav.style.transform = 'translateY(-100%)';

    } else {

        nav.style.transform = 'translateY(0)';

    }

    lastScrollTop = currentScroll <= 0
        ? 0
        : currentScroll;

});