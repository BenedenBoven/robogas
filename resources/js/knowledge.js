// ───────────────────────────────────────────────
// Onze kennis: filteren op thema en de kaarten over kolommen verdelen
// ───────────────────────────────────────────────
//
// De server zet de kaarten in drie kolommen. Na filteren, en op schermen waar
// minder kolommen passen, verdeelt dit script de zichtbare kaarten opnieuw, zodat
// de bovenste kaart van elke kolom de koepelvorm heeft en de hoogtes afwisselen.

const DOME  = 'rounded-t-[50%_120px]';
const TALL  = ['h-80', 'md:h-[400px]'];
const SHORT = ['h-72', 'md:h-[320px]'];

const columnCount = () => (window.matchMedia('(min-width: 80rem)').matches ? 3 : window.matchMedia('(min-width: 48rem)').matches ? 2 : 1);

const layout = (grid, theme) => {
    const columns = [...grid.querySelectorAll('[data-knowledge-column]')];
    const items   = [...grid.querySelectorAll('[data-knowledge-item]')].sort((a, b) => Number(a.dataset.order) - Number(b.dataset.order));
    const visible = items.filter((item) => theme === '' || item.dataset.theme === theme);
    const count   = columnCount();

    items.forEach((item) => { item.hidden = !visible.includes(item); });

    visible.forEach((item, index) => {
        const column = index % count;
        const row    = Math.floor(index / count);
        const card   = item.querySelector('[data-knowledge-card]');
        const shape  = item.querySelector('[data-knowledge-shape]');

        columns[column].appendChild(item);
        shape.classList.toggle(DOME, row === 0);
        card.classList.remove(...TALL, ...SHORT);
        card.classList.add(...(row % 2 === column % 2 ? TALL : SHORT));
    });

    items.filter((item) => item.hidden).forEach((item) => columns[0].appendChild(item));

    const empty = grid.parentElement.querySelector('[data-knowledge-empty]');
    empty?.classList.toggle('hidden', visible.length > 0);
};

const pressed = (buttons, active, on, off) => {
    buttons.forEach((button) => {
        const isActive = button === active;
        button.setAttribute('aria-pressed', String(isActive));
        button.classList.remove(...(isActive ? off : on));
        button.classList.add(...(isActive ? on : off));
    });
};

const grid = document.querySelector('[data-knowledge-grid]');

if(grid) {
    [...grid.querySelectorAll('[data-knowledge-item]')].forEach((item, index) => { item.dataset.order = String(index); });

    // De server verdeelde kolom voor kolom; de oorspronkelijke volgorde is rij voor rij.
    const perColumn = [...grid.querySelectorAll('[data-knowledge-column]')].map((column) => [...column.querySelectorAll('[data-knowledge-item]')]);
    const rows      = Math.max(...perColumn.map((column) => column.length));
    let order       = 0;
    for(let row = 0; row < rows; row++) {
        perColumn.forEach((column) => { if(column[row]) { column[row].dataset.order = String(order++); } });
    }

    let theme = '';
    const buttons = [...document.querySelectorAll('[data-knowledge-filter]')];

    buttons.forEach((button) => button.addEventListener('click', () => {
        theme = button.dataset.knowledgeFilter;
        pressed(buttons, button, ['text-yellow', 'font-extrabold', 'border-yellow'], ['text-white', 'font-medium', 'border-transparent']);
        layout(grid, theme);
    }));

    let width = window.innerWidth;
    window.addEventListener('resize', () => {
        if(window.innerWidth !== width) {
            width = window.innerWidth;
            layout(grid, theme);
        }
    });

    layout(grid, theme);
}

// Veelgestelde vragen: de themalijst laat één thema of alles zien.
const rail = document.querySelector('[data-faq-rail]');

if(rail) {
    const buttons = [...rail.querySelectorAll('[data-faq-filter]')];
    const groups  = [...document.querySelectorAll('[data-faq-group]')];

    buttons.forEach((button) => button.addEventListener('click', () => {
        const theme = button.dataset.faqFilter;
        groups.forEach((group) => { group.hidden = theme !== '' && group.dataset.faqGroup !== theme; });
        pressed(buttons, button, ['border-blue', 'text-blue', 'font-extrabold'], ['border-blue-light-300', 'text-black', 'font-medium']);
    }));
}
