<?php
/** @var Array $data */

use App\Models\Authentificator;
use \App\Models\Tools;

include dirname(__DIR__) . "../Common/header_logged.php";
function dataready($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    //$data = htmlspecialchars($data);
    return $data;
}

function substr_close_tags($code, $limit = 300)
{
    if (strlen($code) <= $limit) {
        return $code;
    }

    $html = substr($code, 0, $limit);
    preg_match_all("#<([a-zA-Z]+)#", $html, $result);

    foreach ($result[1] as $key => $value) {
        if (strtolower($value) == 'br') {
            unset($result[1][$key]);
        }
    }
    $openedtags = $result[1];

    preg_match_all("#</([a-zA-Z]+)>#iU", $html, $result);
    $closedtags = $result[1];

    foreach ($closedtags as $key => $value) {
        if (($k = array_search($value, $openedtags)) === FALSE) {
            continue;
        } else {
            unset($openedtags[$k]);
        }
    }

    if (empty($openedtags)) {
        if (strpos($code, ' ', $limit) == $limit) {
            return $html . "...";
        } else {
            return substr($code, 0, strpos($code, ' ', $limit)) . "...";
        }
    }

    $position = 0;
    $close_tag = '';
    foreach ($openedtags as $key => $value) {
        $p = strpos($code, ('</' . $value . '>'), $limit);

        if ($p === FALSE) {
            $code .= ('</' . $value . '>');
        } else if ($p > $position) {
            $close_tag = '</' . $value . '>';
            $position = $p;
        }
    }

    if ($position == 0) {
        return $code;
    }

    return substr($code, 0, $position) . $close_tag . "...";
}

/** @var \App\Models\DataModels\UserInTopic[] $topics */
$topics = isset($data["topics"]) ? $data["topics"] : [];
/** @var array $errors */
$errors = isset($data["errors"]) ? $data["errors"] : [];
$currentPage = isset($_GET['page']) ? $_GET['page'] : 0;
/** @var \App\Models\User $userObj */
$userObj = \App\Models\Authentificator::getInstance()->getLoggedUser();
$user = $userObj->getId();
/** @var \App\Models\DataModels\TopicInCategoriesCnt[] $categories */
$categories = isset($data['categories']) ? $data['categories'][0] : null;
$topics_count = isset($data['topics_count']) ? $data['topics_count'] : 0;
$url = isset($data["url"]) ? $data["url"] : "?c=Content&a=home";
$category_url = isset($data["category_url"]) ? $data["category_url"] : "?c=Content&a=home";
$category = isset($data["category"]) ? $data["category"] : -1;
?>
<script src="forum/public/js/Content.js" type="module"></script>

<div class="container">
    <div class="row">
        <div class="d-none d-sm-block col-lg-8 col-md-8" id="top_navigation">
            <div class="navigation">
                <?php if ($topics_count > 0) echo Tools::getPaggination(ceil($topics_count / 10.0), $currentPage, $url, "current_page_top") ?>
            </div>
        </div>
    </div>
    <div class="row">
        <?php echo Tools::getErrorDiv("unknown", $errors) ?>
    </div>
    <div class="row">
        <?php echo Tools::getErrorDiv("delete", $errors) ?>
    </div>
    <div class="row">
        <div class="col-lg-8 col-md-8" id="topics_place">
            <!--Generovat podla databazy-->
            <?php
            $startIndex = 0;
            $endIndex = 10;
            for ($i = $startIndex; $i < $endIndex; $i++) {
                if ($i >= count($topics)) {
                    break;
                }
                $topic = $topics[$i];
                $cid_topicID = "topicID_" . $i;
                ?>
                <div class="container topic_frame">
                    <div class="row">
                        <p hidden id="<?= $cid_topicID ?>"><?= $topic->id ?></p>
                        <div class="container col-sm-10 col-12">
                            <div class="row ">
                                <div class="col-sm-3 col-12 topic_info">
                                    <div class="bold topic_category"> <?= $topic->getKategory() ?> </div>
                                    <div class="topic_author"><?= $topic->login ?></div>
                                    <div class="">
                                        <?php if (($user == $topic->autor && $topic->comments == 0)
                                            || Authentificator::getInstance()->isAdminLogged()) { ?>
                                            <button class="crud_button btn_no_border" id="deleteBtn_<?= $i ?>">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        <?php } ?>
                                        <?php if ($user == $topic->autor) { ?>
                                            <a href="<?=
                                            "?c=Topic&a=edit&id=" . $topic->id ?>" class="crud_button">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                        <?php } ?>
                                    </div>
                                </div>
                                <div class="col-sm-9 col-12 topic_text">
                                    <h3>
                                        <a class="topic_headline" href="<?=
                                        "?c=Topic&a=index&id=" . $topic->id ?>">
                                            <?= $topic->title?>
                                        </a>
                                    </h3>
                                    <div>
                                        <?php


                                        $topicText = strip_tags($topic->text, ['<p>']);
                                        $topicText = (strlen($topicText) > 300 ? (substr($topicText, 0, 300) . "...") : $topicText);
                                        if (substr_count($topicText, "<p>") > 4) {
                                            $pos = 0;
                                            for ($j = 0; $j < 4; $j++) {
                                                $pos = strpos($topicText, "<p>", ++$pos);
                                            }
                                            $topicText = substr($topicText, 0, $pos);
                                        }
                                        ?>
                                        <?= $topicText ?>
                                        <!--<? //= (strlen($topicText) > 300 ? (substr($topicText, 0, 300) . "...") : $topicText) ?> -->
                                        <!-- <? //= (strlen($topic->text) > 300 ? (substr_close_tags($topic->text, 0, 600)) : $topic->text)?> -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-2 col-12 stats topic_stats">
                            <div class="stats topic_comments">
                                <i class="fa fa-comment"></i>
                                <?= strlen($topic->comments) < 2 ? "0" . $topic->comments : $topic->comments ?>
                            </div>
                            <div class="stats topic_views">
                                <i class="fa fa-eye"></i>
                                <?= strlen($topic->views) < 2 ? "0" . $topic->views : $topic->views ?>
                            </div>
                            <div class="stats topic_time">
                                <i class="fa fa-clock"></i>
                                <?= strlen($topic->getTimeBefor()) < 2 ? "0" . $topic->getTimeBefor() : $topic->getTimeBefor() ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
        <div class="col-lg-4 col-md-4">
            <div class="stats_block ">
                <h3>Categories</h3>
                <div class="line"></div>
                <ul class="categories_list" id="stats_place">
                    <!-- Generovat podla databazy-->
                    <?php /** @var \App\Models\Categories[] $data */ ?>
                    <li><a href="<?= $category_url . "&category=0" ?>">Computers <span
                                    class="badge <?= ($category == 0 ? "badge-dark" : "badge-secondary") ?> float-right"><?= $categories == null ? 0 : $categories->computers ?></span></a>
                    </li>
                    <li><a href="<?= $category_url . "&category=1" ?>">Games <span
                                    class="badge <?= ($category == 1 ? "badge-dark" : "badge-secondary") ?> float-right"><?= $categories == null ? 0 : $categories->games ?></span></a>
                    </li>
                    <li><a href="<?= $category_url . "&category=2" ?>">Science <span
                                    class="badge <?= ($category == 2 ? "badge-dark" : "badge-secondary") ?> float-right"><?= $categories == null ? 0 : $categories->science ?></span></a>
                    </li>
                    <li><a href="<?= $category_url . "&category=3" ?>">Movies <span
                                    class="badge <?= ($category == 3 ? "badge-dark" : "badge-secondary") ?> float-right"><?= $categories == null ? 0 : $categories->movies ?></span></a>
                    </li>
                    <li><a href="<?= $category_url . "&category=4" ?>">Music <span
                                    class="badge <?= ($category == 4 ? "badge-dark" : "badge-secondary") ?> float-right"><?= $categories == null ? 0 : $categories->music ?></span></a>
                    </li>
                    <li><a href="<?= $category_url . "&category=5" ?>">Other <span
                                    class="badge <?= ($category == 5 ? "badge-dark" : "badge-secondary") ?> float-right"><?= $categories == null ? 0 : $categories->other ?></span></a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-8 col-md-8" id="bottom_navigation">
            <div class="navigation">
                <?php if ($topics_count > 0) echo \App\Models\Tools::getPaggination(ceil($topics_count / 10.0), $currentPage, $url, "current_page_bottom") ?>
            </div>
        </div>
    </div>
</div>

<?php
$dataDeleteModal["headline"] = "Delete topic";
$dataDeleteModal["text"] = "Are you sure you want to permanently remove this topic?";
$dataDeleteModal["deleteBtnId"] = "confirmedDeleteBtn";
$dataDeleteModal["id"] = "deleteModal";
include dirname(__DIR__) . "/Common/delete_modal.php";
?>
</body>
