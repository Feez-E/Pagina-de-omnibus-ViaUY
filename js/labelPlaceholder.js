// Selecciona todos los elementos input en la página
const inputs = document.querySelectorAll('input:not([type="checkbox"])');

// Añade funciones para los eventos 'focus' y 'blur' en cada input
inputs.forEach(input => {
    input.onfocus = () => {
        // Agrega las clases 'top' y 'focus' al elemento hermano anterior, así como a su elemento padre (label y span)
        input.previousElementSibling.classList.add('top', 'focus');
        input.parentNode.classList.add('focus', 'top');
    }

    input.onblur = function () {
        // Elimina espacios en blanco al principio y al final del valor del input
        input.value = input.value.trim();

        if (input.value.trim().length === 0) {
            // Si el valor está vacío, elimina las clases 'top' del elemento hermano anterior y su elemento padre (label y span)
            input.previousElementSibling.classList.remove('top');
            input.parentNode.classList.remove('top');
        }

        // Elimina la clase 'focus' del elemento hermano anterior y su elemento padre (label y span)
        input.previousElementSibling.classList.remove('focus');
        input.parentNode.classList.remove('focus');
    }
});

// Selecciona el icono de ojo dentro del elemento con el id 'loginForm' y su correspondiente label
let loginEye = document.querySelector('#loginForm label svg.eye');

// Añade una función para el evento 'click' en el icono de ojo de inicio de sesión
loginEye.onclick = function () {
    // Alterna la clase 'shown' en el icono de ojo
    loginEye.classList.toggle('shown');

    // Cambia el tipo de input de contraseña entre 'password' y 'text'
    const passwordInput = document.getElementById('passwordL');
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
    } else {
        passwordInput.type = 'password';
    }
}

// Selecciona el icono de ojo dentro del elemento con el id 'registerForm' y su correspondiente label
let registerEye = document.querySelector('#registerForm label svg.eye');

// Añade una función para el evento 'click' en el icono de ojo de registro
registerEye.onclick = function () {
    // Alterna la clase 'shown' en el icono de ojo
    registerEye.classList.toggle('shown');

    // Cambia el tipo de input de contraseña entre 'password' y 'text' para ambas contraseñas
    const passwordInputR = document.getElementById('passwordR');
    const passwordConfirmInput = document.getElementById('passwordConfirm');

    if (passwordInputR.type === 'password') {
        passwordInputR.type = 'text';
        passwordConfirmInput.type = 'text';
    } else {
        passwordInputR.type = 'password';
        passwordConfirmInput.type = 'password';
    }
}
