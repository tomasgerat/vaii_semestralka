<?php


namespace App\Controllers;

use App\Core\AControllerBase;
use App\Models\Comment;
use App\Models\Comments;
use App\Models\Topic;

class TopicController extends AControllerBase
{
    public function index()
    {
        if(isset($_GET['id'])) {
            try {
                $comments = Comments::getAllForTopic($_GET['id']);
            } catch (\Exception $e) {
                header("Location: vaii_semestralka?c=Error&a=getComment");
                die();
            }
            try {
                $topic = Topic::getOne($_GET['id']);
                $topic->setViews($topic->getViews()+1);
                $topic->save();
            } catch (\Exception $e) {
                header("Location: vaii_semestralka?c=Error&a=getTopic");
                die();
            }
            return ["comments" => $comments, "topic" => $topic];
        } else {
            header("Location: vaii_semestralka?c=Error&a=getTopic");
            die();
        }
    }

    public function delete() {
        $user = "jano"; //TODO  z prihlasenia

        if (!isset($_POST['delete'])) {
            try {
                if(isset($_GET["id"])) {
                    $topic = Topic::getOne($_GET["id"]);
                    return ['topic'=>$topic];
                }
                else {
                    header("Location: vaii_semestralka?c=Error&a=getTopic");
                    die();
                }

            } catch (\Exception $e)
            {
                header("Location: vaii_semestralka?c=Error&a=getTopic");
                die();
            }
        };

        if ($_POST['delete'] == 1) {
            try {
                if(isset($_GET["id"])) {
                    $topic = Topic::getOne($_GET["id"]);
                    if($topic->getAutor() == $user)
                    {
                        $allcomments = Comment::getAllForTopic($topic->getID());
                        /** @var Comment[] $allcomments */
                        /** @var Comment $com */
                        foreach ($allcomments as $com) {
                            $com->delete();
                        }
                        $topic->delete();
                        header("Location: vaii_semestralka?c=Home&a=index");
                        die();
                    }
                }
                else {
                    header("Location: vaii_semestralka?c=Error&a=getTopic");
                    die();
                }

            } catch (\Exception $e)
            {
                header("Location: vaii_semestralka?c=Error&a=deleteTopic");
                die();
            }


        } else {
            header("Location: vaii_semestralka?c=Home&a=index");
            die();
        }

        return null;
    }

    public function edit()
    {
        $user = "jano"; //TODO  z prihlasenia
        /*  $user = new User("jana", "asdddddddd", "jana@fakemail.com", "Jana", "Horvatova");
                $user = new User("Dana", "asddddadddddddd", "dana@fakemail.com", "Dana", "Horvatova");
                $user->save();
                $user = User::getAll();
                $user = User::getOne("dana");
                $user->delete();
                $user = User::getAll();
        */
        if (!isset($_POST['edit'])) {
            try {
                if(isset($_GET["id"])) {
                    $topic = Topic::getOne($_GET["id"]);
                    return ['topic'=>$topic];
                }
                else {
                    header("Location: vaii_semestralka?c=Error&a=getTopic");
                    die();
                }

            } catch (\Exception $e)
            {
                header("Location: vaii_semestralka?c=Error&a=getTopic");
                die();
            }
        }

        $returnArray = null;
        if ($_POST['edit'] == 1) {
            $tmpErr = [];
            $changeCategory = false;
            if(!isset($_POST['topic_name'])) {
                $tmpErr['errors']['title'][] =  "No topic title recieved!";
            }
            if(!isset($_POST['topic_text'])) {
                $tmpErr['errors']['text'][] =  "No topic text recieved!";
            }
            if(isset($_POST['category'])) {
                $changeCategory = true;
            }
            if(isset($tmpErr['errors']) > 0)
                return $tmpErr;

            // $test = $this->validateTopic($_POST['topic_name'], $_POST['topic_text'], $_POST['category']);
            $validateErrors = $this->validateTopic($_POST['topic_name'], $_POST['topic_text'],($changeCategory == true ? $_POST['category'] : null));

            try {
                if(isset($_GET["id"])) {
                    $topic = Topic::getOne($_GET["id"]);
                    $topic->setTitle($_POST['topic_name']);
                    $topic->setText($_POST['topic_text']);
                    $topic->setLastEdit(date('Y-m-d H:i:s'));
                    if($changeCategory == true) {
                        $topic->setKategory($_POST['category']);
                    }
                    if ($validateErrors == null) {
                        if($topic->getAutor() == $user)
                        {
                            $topic->save();
                        }
                        $id = $_GET["id"];
                        header("Location: vaii_semestralka?c=Topic&a=index&id=$id");
                        die();
                    } else {
                        $returnArray = ['topic'=>$topic, 'errors' => $validateErrors];
                    }
                }
                else {
                    header("Location: vaii_semestralka?c=Error&a=getTopic");
                    die();
                }

            } catch (\Exception $e)
            {
                header("Location: vaii_semestralka?c=Error&a=editTopic");
                die();
            }


        } else {
            header("Location: vaii_semestralka?c=Home&a=index");
            die();
        }

        return $returnArray;
    }

    private function validateTopic($topic_title, $topic_text, $topic_category)
    {
        $title_err = [];
        $text_err = [];
        $category_err = [];
        if(strlen($topic_title) > 100) {
            $title_err[] = "Max title lenght is 100!";
        }
        if(strlen($topic_title) < 3) {
            $title_err[] = "Min title lenght is 3!";
        }
        if(strlen($topic_text) < 3) {
            $text_err[] = "Min topic text lenght is 3!";
        }
        if($topic_category != null) {
            if ($topic_category < 0 || $topic_category > 5) {
                $category_err[] = "Category is not valid!";
            }
        }
        $aa=count($title_err);
        $bb=count($text_err);
        $cc=count($category_err);
        if($aa > 0 || $bb > 0 || $cc > 0)
            return ["title" => $title_err, "text" => $text_err, "category" => $category_err];
        return null;
    }
}