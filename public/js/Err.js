export class Err {
    static setText(id, text)
    {
        let errEl = document.getElementById(id);
        if(errEl !== null) {
            errEl.innerText = text;
            if (text.trim().length === 0) {
                errEl.hidden = true;
            }
            else {
                errEl.hidden = false;
            }
        }
    }
}