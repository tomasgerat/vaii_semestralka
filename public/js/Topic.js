//import {strip_tags} from "./locutus.js";

import {Err} from "./Err.js";

const RELOAD_INTERVAL = 10000;


class Topic {
    constructor() {
        this.commentObj = new Comment(this);
       // this.reload();
        setInterval(() => this.reload(), RELOAD_INTERVAL);
        let delBtnEl = document.getElementById('deleteBtn_Topic');
        if(delBtnEl !== null)
            delBtnEl.addEventListener("click",() => { this.deleteHndl() });
        document.getElementById('confirmedDeleteBtnTopic').addEventListener("click",
            () => { this.deleteTopic() });
    }

    reload() {
        console.log("reload");
        let unknowErrorEl = document.getElementById("err_unknow");
        if(unknowErrorEl !== null)
            unknowErrorEl.innerText = "";
        this.loadTopic();
        this.loadPagination();
        this.loadComments();
    }

    deleteHndl() {
        //console.log("delete tu" + i);
        $('#deleteModalTopic').modal('show');
    }

    async deleteTopic() {
        $('#deleteModalTopic').modal('hide');
        Err.setText("err_deleteTopic", "");
        let t_id = document.getElementById("current_topic").innerText.trim();
        console.log("Deleting topic t_id: " + t_id);
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
                Err.setText("err_deleteTopic", errors.unknown);
                window.scrollTo(0,0);
            } else {
                window.location.href = "?c=Content&a=home";
            }

        } catch (e) {
            console.error('Chyba: ' + e.message);
        }
    }

    async loadTopic() {
        try {
            let current_topic = document.getElementById("current_topic").innerText;
            if (current_topic == null)
                return;
            let url = "?c=Topic&a=topic&id=";
            url = url + current_topic.toString();
            let response = await fetch(url);
            let data = await response.json();
            let topic = data.topic;
            let errors = data.errors;
            let unknowErrorEl = document.getElementById("err_unknow");
            if (errors.unknown !== undefined) {
                unknowErrorEl.innerText += errors.unknown;
            }
            let titleEl = document.getElementById("topic_title");
            let textEl = document.getElementById("topic_text");
            let createdEl = document.getElementById("topic_created")
            if(titleEl.innerText.trim() !== topic.title.trim())
                titleEl.innerText = topic.title;
            if(textEl.innerText.trim() !== topic.text.trim())
                textEl.innerHTML = topic.text;
            if(createdEl.innerText.trim() !== topic.created.trim())
                createdEl.innerText = topic.created;
        } catch (e) {
            console.error('Chyba: ' + e.message);
        }
    }

    async loadPagination() {
        try {
            let current_pageEL = document.getElementById("current_page");
            let current_page = 0;
            if(current_pageEL !== null)
                current_page = current_pageEL.innerText;
            let current_topic = document.getElementById("current_topic").innerText;
            if (current_topic == null)
                return;
            if (current_page == null)
                current_page = 0;
            let url = "?c=Topic&a=pagination&id=";
            url = url + current_topic.toString() + "&page=" + current_page.toString();
            let response = await fetch(url);
            let data = await response.json();
            let paginationHtml = data.pagination;
            let errors = data.errors;
            let unknowErrorEl = document.getElementById("err_unknow");
            if (errors.unknown !== undefined) {
                unknowErrorEl.innerText += errors.unknown;
            }
            let pagTop = document.getElementById("top_nav");
            let pagBottom = document.getElementById("bottom_nav");
            if(pagTop.innerText.trim() !== paginationHtml.trim())
                pagTop.innerHTML = paginationHtml;
            if(pagBottom.innerText.trim() !== paginationHtml.trim())
                pagBottom.innerHTML = paginationHtml;
        } catch (e) {
            console.error('Chyba: ' + e.message);
        }
    }

    async loadComments() {
        try {
            let current_pageEL = document.getElementById("current_page");
            let current_page = 0;
            if(current_pageEL !== null)
                current_page = current_pageEL.innerText;
            let current_topic = document.getElementById("current_topic").innerText;
            if (current_page == null)
                current_page = 0;
            if (current_topic == null)
                return;
            let url = "?c=Comment&a=index&id=";
            url = url + current_topic.toString()+ "&page=" + current_page.toString();
            let response = await fetch(url);
            let data = await response.json();

            let comments = data.comments;
            let errors = data.errors;
            let userId = data.user;
            let isAdmin = data.isAdmin;
            let commentsEl = document.getElementById("comments_holder");
            let unknowErrorEl = document.getElementById("err_unknow");
            let topicTitleEl = document.getElementById("topic_title");
            let topicTitle = "";
            if (errors.unknown !== undefined) {
                unknowErrorEl.innerText += errors.unknown;
            }
            if(topicTitleEl !== null)
                topicTitle = topicTitleEl.innerText;
            let html = "";
            let i = 0;
            comments.forEach((comment) => {
                if(this.commentObj.isChanged(comment, i, topicTitle) === true) {
                    html = this.commentObj.generateComment(comment, i, topicTitle, userId, isAdmin);
                    let commentEl = document.getElementById("comment_" + i.toString());
                    if(commentEl === null) {
                        let node = document.createElement("div");
                        node.classList.add("container");
                        node.classList.add("comment_frame");
                        node.id = "comment_"+i.toString();
                        node.innerHTML = html;
                        commentsEl.appendChild(node);
                    } else {
                        commentEl.innerHTML = html;
                    }
                    this.commentObj.addEditBtnHandler(i);
                    this.commentObj.addDeleteBtnHandle(i);
                }
                i++;
            });
            for (; i < 10; i++) {
                let commentEl = document.getElementById("comment_" + i.toString());
                if(commentEl !== null)
                    commentEl.remove();
            }
        } catch (e) {
            console.error('Chyba: ' + e.message);
        }
    }


}

class Comment {

    constructor(topic) {
        this.topic = topic;
        this.editingId = -1;
        this.deletingId = -1;
        if(document.getElementById('text') !== null) {
            CKEDITOR.replace('text', {
                    toolbar:
                        [
                            ['Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript'],
                            ['Undo', 'Redo'],
                            ['Link'],
                            ['Format']
                        ],
                    width: "100%",
                    height: "200px"
                }
            );
            this.editor = CKEDITOR.instances.text;
            this.errEditorEl = document.getElementById("err_text");
            this.editorHolderEl = document.getElementById("editorHolder");
            this.createCommentBtnsHolder = document.getElementById("createComment_btns");
            this.editCommentBtnsHolder = document.getElementById("editComment_btns");
            // document.getElementById("text");
            this.newCommentBtn = document.getElementById("newCommentBtn");

            document.getElementById('newCommentBtn').addEventListener("click",
                () => {
                    this.showEditorCreate()
                });
            document.getElementById('sendBtn').addEventListener("click",
                () => {
                    this.sendComment()
                });
            document.getElementById('cancelBtn').addEventListener("click",
                () => {
                    this.hideEditorCreate()
                });
            document.getElementById('saveBtn').addEventListener("click",
                () => {
                    this.editComment()
                });
            document.getElementById('cancelEditBtn').addEventListener("click",
                () => {
                    this.hideEditorEdit()
                });
            document.getElementById('confirmedDeleteBtn').addEventListener("click",
                () => {
                    this.deleteComment()
                });
            for (let i = 0; i < 10; i++) {
                this.addEditBtnHandler(i);
                this.addDeleteBtnHandle(i);
            }
        }
    }

    addEditBtnHandler(i) {
        console.log("Adding edit handler: " + i.toString())
        let editBtnEl = document.getElementById("editBtn_"+i.toString());
        if(editBtnEl === null)
            return;
        editBtnEl.addEventListener("click", () => { this.editHndl(i); });
    }

    addDeleteBtnHandle(i) {
        console.log("Adding delete handler: " + i.toString())
        let delBtnEl = document.getElementById("deleteBtn_"+i.toString());
        if(delBtnEl === null)
            return;
        delBtnEl.addEventListener("click", () => { this.deleteHndl(i); });
    }

    sendComment() {
        let current_topic = document.getElementById("current_topic").innerText;
        if (current_topic == null)
            return;
        console.log("Creating comment");
        this.uploadComment("?c=Comment&a=add&id=" + current_topic, "err_edit");
    }

    editComment() {
        let c_id = document.getElementById("commentID_" + this.editingId.toString()).innerText.trim();
        console.log("Editing comment " + this.editingId + " c_id: " + c_id);
        this.uploadComment("?c=Comment&a=edit&id=" + c_id, "err_edit", true)
            .then( ()  => {this.hideEditorEdit()});
    }

    async deleteComment() {
        $('#deleteModal').modal('hide');
        Err.setText("err_edit", "");
        let c_id = document.getElementById("commentID_" + this.deletingId.toString()).innerText.trim();
        console.log("Deleting comment " + this.deletingId + " c_id: " + c_id);
        try{
            let response = await fetch("?c=Comment&a=delete&id=" + c_id, {
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
                Err.setText("err_edit", errors.unknown);
                window.scrollTo(0,0);
            } else {
                this.topic.reload();
            }

        } catch (e) {
            console.error('Chyba: ' + e.message);
        }
    }

    async uploadComment(url, err_id, scrollTop = false) {
        try {
            Err.setText(err_id, "");

            let commentData = this.editor.getData();
            //var nbsp = new RegExp(String.fromCharCode(160), "g");
            //let plainText = strip_tags(commentData.replace('/\s\s+/', '').replace(/\u00a0/g, " ", ' ').trim(), "");
            let plainText = this.editor.document.getBody().getText();
            console.log(commentData);
            //console.log(plainText);
            //console.log(plainText.length);
            //console.log(plainText.replace(' ', '').length);
            if (plainText.length < 3 || plainText.replace(/(?:\r\n|\r|\n)/g, '').replace(/\s/g,'').length === 0) {
                this.errEditorEl.innerText = "Comment length must be at least 3 chars.";
                return;
            }
            this.errEditorEl.innerText = "";

            let response = await fetch(url, {
                method: 'POST', // or 'PUT'
                headers: {
                    'Accept': 'application/json, text/plain, */*',
                    'Content-Type': "application/json",
                    'X_REQUESTED_WITH':"xmlhttprequest"
                },
                body: JSON.stringify({
                    text: commentData
                })
            });
            let data = await response.json();
            let errors = data.errors;
            if (errors.unknown !== undefined) {
                Err.setText(err_id, errors.unknown);
                if(scrollTop === true) {
                    window.scrollTo(0,0);
                }
            } else {
                this.topic.reload();
            }
            this.editor.setData("");
        } catch (e) {
            console.error('Chyba: ' + e.message);
        }
    }

    editHndl(i) {
        //console.log("som tu" + i);
        this.editingId = i;
        this.editor.setData(document.getElementById("comment_text_" + i.toString()).innerHTML);
        this.showEditorEdit();
    }

    deleteHndl(i) {
        //console.log("delete tu" + i);
        this.deletingId = i;
        $('#deleteModal').modal('show');
    }



    showEditorEdit() {
        Err.setText("err_edit", "");
        this.editor.setData("");
        this.errEditorEl.innerText = "";
        this.editorHolderEl.hidden = false;
        this.createCommentBtnsHolder.hidden = true;
        this.newCommentBtn.hidden = true;
        this.editCommentBtnsHolder.hidden = false;
        window.scrollTo(0,document.body.scrollHeight);
    }

    hideEditorEdit() {
        this.editor.setData("");
        this.errEditorEl.innerText = "";
        this.editorHolderEl.hidden = true;
        this.createCommentBtnsHolder.hidden = true;
        this.newCommentBtn.hidden = false;
        this.editCommentBtnsHolder.hidden = true;
    }

    showEditorCreate() {
        Err.setText("err_edit", "");
        this.editor.setData("");
        this.errEditorEl.innerText = "";
        this.editorHolderEl.hidden = false;
        this.createCommentBtnsHolder.hidden = false;
        this.newCommentBtn.hidden = true;
        this.editCommentBtnsHolder.hidden = true;
        window.scrollTo(0,document.body.scrollHeight);
    }

    hideEditorCreate() {
        this.editor.setData("");
        this.errEditorEl.innerText = "";
        this.editorHolderEl.hidden = true;
        this.createCommentBtnsHolder.hidden = true;
        this.newCommentBtn.hidden = false;
        this.editCommentBtnsHolder.hidden = true;
    }

    generateComment(comment, i, topicTitle, userId, isAdmin) {
        console.log("generateComment "+ i.toString())
        let cid_commentID = "commentID_"+ i.toString();
        let cid_topicTitle = "topicTitle_" + i.toString();
        let cid_votes = "votes_container_" + i.toString();
        let cid_text = "comment_text_" + i.toString();
        let cid_login = "comment_login_" + i.toString();
        let cid_created = "comment_created_" + i.toString();
        let html = "";
        html += `<div class="row">
                        <p hidden id="${cid_commentID}">${comment.id}</p>
                        <div class="container mt-2">
                            <small id="${cid_topicTitle}">${topicTitle}</small> `;
        html += `</div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-sm-9 col-12">
                            <div class="container comment_text" id="${cid_text}">
                                ${comment.text}
                            </div>
                        </div>
                        <div class="col-sm-3 col-12 topic_info">
                            <div class="bold topic_author" id="${cid_login}">${comment.login}</div>
                            <div class="comment_info">
                                <p id="${cid_created}">${comment.created}</p>
                        `;
        html += `<div class="mb-1">`;
        if((userId === comment.autor || isAdmin === true) && (comment.deleted === null))
        {
            html += `<button class="crud_button btn_no_border" id="editBtn_${i}">
                        <i class="fa fa-edit"></i>
                     </button>`;
        }
        if((userId === comment.autor) && (comment.deleted === null))
        {
            html += `<button class="crud_button btn_no_border" id="deleteBtn_${i}">
                        <i class="fa fa-trash"></i>
                     </button></div>`;
        }
        html += `</div>`;
        html += `</div> </div> </div> `;
        return html;
    }

    isChanged(comment, i, topicTitle)
    {
        let commentEl = document.getElementById("comment_" + i.toString());
        if(commentEl === null) {
            return true;
        }
        let cid_topicTitle = "topicTitle_" + i.toString();
        let cid_text = "comment_text_" + i.toString();
        let cid_login = "comment_login_" + i.toString();
        let cid_created = "comment_created_" + i.toString();
      /*  let el1 = document.getElementById(cid_topicTitle);
        let el3 = document.getElementById(cid_text);
        let el4 = document.getElementById(cid_login);
        let el5 = document.getElementById(cid_created);*/

        if ((document.getElementById(cid_topicTitle).innerText.trim() !== topicTitle.trim()) ||
            (document.getElementById(cid_text).innerHTML.trim() !== comment.text.trim()) ||
            (document.getElementById(cid_login).innerText.trim() !== comment.login.trim()) ||
            (document.getElementById(cid_created).innerText.trim() !== comment.created.trim())) {
            return true;
        }
        return false;
    }
}

class App {
    constructor() {
        document.addEventListener('DOMContentLoaded', () => { this.onDocumentLoad() }, false);
    }

    onDocumentLoad() {
        this.topic = new Topic();
        this.unknowErrEl = document.getElementById("err_unknown");
        this.editErrEl = document.getElementById("err_edit");
        this.deleteErrEl = document.getElementById("err_deleteTopic");
        if(this.unknowErrEl!==null) {
            if (this.unknowErrEl.innerText.trim().length === 0)
                this.unknowErrEl.hidden = true;
        }
        if(this.editErrEl!==null) {
            if (this.editErrEl.innerText.trim().length === 0)
                this.editErrEl.hidden = true;
        }
        if(this.deleteErrEl!==null) {
            if (this.deleteErrEl.innerText.trim().length === 0)
                this.deleteErrEl.hidden = true;
        }
    }
}


let app = new App();