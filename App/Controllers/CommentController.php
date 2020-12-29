<?php


namespace App\Controllers;


use App\Config\Configuration;
use App\Core\AControllerBase;
use App\Models\Authentificator;
use App\Models\Comment;
use App\Models\DataModels\UserInComment;
use App\Models\DbSelector;
use App\Models\Tools;
use App\Models\Topic;
use App\Models\User;

class CommentController extends AControllerBase
{

    public function index()
    {
        $data = [];
        if (!Authentificator::getInstance()->isLogged()) {
            return $this->json($data);
        } else {
            $errors = [];
            /** @var UserInComment[] $topics */
            $comments = [];
            try {
                /** @var Topic $topic */
                $topic = Topic::getOne($_GET['id']);
                $currentPage = isset($_GET['page']) ? $_GET['page'] : 0;
                $comments = DbSelector::getAllCommentsWhereTopic($topic->getId(), $currentPage * 10, 10);
            } catch (\Exception $e) {
                $errors["unknown"] = "Could not load Topic. " . (Configuration::DEBUG_EXCEPTIONS ? $e->getMessage() : "");
            }
            /** @var User $loggedUser */
            $loggedUser = Authentificator::getInstance()->getLoggedUser();
            $data["user"] = $loggedUser->getId();
            $data["isAdmin"] = Authentificator::getInstance()->isAdminLogged();
            $data["errors"] = $errors;
            $data['comments'] = $comments;
            return $this->json($data);
        }
    }

    public function add()
    {
        $data = [];
        if (!Authentificator::getInstance()->isLogged()) {
            return $this->json($data);
        } else {
            $bodyData = $this->request()->getBodyData();
            if (!isset($bodyData["text"]) || !Tools::checkIssetGet(["id"])) {
                $errors["unknown"] = "Body data or topic ID not set.";
                $data['errors'] = $errors;
                return $this->json($data);
            }
            /** @var User $loggedUser */
            $loggedUser = Authentificator::getInstance()->getLoggedUser();
            $text = $bodyData["text"];

            $errors = $this->validateComment($text);
            if (count($errors) == 0) {
                $created = date('Y-m-d H:i:s');
                $edited = $created;
                $topicID = $_GET['id'];
                $comment = new Comment($text, $created, $edited, null, $topicID, $loggedUser->getId());
                try {
                    $comment->save();
                } catch (\Exception $e) {
                    $errors["unknown"] = "Could not save Comment. " . (Configuration::DEBUG_EXCEPTIONS ? $e->getMessage() : "");
                }
            } else {
                $errors["unknown"] = "Validation error.";
            }
            $data['errors'] = $errors;
        }
        return $this->json($data);
    }

    public function edit()
    {
        $data = [];
        $errors = [];
        if (!Authentificator::getInstance()->isLogged()) {
            return $this->json($data);
        } else {
            $bodyData = $this->request()->getBodyData();
            if (!isset($bodyData["text"]) || !Tools::checkIssetGet(["id"])) {
                $errors["unknown"] = "Body data or ID not set.";
                $data['errors'] = $errors;
                return $this->json($data);
            }
            /** @var User $loggedUser */
            $loggedUser = Authentificator::getInstance()->getLoggedUser();
            $text = $bodyData["text"];
            $errors = $this->validateComment($text);
            if (count($errors) == 0) {
                $commentID = $_GET['id'];
                try {
                    $comment = Comment::getOne($commentID);
                    if ($comment->getAutor() == $loggedUser->getId() && $comment->getDeleted() == null) {
                        $comment->setEdited(date('Y-m-d H:i:s'));
                        $comment->setText($text);
                        $comment->save();
                    } else {
                        $errors["unknown"] = "Could not save Comment. Deleted or strange.";
                    }
                } catch (\Exception $e) {
                    $errors["unknown"] = "Could not save Comment. " . (Configuration::DEBUG_EXCEPTIONS ? $e->getMessage() : "");
                }
            } else {
                $errors["unknown"] = "Validation error.";
            }
            $data['errors'] = $errors;
        }
        return $this->json($data);
    }

    public function delete()
    {
        $data = [];
        $errors = [];
        if (!Authentificator::getInstance()->isLogged()) {
            return $this->json($data);
        } else {
            if (!Tools::checkIssetGet(["id"])) {
                $errors["unknown"] = "ID not set.";
                $data['errors'] = $errors;
                return $this->json($data);
            }
            /** @var User $loggedUser */
            $loggedUser = Authentificator::getInstance()->getLoggedUser();
            $commentID = $_GET['id'];
            try {
                $comment = Comment::getOne($commentID);
                if (($comment->getAutor() == $loggedUser->getId()
                        || Authentificator::getInstance()->isAdminLogged()) && $comment->getDeleted() == null) {
                    $comment->setEdited(date('Y-m-d H:i:s'));
                    $comment->setDeleted(true);
                    $comment->setText("<i>This comment was deleted</i>");
                    $comment->save();
                } else {
                    $errors["unknown"] = "Could not delete Comment. Deleted or strange.";
                }
            } catch (\Exception $e) {
                $errors["unknown"] = "Could not delete Comment. " . (Configuration::DEBUG_EXCEPTIONS ? $e->getMessage() : "");
            }
        }
        $data['errors'] = $errors;
        return $this->json($data);
    }

    private
    function validateComment($text)
    {
        $errors = [];
        $textTrimmed = strip_tags(trim(str_replace("&nbsp;", " ", preg_replace('/\s\s+/', '', $text))));
        if (strlen($textTrimmed) < 3 || strlen(str_replace(" ", "", $textTrimmed)) == 0) {
            $errors["text"] = "Min text length is 3.";
        }
        return $errors;
    }
}