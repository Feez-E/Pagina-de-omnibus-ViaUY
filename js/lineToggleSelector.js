// Selecciona todos los elementos con el id 'lineToggle' (flechas para expandir una linea)
const lineToggles = document.querySelectorAll('#lineToggle');

// Añade una función para el evento 'click' en cada elemento con el id 'lineToggle'
lineToggles.forEach(lineToggle => {
    lineToggle.onclick = () => {
        // Alterna la clase 'active' en el elemento padre del elemento padre de 'lineToggle' (dos niveles hacia arriba)
        lineToggle.parentElement.parentElement.classList.toggle('active');
    }
});