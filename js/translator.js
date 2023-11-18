
const flagsSwitch = document.getElementById("changeLanguage");


const changeLanguage = async language => {
    const textsToChange = document.querySelectorAll("[data-section]")
    const requestJson = await fetch(`/Proyecto Final/languages/${language}.json`)
    const texts = await requestJson.json()



    textsToChange.forEach(textToChange => {
        const section = textToChange.dataset.section;
        const value = textToChange.dataset.value;
        const elementType = textToChange.tagName.toLowerCase();

        if (elementType === 'input') {
            textToChange.value = texts[section][value];
        } else {

            textToChange.innerHTML = texts[section][value];
        }
    });

}


setTimeout(() => {
    flagsSwitch.checked ?
        changeLanguage("en") :
        changeLanguage("es");
}, 1);




flagsSwitch.onclick = () => {

    // Verifica el estado del interruptor de banderas
    var lang = flagsSwitch.checked ? "en" : "es";

    // Realiza una solicitud AJAX para actualizar la variable de sesión en el servidor
    $.ajax({
        type: 'POST',
        url: '/Proyecto Final/languages/changeLanguage.php',
        data: { lang: lang }
    });


    flagsSwitch.checked ?
        changeLanguage("en") :
        changeLanguage("es");

};

