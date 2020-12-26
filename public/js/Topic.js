const RELOAD_INTERVAL = 10000;

class Topic {
    constructor() {
        this.reload();
        setInterval(() => this.reload(), RELOAD_INTERVAL);
    }

    reload() {
        let unknowErrorEl = document.getElementById("err_unknow");
        unknowErrorEl.innerText = "";
        this.loadTopic();
        this.loadPagination();
        this.loadComments();
    }

    async loadTopic() {
        try {
            let current_topic = document.getElementById("current_topic").innerText;
            if (current_topic == null)
                return;
            let url = "?c=Topic&a=topic&id=";
            url = url.concat(url, current_topic);
            let response = await fetch(url);
            let data = await response.json();
            let topic = data.topic;
            let errors = data.errors;
            let unknowErrorEl = document.getElementById("err_unknow");
            if (errors.unknow !== undefined) {
                unknowErrorEl.innerText += errors.unknow;
            }
            let titleEl = document.getElementById("topic_title");
            let textEl = document.getElementById("topic_text");
            let createdEl = document.getElementById("topic_created")
            if(titleEl.innerText != topic.title)
                titleEl.innerText = topic.title;
            if(textEl.innerText != topic.text)
                textEl.innerHTML = topic.text;
            if(createdEl.innerText != topic.created)
                createdEl.innerText = topic.created;
        } catch (e) {
            console.error('Chyba: ' + e.message);
        }
    }

    async loadPagination() {
        try {
            let current_topic = document.getElementById("current_topic").innerText;
            if (current_topic == null)
                return;
            let url = "?c=Topic&a=pagination&id=";
            url = url.concat(url, current_topic);
            let response = await fetch(url);
            let data = await response.json();
            let paginationHtml = data.pagination;
            let errors = data.errors;
            let unknowErrorEl = document.getElementById("err_unknow");
            if (errors.unknow !== undefined) {
                unknowErrorEl.innerText += errors.unknow;
            }
            let pagTop = document.getElementById("top_nav");
            let pagBottom = document.getElementById("bottom_nav");
            if(pagTop.innerText != paginationHtml)
                pagTop.innerHTML = paginationHtml;
            if(pagBottom.innerText != paginationHtml)
                pagBottom.innerHTML = paginationHtml;
        } catch (e) {
            console.error('Chyba: ' + e.message);
        }
    }

    async loadComments() {
        try {
            let current_page = document.getElementById("current_page").innerText;
            let current_topic = document.getElementById("current_topic").innerText;
            if (current_page == null)
                current_page = 0;
            if (current_topic == null)
                return;
            let url = "?c=Topic&a=comments&id=";
            url = url.concat(url, current_topic, "&page=", current_page);
            let response = await fetch(url);
            let data = await response.json();

            let comments = data.comments;
            let errors = data.errors;
            let userId = data.user;
            let commentsEl = document.getElementById("comments_holder");
            let unknowErrorEl = document.getElementById("err_unknow");
            let topicTitleEl = document.getElementById("topic_title");
            let topicTitle = "";
            if (errors.unknow !== undefined) {
                unknowErrorEl.innerText += errors.unknow;
            }
            if(topicTitleEl !== null)
                topicTitle = topicTitleEl.innerText;
            let html = "";
            let i = 0;
            comments.forEach((comment) => {
                if(this.isChanged(comment, i, topicTitle) === true) {
                    html = this.generateComment(comment, i, topicTitle, userId);
                    let commentEl = document.getElementById("comment_" + i.toString());
                    if(commentEl === null) {
                        html = `<div class="container comment_frame" id="comment_${i}">` + html + `</div>`
                        commentsEl.innerHTML += html;
                    } else {
                        commentEl.innerHTML = html;
                    }
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

    generateComment(comment, i, topicTitle, userId) {
        let cid_topicTitle = "topicTitle_" + i.toString();
        let cid_votes = "votes_container_" + i.toString();
        let cid_text = "comment_text_" + i.toString();
        let cid_login = "comment_login_" + i.toString();
        let cid_created = "comment_created_" + i.toString();
        let html = "";
        html += `<div class="row">
                        <div class="container mt-2">
                            <small id="${cid_topicTitle}">${topicTitle}</small> `;
        if (comment.deleted === null) {
            html += `<div class="votes_container" id="${cid_votes}">
                        <button class="button_icon">
                            <i class="fa fa-caret-up"></i>
                        </button>
                        <i class="fa"></i> ${comment.likes}
                        <button class="button_icon">
                            <i class="fa fa-caret-down"></i>
                        </button>
                     </div>`;
        }
        html += `</div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-sm-9 col-12">
                            <div class="container">
                                <p id="${cid_text}">
                                    ${comment.text}
                                </p>
                            </div>
                        </div>
                        <div class="col-sm-3 col-12 topic_info">
                            <div class="bold topic_author" id="${cid_login}">${comment.login}</div>
                            <div class="comment_info" id="${cid_created}">
                                ${comment.created}`;
        if((userId === comment.autor) && (comment.deleted === null))
        {
            html += `<a href="?c=Comment&a=delete&id=${comment.id}" class="crud_button">
                        <i class="fa fa-trash"></i>
                     </a>
                     <a href="?c=Comment&a=edit&id=${comment.id}" class="crud_button">
                        <i class="fa fa-edit"></i>
                     </a>
            `;
        }
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
        let cid_votes = "votes_container_" + i.toString();
        let cid_text = "comment_text_" + i.toString();
        let cid_login = "comment_login_" + i.toString();
        let cid_created = "comment_created_" + i.toString();
        if(document.getElementById(cid_topicTitle).innerText !== topicTitle) {
            return true;
        }
        if(document.getElementById(cid_votes).innerText !== comment.likes) {
            return true;
        }
        if(document.getElementById(cid_text).innerText !== comment.text) {
            return true;
        }
        if(document.getElementById(cid_login).innerText !== comment.login) {
            return true;
        }
        if(document.getElementById(cid_created).innerText !== comment.created) {
            return true;
        }
        return false;
    }
}

class Comment {
    showEditor() {
        let editorEl = document.getElementById("editorHolder");
        editorEl.hidden = false;
        document.getElementById("newCommentBtn").hidden = true;
        console.log("click");
    }
}
let commentObj = new Comment();
document.addEventListener('DOMContentLoaded', () => { var chat = new Topic(); }, false);
document.addEventListener('DOMContentLoaded',
    () => {document.getElementById('newCommentBtn').addEventListener("click",
        () => { commentObj.showEditor() }); }, false);
//document.getElementById('newCommentBtn').addEventListener("click", () => { commentObj.showEditor() });