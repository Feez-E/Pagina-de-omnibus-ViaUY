let loginForm = document.getElementById("loginForm");
loginForm.addEventListener("submit", (e) => {
  e.preventDefault();

  let username = document.getElementById("usernameL");
  let password = document.getElementById("passwordL");

  switch (true) {
    case username.value == "":
      alert("username");
      break;
    case password.value == "":
      alert("password");
      break;
    default:
      alert("successfully submitted");
      console.log(
        `This form has a username of ${username.value} and password of ${password.value}`
      );

      username.value = "";
      password.value = "";
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
      alert("successfully submitted");
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
