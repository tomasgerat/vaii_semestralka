<?php


namespace App\Controllers;


use App\Config\Configuration;
use App\Core\AControllerBase;
use App\Models\Authentificator;
use App\Models\DataModels\UserInComment;
use App\Models\DataModels\EntriesCount;
use App\Models\DbSelector;
use App\Models\Tools;
use App\Models\Topic;
use App\Models\User;

class TopicController extends AControllerBase
{

    public function index()
    {
        if (!Authentificator::getInstance()->isLogged()) {
            return $this->redirect("?c=User&a=login");
        } else {
            if (!Tools::checkIssetGet(["id"])) {
                return $this->redirect("?c=Content&a=home");
            }
            $data = [];
            $data["tabTitle"] = "Topic";
            $data["tabCss"] = "topic.css";
            $data["tabActive"] = "";
            $errors = [];
            try {
                /** @var Topic $topic */
                $topic = Topic::getOne($_GET['id']);
                $currentPage = isset($_GET['page']) ? $_GET['page'] : 0;
                /** @var UserInComment[] $topics */
                $comments = DbSelector::getAllCommentsWhereTopic($topic->getId(), $currentPage * 10, 10 );
                $topic->setViews($topic->getViews() + 1);
                $topic->save();

                /** @var EntriesCount $countObj */
                $countObj = DbSelector::countAllCommentsInTopic($topic->getId());

                $data['topic'] = $topic;
                $data['comments'] = $comments;
                $data["comments_count"] = $countObj[0]->count;
            } catch (\Exception $e) {
                $errors["unknow"] = "Could not load Topic. " . (Configuration::DEBUG_EXCEPTIONS ? $e->getMessage() : "");
            }
            $data["errors"] = $errors;
            return $this->html($data, "index");
        }
    }

    public function topic() {
        $data = [];
        if (!Authentificator::getInstance()->isLogged()) {
            return $this->json($data);
        } else {
            $errors = [];
            try {
                /** @var Topic $topic */
                $topic = Topic::getOne($_GET['id']);
            } catch (\Exception $e) {
                $errors["unknow"] = "Could not load Topic. " . (Configuration::DEBUG_EXCEPTIONS ? $e->getMessage() : "");
            }
            /** @var User $loggedUser */
            $loggedUser = Authentificator::getInstance()->getLoggedUser();
            $data["user"] = $loggedUser->getId();
            $data["errors"] = $errors;
            $data['topic'] = $topic;
            return $this->json($data);
        }
    }

    public function pagination() {
        $data = [];
        if (!Authentificator::getInstance()->isLogged()) {
            return $this->json($data);
        } else {
            $errors = [];
            $currentPage = isset($_GET['page']) ? $_GET['page'] : 0;
            $url = "?c=Topic&a=index&id=";
            try {
                /** @var Topic $topic */
                $topic = Topic::getOne($_GET['id']);
                /** @var EntriesCount $countObj */
                $countObj = DbSelector::countAllCommentsInTopic($topic->getId());
                $c = $countObj[0]->count;
                $c = ceil((int)$c / 10.0);
                $htmlPag = Tools::getPaggination($c, $currentPage, $url . $topic->getId());
            } catch (\Exception $e) {
                $errors["unknow"] = "Could not create pagination. " . (Configuration::DEBUG_EXCEPTIONS ? $e->getMessage() : "");
            }
            /** @var User $loggedUser */
            $loggedUser = Authentificator::getInstance()->getLoggedUser();
            $data["user"] = $loggedUser->getId();
            $data["errors"] = $errors;
            $data['pagination'] = $htmlPag;
            return $this->json($data);
        }
    }

    public function add()
    {
        if (!Authentificator::getInstance()->isLogged()) {
            return $this->redirect("?c=User&a=login");
        } else {
            $data = [];
            $data["tabTitle"] = "Add";
            $data["tabCss"] = "add.css";
            $data["tabActive"] = "add";

            if (!Tools::checkIssetPost(["create", "title", "text", 'category'])) {
                return $this->html($data, "add");
            }
            if ($_POST['create'] == 1) {
                /** @var User $loggedUser */
                $loggedUser = Authentificator::getInstance()->getLoggedUser();
                $data["title"] = $title = $_POST["title"];
                $data["text"] = $text = $_POST["text"];
                $data["category"] = $category = $_POST["category"];

                $errors = $this->validateTopic($title, $text, $category);
                if(count($errors) == 0)
                {
                    $created = date('Y-m-d H:i:s');
                    $edited = $created;
                    $topic = new Topic($title, $text, $created, $edited, 0,$category, $loggedUser->getId());
                    try {
                        $lastIndex = $topic->save();
                        return $this->redirect("?c=Topic&a=index&id=".$lastIndex);
                    } catch (\Exception $e) {
                        $errors["unknow"] = "Could not save Topic. " . (Configuration::DEBUG_EXCEPTIONS ? $e->getMessage() : "");
                    }
                }
            } else {
                return $this->redirect("?c=Content&a=home");
            }
            $data["errors"] = $errors;
            return $this->html($data, "add");
        }
    }

    public function edit()
    {
        if (!Authentificator::getInstance()->isLogged()) {
            return $this->redirect("?c=User&a=login");
        } else {
            if (!Tools::checkIssetGet(["id"])) {
                return $this->redirect("?c=Content&a=home");
            }
            $data = [];
            $data["tabTitle"] = "Edit";
            $data["tabCss"] = "add.css";
            $data["tabActive"] = "";

            $data["topic_id"] = $_GET['id'];
            $errors = [];

            try {
                $topic = Topic::getOne($_GET['id']);
            } catch (\Exception $e) {
                $errors["unknow"] = "Could not load Topic. " . (Configuration::DEBUG_EXCEPTIONS ? $e->getMessage() : "");
                $data["errors"] = $errors;
                return $this->html($data, "edit");
            }

            if (!Tools::checkIssetPost(["create", "title", "text", 'category'])) {
                $data["title"] = $topic->getTitle();
                $data["text"] = $topic->getText();
                $data["category"] = $topic->getCategory();
                return $this->html($data, "edit");
            }
            if ($_POST['create'] == 1) {
                /** @var User $loggedUser */
                //$loggedUser = Authentificator::getInstance()->getLoggedUser();
                $data["title"] = $title = $_POST["title"];
                $data["text"] = $text = $_POST["text"];
                $data["category"] = $category = $_POST["category"];

                $errors = $this->validateTopic($title, $text, $category);
                if(count($errors) == 0)
                {
                    $topic->setTitle($title);
                    $topic->setText($text);
                    $topic->setCategory($category);
                    $topic->setEdited(date('Y-m-d H:i:s'));
                    try {
                        $lastIndex = $topic->save();
                        return $this->redirect("?c=Topic&a=index&id=".$lastIndex);
                    } catch (\Exception $e) {
                        $errors["unknow"] = "Could not save Topic. " . (Configuration::DEBUG_EXCEPTIONS ? $e->getMessage() : "");
                    }
                }
            } else {
                return $this->redirect("?c=Topic&a=index&id=".$topic->getId());
            }
            $data["errors"] = $errors;
            return $this->html($data, "add");
        }
    }

    private function validateTopic($title, $text, $category)
    {
        $errors = [];
        if (strlen($title) < 3 || strlen($title) > 100) {
            $errors["title"] = "Title length must be between  3 and  100.";
        }
        $textTrimmed = strip_tags(trim(str_replace("&nbsp;", " ",preg_replace('/\s\s+/', '', $text))));
        if (strlen($textTrimmed) < 3 || strlen(str_replace(" ", "", $textTrimmed)) == 0) {
            $errors["text"] = "Min text lenght is 3.";
        }
        if ($category < 0 || $category > 5) {
            $errors["category"] = "Category is not valid.";
        }
        return $errors;
    }
}