
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
        let unknowErrorEl = document.getElementById("err_delete");
        unknowErrorEl.innerText = "";
        let c_id = document.getElementById("topicID_" + this.deletingId.toString()).innerText.trim();
        console.log("Deleting comment " + this.deletingId + " c_id: " + c_id);
        try{
            let response = await fetch("?c=Topic&a=delete&id=" + c_id, {
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
                unknowErrorEl.innerText += errors.unknown;
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
    }

}


let app = new App();