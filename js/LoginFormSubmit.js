let loginForm = document.getElementById("loginForm");
loginForm.addEventListener("submit", (e) => {
  e.preventDefault();

  const username = document.getElementById("usernameL");
  const password = document.getElementById("passwordL");
  const usernameValue = username.value;
  const passwordValue = password.value

  switch (true) {
    case username.value == "":
      alert("username");
      break;
    case password.value == "":
      alert("password");
      break;
    default:
      
// Realizar la llamada AJAX a check_credentials.php
var xhr = new XMLHttpRequest();
xhr.open("POST", "./php/dataAccess/check_credentials.php", true);
xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
xhr.onreadystatechange = function() {
  console.log(xhr.responseText)
    if (xhr.readyState === 4 && xhr.status === 200) {
        var response = JSON.parse(xhr.responseText);
        console.log(response.isValid ? "Credenciales válidas" : "Credenciales inválidas");
        if(response.isValid){
          // Guardar información de sesión en localStorage
          localStorage.setItem("username", usernameValue);
          localStorage.setItem("password", passwordValue);

          document.getElementById('userNameText').innerHTML = `${usernameValue}`;
          document.getElementById('userNameText').parentElement.classList.toggle('logged');
          document.getElementById('userNameText').parentElement.nextElementSibling.classList.toggle('active');
          document.querySelector('.menuToggle').classList.toggle('active');
        }
    }
};
xhr.send("usernameL=" + encodeURIComponent(username.value) + "&passwordL=" + encodeURIComponent(password.value));
console.log(
    `This form has a username of ${username.value} and password of ${password.value}`
);


// Restablecer los campos después de la llamada AJAX
document.getElementById("usernameL").value = "";
document.getElementById("passwordL").value = "";
  }
});

let registerForm = document.getElementById("registerForm");

registerForm.addEventListener("submit", (e) => {
  e.preventDefault();

  let username = document.getElementById("usernameR");
  let name = document.getElementById("name");
  let lastname = document.getElementById("lastname");
  let birthdate = document.getElementById("birthdate");
  let email = document.getElementById("email");
  let phoneNumber = document.getElementById("phoneNumber");
  let passwordR = document.getElementById("passwordR");
  let passwordConfirm = document.getElementById("passwordConfirm");

  switch (true) {
    case username.value == "":
      alert("username");
      break;
    case name.value == "":
      alert("name");
      break;
    case lastname.value == "":
      alert("lastname");
      break;
    case birthdate.value == "":
      alert("birthdate");
      break;
    case email.value == "":
      alert("email");
      break;
    case phoneNumber.value == "":
      alert("phoneNumber");
      break;
    case passwordR.value == "":
      alert("password");
      break;
    case passwordConfirm.value == "":
      alert("passwordConfirm");
      break;
    default:

      console.log(
        `This form has a username of ${username.value} and password of ${passwordR.value}`
      );

      username.value = "";
      name.value = "";
      lastname.value = "";
      birthdate.value = "";
      email.value = "";
      phoneNumber.value = "";
      passwordR.value = "";
      passwordConfirm.value = "";
  }
});
