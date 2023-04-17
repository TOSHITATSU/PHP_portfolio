'use strict';

function showPassword() {
  let pass = document.getElementById("show-password");
  if (pass.type === "password") {
    pass.type = "text";
  } else {
    pass.type = "password";
  }
}

document.getElementById("show-password").addEventListener("change", function() {
  let pass = document.getElementById("show-password");
  if (this.checked) {
    pass.type = "text";
  } else {
    pass.type = "password";
  }
});