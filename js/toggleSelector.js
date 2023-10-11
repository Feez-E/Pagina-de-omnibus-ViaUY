// Selecciona todos los elementos con el id 'lineToggle' (flechas para expandir una linea)
const toggles = document.querySelectorAll('#toggleArrow');

// Añade una función para el evento 'click' en cada elemento con el id 'lineToggle'
toggles.forEach(toggle => {
    toggle.onclick = () => {
        // Alterna la clase 'active' en el elemento padre del elemento padre de 'lineToggle' (dos niveles hacia arriba)
        toggle.parentElement.parentElement.classList.toggle('active');
    }
});