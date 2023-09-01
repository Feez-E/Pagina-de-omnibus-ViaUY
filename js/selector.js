let menuToggle = document.querySelector('.menuToggle');
let menu = document.querySelector('.menu');
menuToggle.onclick = function(){
    menu.classList.toggle('active')
}

let userName = document.querySelector('.userName');
let loginToggle = document.querySelector('#loginToggle');
let pageCover = document.querySelector('#pageCover');
let loginPanel = document.querySelector('#loginPanel');
userName.onclick = function(){
    pageCover.classList.toggle('active')
}

loginToggle.onclick = function(){
    pageCover.classList.toggle('active')
}

pageCover.onclick = function(){
    x=event.clientX;
    y=event.clientY;
    if (x < (visualViewport.width-(loginPanel.clientWidth))/2 ||
        x > (loginPanel.clientWidth)+(visualViewport.width-(loginPanel.clientWidth))/2 || 
        y < (visualViewport.height-(loginPanel.clientHeight))/2 || 
        y > (loginPanel.clientHeight)+(visualViewport.height-(loginPanel.clientHeight))/2){
        pageCover.classList.toggle('active')
    }

}

let registerButton = document.querySelector('.registerSide.hidden .loginButton');
let loginButton = document.querySelector('.loginSide.hidden .loginButton');
registerButton.onclick = loginButton.onclick  = () => {
    loginButton.parentNode.classList.toggle('active'); // loginSideHidden
    loginButton.parentElement.previousElementSibling.classList.toggle('active'); // loginSideShown
    registerButton.parentNode.classList.toggle('active'); // registerSideHidden
    registerButton.parentElement.previousElementSibling.classList.toggle('active'); // registerSideShown
}