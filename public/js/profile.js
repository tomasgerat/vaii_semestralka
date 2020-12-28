import {User} from "./User.js";

class RegisterApp  {
    constructor() {
        this.submitBtnInfoEl = document.getElementById("submitInfo");
        this.submitBtnPaswordEl = document.getElementById("submitPassword");
        this.user = new User(this, false, true, true);
    }
    changeSubmitBtnState() {

        let emailErrEl = document.getElementById("err_e_mail");
        let confirmPassErrEl = document.getElementById("err_confirmPass");
        let strEmail = emailErrEl === null ? "" : emailErrEl.innerText.trim();
        let strConfirmPass = confirmPassErrEl === null ? "" : confirmPassErrEl.innerText.trim();
        if(strEmail === "" && this.submitBtnEl !== null) {
            this.submitBtnInfoEl.disabled = false;
        } else {
            this.submitBtnInfoEl.disabled = true;
        }
        if(strConfirmPass === "" && this.submitBtnEl !== null) {
            this.submitBtnPaswordEl.disabled = false;
        } else {
            this.submitBtnPaswordEl.disabled = true;
        }
    }
}

new RegisterApp();