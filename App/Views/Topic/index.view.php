<?php
/** @var Array $data */

use \App\Models\Tools;

include dirname(__DIR__) . "../Common/header_logged.php";

/** @var array $errors */
$errors = isset($data["errors"]) ? $data["errors"] : [];
/** @var \App\Models\Topic $topic */
$topic = isset($data["topic"]) ? $data["topic"] : null;
/** @var \App\Models\User $topicAutor */
$topicAutor = $topic == null ? null : $topic->getAutorObj();
/** @var \App\Models\Comment[] $comments */
$comments = isset($data["comments"]) ? $data["comments"] : [];
$currentPage = isset($_GET['page']) ? $_GET['page'] : 0;
$comments_count = isset($data['comments_count']) ? $data['comments_count'] : 0;

/** @var User $userObj */
$userObj = \App\Models\Authentificator::getInstance()->getLoggedUser();
$user = $userObj->getId();
?>

<div class="container">
    <div class="row">
        <?php echo Tools::getErrorDiv("unknow", $errors) ?>
    </div>
    <div class="row">
        <div class="d-none d-sm-block col-lg-8 col-md-8" id="top_navigation">
            <div class="navigation">
                <?php echo Tools::getPaggination(ceil($comments_count / 10.0), $currentPage, "?c=Content&a=home") ?>
            </div>
        </div>
    </div>
    <?php if ($topic != null) { ?>
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="container topic_frame">
                    <div class="row">
                        <div class="container mt-2">
                            <h4><?= $topic->getTitle() ?></h4>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-sm-9 col-12">
                            <div class="container">

                                    <?= $topic->getText() ?>

                            </div>
                        </div>
                        <div class="col-sm-3 col-12 topic_info">
                            <div class="bold topic_author"><?= ($topicAutor == null ? "@unknow@" : $topicAutor->getLogin()) ?></div>
                            <div class="comment_info">
                                <?= $topic->getCreated() ?>
                                <?php if ($user == $topic->getAutor()) { ?>
                                    <a href="<?= /** @var \App\Models\Topics $topic */
                                    "?c=Topic&a=delete&id=" . $topic->getID() ?>" class="crud_button">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                    <a href="<?= /** @var \App\Models\Topics $topic */
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
        <div class="col-lg-12 col-md-12" id="post_place">
            <!--Generovat podla databazy-->
            <?php
            $startIndex = 0;
            $endIndex = 10;
            for ($i = $startIndex; $i < $endIndex; $i++) {
                if ($i >= count($comments)) {
                    break;
                }
                /** @var \App\Models\Comment $comment */
                $comment = $comments[$i];
                $commentAutor = $comment->getAutorObj();
                ?>
                <div class="container topic_frame">
                    <div class="row">
                        <div class="container mt-2">
                            <small><?= $topic->getTitle() ?></small>
                            <?php if ($comment->getDeleted() == 0) { ?>
                                <div class="votes_container">
                                    <button class="button_icon">
                                        <i class="fa fa-caret-up"></i>
                                    </button>
                                    <i class="fa"></i>
                                    <?= $comment->getLikes() ?>
                                    <button class="button_icon">
                                        <i class="fa fa-caret-down"></i>
                                    </button>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-sm-9 col-12">
                            <div class="container">
                                <p>
                                    <?= $comment->getText() ?>
                                </p>
                            </div>
                        </div>
                        <div class="col-sm-3 col-12 topic_info">
                            <div class="bold topic_author"><?= ($commentAutor == null ? "@unknow@" : $commentAutor->getLogin()) ?></div>
                            <div class="comment_info">
                                <?= $comment->getCreated() ?>
                                <?php if (($user == $comment->getAutor()) && ($comment->getDeleted() == 0)) { ?>
                                    <a href="<?= /** @var \App\Models\Comment $comment */
                                    "?c=Comment&a=delete&id=" . $comment->getID() ?>" class="crud_button">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                    <a href="<?= /** @var \App\Models\Comment $comment */
                                    "?c=Comment&a=edit&id=" . $comment->getID() ?>" class="crud_button">
                                        <i class="fa fa-edit"></i>
                                    </a>
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
                <form action="?c=Comment&a=add&topicid=<?= $topic->getID() ?>" method="post" autocomplete="off">
                    <div class="col-lg-12">
                        <button type="submit" name="newComment" value="1"
                                class=" mb-3 btn btn-lg btn-dark btn-outline-light float-right">
                            New comment
                        </button>
                    </div>
                </form>
            </div>
        </div>
    <?php } ?>
    <div class="row">
        <div class="col-lg-8 col-md-8" id="bottom_navigation">
            <div class="navigation">
                <?php echo Tools::getPaggination(ceil($comments_count / 10.0), $currentPage, "?c=Content&a=home") ?>
            </div>
        </div>
    </div>
</div>
</body>
