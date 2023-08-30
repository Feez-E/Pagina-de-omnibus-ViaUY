const inputs = document.querySelectorAll('input');
inputs.forEach( input=>{
    input.onfocus = ()=>{
        input.previousElementSibling.classList.add('top');
        input.previousElementSibling.classList.add('focus');
        input.parentNode.classList.add('focus');
        input.parentNode.classList.add('top');
    }
    input.onblur = function(){
        input.value = input.value.trim();
        if (input.value.trim().length == 0){
            input.previousElementSibling.classList.remove('top');
            input.parentNode.classList.remove('top');
        }
        input.previousElementSibling.classList.remove('focus');
        input.parentNode.classList.remove('focus');
    }
});

let loginEye = document.querySelector('#loginForm label svg.eye');
loginEye.onclick = function (){
    loginEye.classList.toggle('shown');
    if(document.getElementById('passwordL').type == 'password'){
        document.getElementById('passwordL').type = "text";
    } else{
        document.getElementById('passwordL').type = "password";
    }
    
}

let registerEye = document.querySelector('#registerForm label svg.eye');
registerEye.onclick = function (){
    registerEye.classList.toggle('shown');
    if(document.getElementById('passwordR').type == 'password'){
        document.getElementById('passwordR').type = "text";
        document.getElementById('passwordConfirm').type = "text";
    } else{
        document.getElementById('passwordR').type = "password";
        document.getElementById('passwordConfirm').type = "password";
    }
    
}