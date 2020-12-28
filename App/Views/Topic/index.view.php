<?php
/** @var Array $data */

use App\Models\Authentificator;
use App\Models\DataModels\UserInComment;
use \App\Models\Tools;
use App\Models\Topic;
use App\Models\User;

include dirname(__DIR__) . "/Common/header_logged.php";

/** @var array $errors */
$errors = isset($data["errors"]) ? $data["errors"] : [];
/** @var Topic $topic */
$topic = isset($data["topic"]) ? $data["topic"] : null;
/** @var User $topicAutor */
$topicAutor = $topic == null ? null : $topic->getAutorObj();
/** @var UserInComment[] $comments */
$comments = isset($data["comments"]) ? $data["comments"] : [];
$currentPage = isset($_GET['page']) ? $_GET['page'] : 0;
$comments_count = isset($data['comments_count']) ? $data['comments_count'] : 0;

/** @var User $userObj */
$userObj = Authentificator::getInstance()->getLoggedUser();
$user = $userObj->getId();
?>

<!--<script src="forum/public/js/locutus.js" type="module"></script>-->
<script src="forum/public/js/Topic.js" type="module"></script>

<div class="container">
    <div class="row">
        <?php echo Tools::getErrorDiv("unknown", $errors) ?>
    </div>
    <div class="row">
        <?php echo Tools::getErrorDiv("edit", $errors) ?>
    </div>
    <div class="row">
        <div class="d-none d-sm-block col-lg-8 col-md-8" id="top_navigation">
            <div class="navigation" id="top_nav">
                <?php echo Tools::getPaggination(ceil($comments_count / 10.0), $currentPage, "?c=Topic&a=index&id=" . $topic->getId()) ?>
            </div>
        </div>
    </div>
    <?php
    $tid_title = "topic_title";
    $tid_text = "topic_text";
    $tid_login = "topic_login";
    $tid_created = "topic_created";
    if ($topic != null) { ?>
        <p hidden id="current_topic"><?= $topic->getId() ?></p>
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="container topic_frame">
                    <div class="row">
                        <div class="container mt-2  topic_text" id="<?= $tid_title ?>">
                            <h4><?= $topic->getTitle() ?></h4>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-sm-9 col-12">
                            <div class="container  topic_text" id="<?= $tid_text ?>">
                                <?= $topic->getText() ?>
                            </div>
                        </div>
                        <div class="col-sm-3 col-12 topic_info">
                            <div class="bold topic_author"
                                 id="<?= $tid_login ?>"><?= ($topicAutor == null ? "@unknown@" : $topicAutor->getLogin()) ?></div>
                            <div class="comment_info">
                                <span id="<?= $tid_created ?>"><?= $topic->getCreated() ?></span>
                                <?php if ($user == $topic->getAutor()) { ?>
                                    <a href="<?=
                                    "?c=Topic&a=delete&id=" . $topic->getID() ?>" class="crud_button">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                    <a href="<?=
                                    "?c=Topic&a=edit&id=" . $topic->getID() ?>" class="crud_button">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
    <div class="row">
        <div class="col-lg-12 col-md-12" id="comments_holder">
            <!--Generovat podla databazy-->
            <?php
            $startIndex = 0;
            $endIndex = 10;
            for ($i = $startIndex; $i < $endIndex; $i++) {
                if ($i >= count($comments)) {
                    break;
                }
                $comment = $comments[$i];
                $cid_commentID = "commentID_" . $i;
                $cid_topicTitle = "topicTitle_" . $i;
                $cid_text = "comment_text_" . $i;
                $cid_login = "comment_login_" . $i;
                $cid_created = "comment_created_" . $i;
                ?>
                <div class="container comment_frame" id="comment_<?= $i ?>">
                    <div class="row">
                        <p hidden id="<?= $cid_commentID ?>"><?= $comment->id ?></p>
                        <div class="container mt-2">
                            <small id="<?= $cid_topicTitle ?>"><?= $topic->getTitle() ?></small>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-sm-9 col-12">
                            <div class="container comment_text" id="<?= $cid_text ?>">
                                <?= $comment->text ?>
                            </div>
                        </div>
                        <div class="col-sm-3 col-12 topic_info">
                            <div class="bold topic_author" id="<?= $cid_login ?>"><?= $comment->login ?></div>
                            <div class="comment_info">
                                <p id="<?= $cid_created ?>"><?= $comment->created ?></p>
                                <?php if (($user == $comment->autor) && ($comment->deleted == 0)) { ?>
                                    <div>
                                        <button class="crud_button btn_no_border" id="editBtn_<?= $i ?>">
                                            <i class="fa fa-edit"></i>
                                        </button>
                                        <button class="crud_button btn_no_border" id="deleteBtn_<?= $i ?>">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
    <?php if ($topic != null) { ?>
        <div class="row">
            <div class="container mt-3">
                <!-- <form action="#" method="post" autocomplete="off"> -->
                <div class="col-lg-12">
                    <button type="submit" name="newComment" value="1" id="newCommentBtn"
                            class=" mb-3 btn btn-lg btn-dark btn-outline-light float-right">
                        New comment
                    </button>
                </div>
                <!-- </form> -->
            </div>
        </div>
    <?php } ?>

    <div class="row mb-3 ml-1 mr-1" id="editorHolder" hidden>
        <label for="text">Comment text:</label>
        <textarea id="text" name="text" required> </textarea>
        <?php echo Tools::getErrorDiv("text", $errors) ?>
        <div class="col-lg-12" id="createComment_btns" hidden>
            <button type="button" name="sendBtn" value="1" id="sendBtn"
                    class="mt-2 ml-2 mr-2 mb-3 btn btn-lg btn-dark btn-outline-light float-right">
                Send
            </button>
            <button type="button" name="cancelBtn" value="0" id="cancelBtn"
                    class="mt-2 ml-2 mr-2 mb-3 btn btn-lg btn-dark btn-outline-light float-right">
                Cancel
            </button>
        </div>
        <div class="col-lg-12" id="editComment_btns" hidden>
            <button type="button" name="saveBtn" value="1" id="saveBtn"
                    class="mt-2 ml-2 mr-2 mb-3 btn btn-lg btn-dark btn-outline-light float-right">
                Save
            </button>
            <button type="button" name="cancelEditBtn" value="0" id="cancelEditBtn"
                    class="mt-2 ml-2 mr-2 mb-3 btn btn-lg btn-dark btn-outline-light float-right">
                Cancel
            </button>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8 col-md-8" id="bottom_navigation">
            <div class="navigation" id="bottom_nav">
                <?php echo Tools::getPaggination(ceil($comments_count / 10.0), $currentPage, "?c=Topic&a=index&id=" . $topic->getId()) ?>
            </div>
        </div>
    </div>
</div>

<?php
include dirname(__DIR__) . "/Common/delete_modal.php";
?>
</body>
