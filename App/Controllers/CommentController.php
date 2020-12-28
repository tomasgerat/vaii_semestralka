<?php


namespace App\Controllers;


use App\Config\Configuration;
use App\Core\AControllerBase;
use App\Core\Responses\Response;
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
                $errors["unknow"] = "Could not load Topic. " . (Configuration::DEBUG_EXCEPTIONS ? $e->getMessage() : "");
            }
            /** @var User $loggedUser */
            $loggedUser = Authentificator::getInstance()->getLoggedUser();
            $data["user"] = $loggedUser->getId();
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
                $errors["unknow"] = "Body data or ID not set.";
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
                $comment = new Comment($text, $created, $edited, 0, null, $topicID, $loggedUser->getId());
                try {
                    $comment->save();
                } catch (\Exception $e) {
                    $errors["unknow"] = "Could not save Comment. " . (Configuration::DEBUG_EXCEPTIONS ? $e->getMessage() : "");
                }
            } else {
                $errors["unknow"] = "Validation error.";
            }
            $data['errors'] = $errors;
        }
        return $this->json($data);
    }

    public function edit()
    {
        $data = [];
        if (!Authentificator::getInstance()->isLogged()) {
            return $this->json($data);
        } else {
            $bodyData = $this->request()->getBodyData();
            if (!isset($bodyData["text"]) || !Tools::checkIssetGet(["id"])) {
                $errors["unknow"] = "Body data or ID not set.";
                $data['errors'] = $errors;
                return $this->json($data);
            }
            /** @var User $loggedUser */
            $loggedUser = Authentificator::getInstance()->getLoggedUser();
            $text = $bodyData["text"];

            $errors = $this->validateComment($text);
            if (count($errors) == 0) {
                $edited = date('Y-m-d H:i:s');
                $commentID = $_GET['id'];
                try {
                    $comment = Comment::getOne($commentID);
                    if($comment->getAutor() == $loggedUser->getId() && $comment->getDeleted() == null) {
                        $comment->setEdited($edited);
                        $comment->setText($text);
                        $comment->save();
                    } else {
                        $errors["unknow"] = "Could not save Comment. Deleted or strange.";
                    }
                } catch (\Exception $e) {
                    $errors["unknow"] = "Could not save Comment. " . (Configuration::DEBUG_EXCEPTIONS ? $e->getMessage() : "");
                }
            } else {
                $errors["unknow"] = "Validation error.";
            }
            $data['errors'] = $errors;
        }
        return $this->json($data);
    }

    public function delete()
    {

    }

    private function validateComment($text)
    {
        $errors = [];
        $textTrimmed = strip_tags(trim(str_replace("&nbsp;", " ",preg_replace('/\s\s+/', '', $text))));
        if (strlen($textTrimmed) < 3 || strlen(str_replace(" ", "", $textTrimmed)) == 0) {
            $errors["text"] = "Min text lenght is 3.";
        }
        return $errors;
    }
}