/*
 | Plain JavaScript for the public website.
 | It does the jobs that Angular did before: menu, scroll effect, tabs and lightbox.
 */

/* ---------- 0. Page loader (hide only after full page load) ---------- */
const pageLoader = document.getElementById('pageLoader');
if (pageLoader) {
    const hideLoader = () => {
        pageLoader.classList.add('is-hidden');
    };
    if (document.readyState === 'complete') {
        hideLoader();
    } else {
        window.addEventListener('load', hideLoader);
    }
}

/* ---------- 1. Navbar + mobile menu ---------- */
const header = document.getElementById('siteHeader');

if (header) {
    const button = header.querySelector('[data-menu-toggle]');
    const menu = header.querySelector('[data-menu]');

    function setMenu(open) {
        menu.classList.toggle('popup-open', open);
        header.classList.toggle('menu-open', open);
        button.classList.toggle('burger-open', open);
        button.setAttribute('aria-expanded', open);
        button.setAttribute('aria-label', open ? 'Close menu' : 'Open menu');
        document.body.style.overflow = open ? 'hidden' : ''; // stop background scrolling
    }

    button.addEventListener('click', () => setMenu(!menu.classList.contains('popup-open')));
    header.querySelectorAll('[data-menu-close]').forEach((link) => link.addEventListener('click', () => setMenu(false)));
}

/* ---------- 2. Scroll effects ---------- */
const heroFrame = document.getElementById('heroFrame');
const whatWeDo = document.getElementById('whatWeDo');
const statements = document.querySelectorAll('.statement');

function onScroll() {
    const scrolled = window.scrollY > 8;

    // Header becomes solid after scrolling (inner pages are always solid)
    if (header && header.dataset.home === '1') {
        header.classList.toggle('scrolled', scrolled);
    }

    // The hero video grows to full screen
    if (heroFrame) {
        heroFrame.classList.toggle('expanded', scrolled);
    }

    // Change the statement text while scrolling
    if (whatWeDo && statements.length > 0) {
        const rect = whatWeDo.getBoundingClientRect();
        const scrollable = rect.height - window.innerHeight;
        const done = Math.min(Math.max(-rect.top, 0), scrollable);
        const progress = scrollable > 0 ? done / scrollable : 0; // number from 0 to 1
        const active = Math.min(statements.length - 1, Math.floor(progress * statements.length));

        document.getElementById('progressBar').style.transform = `scaleX(${progress})`;
        document.getElementById('statementNumber').textContent = String(active + 1).padStart(2, '0');
        statements.forEach((item, i) => {
            item.classList.toggle('is-active', i === active);
            item.setAttribute('aria-hidden', i !== active);
        });
    }
}

window.addEventListener('scroll', onScroll);
window.addEventListener('resize', onScroll);
onScroll(); // run once when the page opens

/* ---------- 3. Portfolio tabs ---------- */
const tabs = document.querySelectorAll('[data-tab]');

tabs.forEach((tab) => {
    tab.addEventListener('click', () => {
        tabs.forEach((other) => {
            other.classList.toggle('is-active', other === tab);
            other.setAttribute('aria-selected', other === tab);
        });
        // Show only the panel with the same name as the clicked tab
        document.querySelectorAll('[data-panel]').forEach((panel) => {
            panel.hidden = panel.dataset.panel !== tab.dataset.tab;
        });
    });
});

/* ---------- 4. Lightbox (full screen image) ---------- */
const lightbox = document.getElementById('lightbox');

if (lightbox) {
    const bigImage = document.getElementById('lightboxImage');

    function closeLightbox() {
        lightbox.hidden = true;
        document.body.style.overflow = '';
        document.body.classList.remove('lightbox-open');
    }

    document.querySelectorAll('[data-lightbox]').forEach((item) => {
        item.addEventListener('click', () => {
            const image = item.querySelector('img');
            bigImage.src = image.src;
            bigImage.alt = image.alt;
            lightbox.hidden = false;
            document.body.style.overflow = 'hidden';
            document.body.classList.add('lightbox-open');
        });
    });

    // Close when clicking anywhere except the big image
    lightbox.addEventListener('click', (event) => {
        if (event.target !== bigImage) closeLightbox();
    });

    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape') closeLightbox();
    });
}

/* ---------- 5. Footer "Top" button ---------- */
document.querySelector('[data-scroll-top]')?.addEventListener('click', () => {
    window.scrollTo({ top: 0, behavior: 'smooth' });
});

/* ---------- 6. Show / Hide password on login pages ---------- */
document.querySelectorAll('[data-toggle-password]').forEach((button) => {
    button.addEventListener('click', () => {
        const input = document.getElementById(button.dataset.togglePassword);
        const show = input.type === 'password';
        input.type = show ? 'text' : 'password';
        button.textContent = show ? 'Hide' : 'Show';
    });
});
