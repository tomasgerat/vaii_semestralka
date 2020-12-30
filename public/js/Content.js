import {Err} from "./Err.js";

class Topic {
    constructor() {
        this.deletingId = -1;
        document.getElementById('confirmedDeleteBtn').addEventListener("click",
            () => { this.deleteTopic() });
        for (let i = 0; i < 10; i++) {
            this.addDeleteBtnHandle(i);
        }
    }

    async deleteTopic() {
        $('#deleteModal').modal('hide');
        Err.setText("err_delete", "");
        let t_id = document.getElementById("topicID_" + this.deletingId.toString()).innerText.trim();
        console.log("Deleting topic " + this.deletingId + " t_id: " + t_id);
        try{
            let response = await fetch("?c=Topic&a=delete&id=" + t_id, {
                method: 'POST', // or 'PUT'
                headers: {
                    'Accept': 'application/json, text/plain, */*',
                    'Content-Type': "application/json",
                    'X_REQUESTED_WITH':"xmlhttprequest"
                }
            });
            let data = await response.json();
            let errors = data.errors;
            if (errors.unknown !== undefined) {

                Err.setText("err_delete", errors.unknown);
                window.scrollTo(0,0);
            } else {
                location.reload();
            }

        } catch (e) {
            console.error('Chyba: ' + e.message);
        }
    }

    deleteHndl(i) {
        //console.log("delete tu" + i);
        this.deletingId = i;
        $('#deleteModal').modal('show');
    }

    addDeleteBtnHandle(i) {
        console.log("Adding delete handler: " + i.toString())
        let delBtnEl = document.getElementById("deleteBtn_"+i.toString());
        if(delBtnEl === null)
            return;
        delBtnEl.addEventListener("click", () => { this.deleteHndl(i); });
    }
}

class App {
    constructor() {
        document.addEventListener('DOMContentLoaded', () => { this.onDocumentLoad() }, false);
    }

    onDocumentLoad() {
        this.topic = new Topic();

        this.unknowErrEl = document.getElementById("err_unknown");
        this.deleteErrEl = document.getElementById("err_delete");
        if(this.unknowErrEl!==null) {
            if (this.unknowErrEl.innerText.trim().length === 0)
                this.unknowErrEl.hidden = true;
        }
        if(this.deleteErrEl!==null) {
            if (this.deleteErrEl.innerText.trim().length === 0)
                this.deleteErrEl.hidden = true;
        }
    }

}


let app = new App();