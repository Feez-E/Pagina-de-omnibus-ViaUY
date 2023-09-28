// Selecciona todos los elementos input dentro del formulario con el id 'accSettingsForm'
const accSettingsInputs = document.querySelectorAll('#accSettingsForm input');

// Añade una función para el evento 'blur' (cuando pierden el foco) en cada input
accSettingsInputs.forEach(input => {
    input.onblur = function () {
        // Elimina espacios en blanco al principio y al final del valor del input
        input.value = input.value.trim();
    }
});

// Selecciona todas las imágenes con la clase 'feather-tool' (ícono de herramienta)
const modify = document.querySelectorAll(".feather-tool");

// Añade una función para el evento 'click' en cada imagen
modify.forEach(mod => {
    mod.onclick = () => {
        // Elimina el atributo 'readonly' del elemento hermano anterior de la imagen (input)
        mod.previousElementSibling.removeAttribute("readonly");
        // Agrega la clase 'editable' al elemento padre de la imagen (label)
        mod.parentNode.classList.add("editable");
        // Agrega la clase 'shown' al último hijo del elemento padre del padre de la imagen (boton de enviar formulario)
        mod.parentNode.parentNode.lastElementChild.classList.add("shown");
    };
});

// Selecciona el elemento con el id 'passwordCancel' (x dentro dentro del contenedor con la clase 'passwordSection')
// y el elemento con la clase '.button' dentro de un contenedor con clase '.passwordSection' dentro de un contenedor con id 'form' (boton de enviar formulario)
let passwordCancel = document.querySelector('#passwordCancel');
let passwordButton = document.querySelector('.container#form .passwordSection > .button');

// Añade una función para el evento 'click' en los elementos seleccionados
passwordCancel.onclick = passwordButton.onclick = () => {
    // Alterna la clase 'active' en el elemento padre de 'passwordButton' (contenedor con la clase 'passwordSection')
    passwordButton.parentNode.classList.toggle('active');
}