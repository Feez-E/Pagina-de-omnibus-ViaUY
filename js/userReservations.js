import { showError } from './components.js';
document.querySelectorAll('.declineReserve').forEach((button, index)=>{
    button.onclick = ()=>{
        const dataToSend = {
            codigo: tiquetsReserva[index]
        }

        $.ajax({
            url: "cancelUserReservation.php",
            type: "POST",
            data: dataToSend,
            success: (response) => {
                if (response.status === "success") {
                    showError(response.message);
                    setTimeout(() => {
                        button.style.display = 'none';
                        document.querySelector(`#id_${tiquetsReserva[index]} .ticketStatus`).innerHTML = 'Cancelado';
                    }, 500);
                    
                } else {
                    showError(response.message);
                }
            },
            error: (xhr, _status, error) => {
                console.error("Error en la solicitud AJAX: " + error);
            },
        });


    }
});