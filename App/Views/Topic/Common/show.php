<?php
/** @var Array $data */

use \App\Models\Tools;

include dirname(__DIR__) . "../../Common/header_logged.php";

/** @var array $errors */
$errors = isset($data["errors"]) ? $data["errors"] : [];
$title = isset($data["title"]) ? $data["title"] : "";
$text = isset($data["text"]) ? $data["text"] : "";
$category = isset($data["category"]) ? $data["category"] : "";
$topicId = isset($data["topic_id"]) ? "&id=".$data["topic_id"] : "";
?>

<script src="forum/public/js/addTopic.js" type="module"></script>

<div class="container mt-5 mb-3">
    <div class="row">
        <?php echo Tools::getErrorDiv("unknown", $errors) ?>
    </div>
    <div id="add_form_holder">
        <form class="info_form" action="?c=Topic&a=<?=$data['submit_action'].$topicId?>" method="post" autocomplete="off">
            <div class="row mb-3">
                <label for="title">Topic name</label>
                <input type="text" class="form-control" id="title" name="title"
                       placeholder="Title of the topic" value="<?= $title ?>" required>
                <?php echo Tools::getErrorDiv("title", $errors) ?>
            </div>
            <!--        <div class="row mb-3">
                <label for="text">Topic text:</label>
                <textarea class="form-control" rows="10" id="text" name="text" required><?//=$text?></textarea>
                <?//php echo Tools::getErrorDiv("text", $errors) ?>
            </div> -->
            <div class="row mb-3">
                <label for="text">Topic text:</label>
                <textarea id="text" name="text" required><?=$text?></textarea>
                <?php echo Tools::getErrorDiv("text", $errors) ?>
            </div>
            <div class="dropdown mb-3 ml-0">
                <select name="category" id="category" class="btn-block btn-dark select_item" required>
                    <option value="" disabled  <?php if($category == "") echo 'selected' ?> >Category</option>
                    <option value="0" <?php if($category == "0") echo 'selected' ?> >Computers</option>
                    <option value="1" <?php if($category == "1") echo 'selected' ?> >Games</option>
                    <option value="2" <?php if($category == "2") echo 'selected' ?> >Science</option>
                    <option value="3" <?php if($category == "3") echo 'selected' ?> >Movies</option>
                    <option value="4" <?php if($category == "4") echo 'selected' ?> >Music</option>
                    <option value="5" <?php if($category == "5") echo 'selected' ?> >Other</option>
                </select>
                <?php echo Tools::getErrorDiv("category", $errors) ?>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <button type="submit" name="create" value="1"
                            class="mb-3 btn btn-block btn-lg btn-dark btn-outline-light">
                        <?=$data["button_confirm"]?>
                    </button>
                </div>
                <div class="col-md-6">
                    <button type="submit" name="create" value="0"
                            class="mb-3 btn btn-block btn-lg btn-dark btn-outline-light">
                        Cancel
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
