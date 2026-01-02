// ========================================
// CARRUSEL 3D - SERVICIOS CUPRA
// ========================================

document.addEventListener('DOMContentLoaded', function() {
    
    const cards = document.querySelectorAll('.carousel-card-3d');
    const indicators = document.querySelectorAll('.carousel-indicators-3d .indicator');
    const serviceTitle = document.querySelector('.service-title');
    const serviceDescription = document.querySelector('.service-description');
    
    // Datos de cada servicio
    const servicesData = [
        {
            title: 'CUPRA TASTING',
            description: 'Vive una experiencia sensorial única con platos exclusivos y coctelería inspirada en el ADN CUPRA.'
        },
        {
            title: 'EXPERIENCIA SIGNATURE',
            description: 'Vive una experiencia sensorial única con platos exclusivos y coctelería inspirada en el ADN CUPRA.'
        },
        {
            title: 'MAESTROS DEL SABOR',
            description: 'Vive una experiencia sensorial única con platos exclusivos y coctelería inspirada en el ADN CUPRA.'
        }
    ];
    
    let currentIndex = 0;
    
    // Función para actualizar las flechas según la posición
    function updateArrows() {
        cards.forEach(card => {
            const arrow = card.querySelector('.card-overlay i');
            if (arrow) {
                if (card.classList.contains('state-left')) {
                    arrow.className = 'bi bi-arrow-left';
                } else if (card.classList.contains('state-right')) {
                    arrow.className = 'bi bi-arrow-right';
                }
            }
        });
    }
    
    // Función para rotar el carrusel
    function rotateCarousel(direction) {
        // Determinar nuevo índice
        if (direction === 'next') {
            currentIndex = (currentIndex + 1) % 3;
        } else if (direction === 'prev') {
            currentIndex = (currentIndex - 1 + 3) % 3;
        }
        
        // Actualizar clases de las tarjetas
        cards.forEach((card, index) => {
            card.classList.remove('state-left', 'state-center', 'state-right');
            
            if (index === currentIndex) {
                card.classList.add('state-center');
            } else if (index === (currentIndex + 1) % 3) {
                card.classList.add('state-right');
            } else {
                card.classList.add('state-left');
            }
        });
        
        // Actualizar flechas según la nueva posición
        updateArrows();
        
        // Actualizar indicadores
        indicators.forEach((indicator, index) => {
            indicator.classList.toggle('active', index === currentIndex);
        });
        
        // Actualizar texto
        updateServiceInfo();
    }
    
    // Función para actualizar la información del servicio
    function updateServiceInfo() {
        const service = servicesData[currentIndex];
        serviceTitle.textContent = service.title;
        serviceDescription.textContent = service.description;
    }
    
    // Event listeners para las tarjetas
    cards.forEach((card, index) => {
        card.addEventListener('click', () => {
            const cardIndex = parseInt(card.getAttribute('data-index'));
            
            if (card.classList.contains('state-right')) {
                rotateCarousel('next');
            } else if (card.classList.contains('state-left')) {
                rotateCarousel('prev');
            }
        });
    });
    
    // Event listeners para los indicadores
    indicators.forEach((indicator, index) => {
        indicator.addEventListener('click', () => {
            const targetIndex = parseInt(indicator.getAttribute('data-index'));
            
            if (targetIndex !== currentIndex) {
                currentIndex = targetIndex;
                
                // Actualizar clases
                cards.forEach((card, cardIndex) => {
                    card.classList.remove('state-left', 'state-center', 'state-right');
                    
                    if (cardIndex === currentIndex) {
                        card.classList.add('state-center');
                    } else if (cardIndex === (currentIndex + 1) % 3) {
                        card.classList.add('state-right');
                    } else {
                        card.classList.add('state-left');
                    }
                });
                
                // Actualizar flechas según la nueva posición
                updateArrows();
                
                // Actualizar indicadores
                indicators.forEach((ind, indIndex) => {
                    ind.classList.toggle('active', indIndex === currentIndex);
                });
                
                // Actualizar texto
                updateServiceInfo();
            }
        });
    });
    
    // Inicializar flechas al cargar
    updateArrows();
    
});
