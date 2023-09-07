const lineToggles = document.querySelectorAll('#lineToggle');
lineToggles.forEach( lineToggle=>{
    lineToggle.onclick = () =>{
        lineToggle.parentElement.parentElement.classList.toggle('active')
    }
});