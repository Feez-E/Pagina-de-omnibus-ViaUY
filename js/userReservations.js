
document.querySelectorAll('.declineReserve').forEach((button, index)=>{

    button.onclick = ()=>{
        console.log(tiquetsReserva[index]);
    }
});