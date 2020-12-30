class App {
    constructor() {
        document.addEventListener('DOMContentLoaded', () => { this.onDocumentLoad() }, false);
    }

    onDocumentLoad() {
        CKEDITOR.replace('text',{
                toolbar :
                    [
                        ['Bold','Italic','Underline','Strike', 'Subscript','Superscript'],
                        ['Undo','Redo'],
                        ['Link'],
                        ['Format']
                    ],
                width: "100%",
                height: "200px"
            }
        );
    }
}

let app = new App();
