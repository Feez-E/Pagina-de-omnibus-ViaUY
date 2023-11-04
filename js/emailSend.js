
let dataToSend = {
    fecha: fecha,
    msg: msg,
    email: email
};

$.ajax({
    url: "emailSender.php",
    type: "POST",
    data: dataToSend,
    success: (response) => {

        if (response.status === "success") {
            console.log("Email enviado con exito")
        } else if (response.status === "error") {
            console.log("Error al enviar el mail.");
            console.log(response.errorMesssage);
        } else {
            console.log("Error al procesar la solicitud.");
            console.log(response);
        }

        messageSpan = document.getElementById("message");
        messageSpan.innerHTML = response.message;

    },
    error: (xhr, _status, error) => {
        console.log("Error en la solicitud AJAX.");
        console.error(error);
        console.error(xhr.responseText);
    },
});