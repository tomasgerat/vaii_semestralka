export class User {
    constructor(app, checkLogin = true, checkEmail = true, checkPassword = true) {
        this.app = app;
        this.loginEl = document.getElementById("login");
        this.emailEl = document.getElementById("e_mail");
        this.passwordEl = document.getElementById("password");
        this.confirmPassEl = document.getElementById("confirmPass");

        this.app.changeSubmitBtnState();
        if(this.loginEl !== null && checkLogin === true) {
            console.log("Adding checkLogin listener");
            this.loginEl.addEventListener("input", () => { this.existLogin() });
        }
        if(this.emailEl !== null && checkEmail === true) {
            console.log("Adding checkEmail listener");
            this.emailEl.addEventListener("input", () => { this.existEmail() });
        }
        if(this.passwordEl !== null && this.confirmPassEl !== null && checkPassword === true) {
            console.log("Adding confirmPass listener");
            this.confirmPassEl.addEventListener("input", () => { this.comparePasswords() });
        }
    }

    comparePasswords() {
        if(this.passwordEl.value === this.confirmPassEl.value) {
            document.getElementById("err_confirmPass").innerText = "";
        } else {
            document.getElementById("err_confirmPass").innerText = "Passwords are different."
        }
        this.app.changeSubmitBtnState()
    }

    async existEmail() {
        try {
            let errorEl = document.getElementById("err_e_mail");
            errorEl.innerText = "";

            let emailData = this.emailEl.value;

            let response = await fetch("?c=User&a=existEmail", {
                method: 'POST', // or 'PUT'
                headers: {
                    'Accept': 'application/json, text/plain, */*',
                    'Content-Type': "application/json",
                    'X_REQUESTED_WITH':"xmlhttprequest"
                },
                body: JSON.stringify({
                    e_mail: emailData
                })
            });
            let data = await response.json();
            let errors = data.errors;
            if (errors.unknown !== undefined) {
                errorEl.innerText = errors.unknown;
            } else {
                console.log("Failed to check if e-mail exists.");
            }
            this.app.changeSubmitBtnState();
        } catch (e) {
            console.error('Chyba: ' + e.message);
        }
    }

    async existLogin() {
        try {
            let errorEl = document.getElementById("err_login");
            errorEl.innerText = "";

            let loginData = this.loginEl.value;

            let response = await fetch("?c=User&a=existLogin", {
                method: 'POST', // or 'PUT'
                headers: {
                    'Accept': 'application/json, text/plain, */*',
                    'Content-Type': "application/json",
                    'X_REQUESTED_WITH':"xmlhttprequest"
                },
                body: JSON.stringify({
                    login: loginData
                })
            });
            let data = await response.json();
            let errors = data.errors;
            if (errors.unknown !== undefined) {
                errorEl.innerText = errors.unknown;
            } else {
                console.log("Failed to check if login exists.");
            }
            this.app.changeSubmitBtnState();
        } catch (e) {
            console.error('Chyba: ' + e.message);
        }
    }
}

