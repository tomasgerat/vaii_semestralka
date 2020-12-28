import {User} from "./User.js";

class RegisterApp  {
    constructor() {
        this.submitBtnEl = document.getElementById("submit");
        this.user = new User(this);
    }
    changeSubmitBtnState() {
        if(this.submitBtnEl === null) {
            return;
        }
        let emailErrEl = document.getElementById("err_e_mail");
        let loginErrEl = document.getElementById("err_login");
        let confirmPassErrEl = document.getElementById("err_confirmPass");
        let strEmail = emailErrEl === null ? "" : emailErrEl.innerText.trim();
        let strLogin = loginErrEl === null ? "" : loginErrEl.innerText.trim();
        let strConfirmPass = confirmPassErrEl === null ? "" : confirmPassErrEl.innerText.trim();
        if(strEmail === "" && strLogin === "" && strConfirmPass === "") {
            this.submitBtnEl.disabled = false;
        } else {
            this.submitBtnEl.disabled = true;
        }
    }
}

new RegisterApp();