const accSettingsInputs = document.querySelectorAll('#accSettingsForm input');
accSettingsInputs.forEach( inputS=>{
    inputS.onblur = function(){
        inputS.value = inputS.value.trim();
    }
});

const modify = document.querySelectorAll(".feather-tool");
modify.forEach((mod) => {
    mod.onclick = () => {
        mod.previousElementSibling.removeAttribute("readonly");
        mod.parentNode.classList.add("editable");
        mod.parentNode.parentNode.lastElementChild.classList.add("shown");
    };
});

let passwordCancel = document.querySelector('#passwordCancel');
let passwordButton = document.querySelector('.container#form .passwordSection > .button');
passwordCancel.onclick = passwordButton.onclick  = () => {
    passwordButton.parentNode.classList.toggle('active');
}