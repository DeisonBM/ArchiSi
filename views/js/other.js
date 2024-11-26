document.addEventListener('DOMContentLoaded', function() {
const container = document.querySelector('.container404');
const gearOuter = document.querySelector('.gear-outer404');
const gearInner = document.querySelector('.gear-inner404');

// Efecto de aparición
container.style.opacity = '0';
setTimeout(() => {
container.style.transition = 'opacity 0.5s ease-in-out';
container.style.opacity = '1';
}, 100);

// Interactividad con el engranaje
container.addEventListener('mousemove', function(e) {
const containerRect = container.getBoundingClientRect();
const centerX = containerRect.left + containerRect.width / 2;
const centerY = containerRect.top + containerRect.height / 2;

const angleOuter = Math.atan2(e.clientY - centerY, e.clientX - centerX);
const angleInner = -angleOuter * 1.5; // Giro inverso y más rápido

gearOuter.style.transform = `rotate(${angleOuter}rad)`;
gearInner.style.transform = `rotate(${angleInner}rad)`;
});

// Restablecer la animación cuando el ratón sale del contenedor
container.addEventListener('mouseleave', function() {
gearOuter.style.animation = 'none';
gearInner.style.animation = 'none';
setTimeout(() => {
    gearOuter.style.animation = 'spin 10s linear infinite';
    gearInner.style.animation = 'spin-reverse 5s linear infinite';
}, 50);
});
});


