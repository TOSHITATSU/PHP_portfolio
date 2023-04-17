'use strict';

function showPassword() {
  let pass = document.getElementById("show-password");
  if (pass !== null) {
    if (pass.type === "password") {
      pass.type = "text";
    } else {
      pass.type = "password";
    }
  }
}

function showPassword2() {
  let pass = document.getElementById("show-password2");
  if (pass !== null) {
    if (pass.type === "password") {
      pass.type = "text";
    } else {
      pass.type = "password";
    }
  }
}

document.getElementById("show-password").addEventListener("change", function() {
  let pass = document.getElementById("show-password");
  let pass2 = document.getElementById("show-password2");
  if (this.checked) {
    pass.type = "text";
    pass2.type = "text";
  } else {
    pass.type = "password";
    pass2.type = "password";
  }
});