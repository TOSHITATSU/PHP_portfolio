'use strict';

class PasswordSignToggler {
  constructor(id1, id2) {
    this.pass1 = document.getElementById(id1);
    this.pass2 = document.getElementById(id2);
    this.checkbox = document.querySelector(`[data-toggle-pass="${id1}"]`);
    
    this.checkbox.addEventListener("click", () => {
      this.toggle();
    });
  }
  
  toggle() {
    if (this.pass1 !== null && this.pass2 !== null) {
      if (this.checkbox.checked) {
        this.pass1.type = "text";
        this.pass2.type = "text";
      } else {
        this.pass1.type = "password";
        this.pass2.type = "password";
      }
    }
  }
}


class PasswordLoginToggler {
  constructor(id) {
    this.pass = document.getElementById(id);
    this.checkbox = document.querySelector(`[data-toggle-pass="${id}"]`);

    this.checkbox.addEventListener("click", () => this.toggle());
  }

  toggle() {
    if (this.checkbox.checked) {
      this.pass.type = "text";
    } else {
      this.pass.type = "password";
    }
  }
}
