document.querySelectorAll(".unitValidation").forEach(unitValidation => {
    unitValidation.onclick = () => {
        const unitNumber = unitValidation.parentElement.nextElementSibling.firstElementChild.innerHTML.split("° ")[1]
        console.log(unitNumber)

        const dataToSend = {
            numero: unitNumber
        }

        $.ajax({
            url: "busValidationToggle.php",
            type: "POST",
            data: dataToSend,
            success: (response) => {
                if (response === "success") {

                } else {
                    console.log("Error al procesar la solicitud.");
                    console.error(response);
                }
            },
            error: (xhr, _status, error) => {
                console.log("Error en la solicitud AJAX.");
                console.error(error);
                console.error(xhr);
            },
        });
    }


});