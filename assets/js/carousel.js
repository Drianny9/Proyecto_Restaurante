// ===== NAVBAR SCROLL EFFECT =====
window.addEventListener('scroll', function() {
    const navbar = document.querySelector('.navbar');
    if (window.scrollY > 50) {
        navbar.classList.add('scrolled');
    } else {
        navbar.classList.remove('scrolled');
    }
});

// ===== CARRUSEL AUTOMÁTICO =====
document.addEventListener('DOMContentLoaded', function() {
    const track = document.getElementById('carouselTrack');
    const items = document.querySelectorAll('.carousel-item');
    
    if (!track || items.length === 0) return;
    
    let currentIndex = 0;
    const itemWidth = 250; // ancho del item + gap
    const gap = 32; // 2rem en pixels
    const totalWidth = itemWidth + gap;
    const autoScrollInterval = 3000; // 3 segundos
    
    // Duplicar items para scroll infinito
    const clone = track.innerHTML;
    track.innerHTML += clone;
    
    // Función para mover el carrusel
    function moveCarousel() {
        currentIndex++;
        const offset = -(currentIndex * totalWidth);
        track.style.transform = `translateX(${offset}px)`;
        
        // Reset cuando llegue al final del primer set
        if (currentIndex >= items.length) {
            setTimeout(() => {
                track.style.transition = 'none';
                currentIndex = 0;
                track.style.transform = 'translateX(0)';
                setTimeout(() => {
                    track.style.transition = 'transform 0.5s ease';
                }, 50);
            }, 500);
        }
    }
    
    // Auto scroll
    let autoScroll = setInterval(moveCarousel, autoScrollInterval);
    
    // Pausar en hover
    track.addEventListener('mouseenter', function() {
        clearInterval(autoScroll);
    });
    
    track.addEventListener('mouseleave', function() {
        autoScroll = setInterval(moveCarousel, autoScrollInterval);
    });
    
    // Click en item (opcional: redirigir o mostrar detalle)
    items.forEach((item, index) => {
        item.addEventListener('click', function() {
            console.log(`Producto ${index + 1} clickeado`);
            // Aquí puedes añadir lógica para redirigir o mostrar modal
        });
    });
});

// ===== SMOOTH SCROLL PARA ANCLAS =====
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            target.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }
    });
});
