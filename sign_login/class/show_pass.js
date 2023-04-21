'use strict';

class PasswordToggler {
  constructor(passwordInputId, toggleButtonId) {
    this.passwordInput = document.getElementById(passwordInputId);
    this.toggleButton = document.getElementById(toggleButtonId);

    this.toggleButton.addEventListener("click", () => {
      if (this.passwordInput.type === "password") {
        this.passwordInput.type = "text";
        this.toggleButton.textContent = "非表示";
      } else {
        this.passwordInput.type = "password";
        this.toggleButton.textContent = "表示";
      }
    });
  }
}

class PasswordSignToggler {
  constructor(passwordInputId, passwordSignInputId) {
    this.passwordToggler = new PasswordToggler(passwordInputId, "toggle-password");
    this.passwordSignToggler = new PasswordToggler(passwordSignInputId, "toggle-password-sign");
  }
}



class PasswordLoginToggler {
  constructor(passwordInputId) {
    this.passwordInput = document.getElementById(passwordInputId);
    this.toggleButton = document.getElementById("toggle-password");

    this.toggleButton.addEventListener("click", () => {
      if (this.passwordInput.type === "password") {
        this.passwordInput.type = "text";
        this.toggleButton.textContent = "非表示";
      } else {
        this.passwordInput.type = "password";
        this.toggleButton.textContent = "表示";
      }
    });
  }
}

