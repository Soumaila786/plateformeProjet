document.addEventListener('DOMContentLoaded', () => {

    // ── Animations au scroll (IntersectionObserver) ──
    const elementsReveal = document.querySelectorAll('.ac-reveal');
    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                const delai = parseInt(entry.target.dataset.delay || '0', 10);
                setTimeout(() => entry.target.classList.add('ac-reveal-visible'), delai);
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.15 });
    elementsReveal.forEach((el) => observer.observe(el));

    // ── Carrousel des domaines ──
    const track = document.getElementById('acCarouselTrack');
    if (!track) return;

    const viewport = track.parentElement;
    const cards = Array.from(track.children);
    const dotsWrap = document.getElementById('acCarouselDots');
    const btnPrev = document.querySelector('.ac-carousel-prev');
    const btnNext = document.querySelector('.ac-carousel-next');

    let cardsParVue = 3;
    let pageActuelle = 0;
    let minuteur = null;

    function calculerCardsParVue() {
        const largeur = window.innerWidth;
        if (largeur <= 575) return 1;
        if (largeur <= 900) return 2;
        return 3;
    }

    function totalPages() {
        return Math.ceil(cards.length / cardsParVue);
    }

    function construireDots() {
        dotsWrap.innerHTML = '';
        for (let i = 0; i < totalPages(); i++) {
            const dot = document.createElement('button');
            dot.type = 'button';
            dot.className = 'ac-carousel-dot' + (i === pageActuelle ? ' is-active' : '');
            dot.setAttribute('aria-label', 'Aller à la page ' + (i + 1));
            dot.addEventListener('click', () => allerA(i));
            dotsWrap.appendChild(dot);
        }
    }

    function majDots() {
        dotsWrap.querySelectorAll('.ac-carousel-dot').forEach((dot, i) => {
            dot.classList.toggle('is-active', i === pageActuelle);
        });
    }

    function deplacer() {
        const largeurVue = viewport.offsetWidth;
        track.style.transform = `translateX(-${pageActuelle * largeurVue}px)`;
        majDots();
    }

    function allerA(page) {
        const total = totalPages();
        pageActuelle = (page + total) % total;
        deplacer();
        redemarrerAutoplay();
    }

    function suivant() { allerA(pageActuelle + 1); }
    function precedent() { allerA(pageActuelle - 1); }

    function demarrerAutoplay() {
        minuteur = setInterval(suivant, 4500);
    }
    function redemarrerAutoplay() {
        clearInterval(minuteur);
        demarrerAutoplay();
    }

    function initialiser() {
        cardsParVue = calculerCardsParVue();
        pageActuelle = Math.min(pageActuelle, totalPages() - 1);
        construireDots();
        deplacer();
    }

    btnPrev?.addEventListener('click', precedent);
    btnNext?.addEventListener('click', suivant);

    // Pause au survol / reprise à la sortie
    const carousel = document.querySelector('.ac-carousel');
    carousel?.addEventListener('mouseenter', () => clearInterval(minuteur));
    carousel?.addEventListener('mouseleave', demarrerAutoplay);

    window.addEventListener('resize', () => {
        const nouveauCardsParVue = calculerCardsParVue();
        if (nouveauCardsParVue !== cardsParVue) {
            initialiser();
        } else {
            deplacer();
        }
    });

    initialiser();
    demarrerAutoplay();
});
