<?php

namespace App\Controllers;

use App\Core\AControllerBase;
use App\Models\Comment;
use App\Models\Topic;
use App\Models\User;

class CommentController extends AControllerBase
{
    public function index()
    {
        $user = "jano"; //TODO  z prihlasenia
        if (!isset($_GET['topicid'])) {
            header("Location: vaii_semestralka?c=Error&a=getTopic");
            die();
        }

        $topicID = $_GET['topicid'];
        if (!isset($_POST['create'])){
            return ['topicid'=> $topicID];
        }

        $returnArray = null;
        if ($_POST['create'] == 1) {
            $tmpErr = [];
            if (!isset($_POST['comment_text'])) {
                $tmpErr['errors']['text'][] = "No topic text recieved!";
            }
            if (isset($tmpErr['errors']) > 0)
                return $tmpErr;

            $validateErrors = $this->validateComment($_POST['comment_text']);

            $created = date('Y-m-d H:i:s');
            $last_edit = $created;
            $comment = new Comment($_POST["comment_text"], $created, $last_edit, 0, $topicID , $user);
            try {
                if ($validateErrors == null) {
                    $comment->save();
                    header("Location: vaii_semestralka?c=Topic&a=index&id=$topicID");
                    die();
                } else {
                    $returnArray = ['topicid'=> $topicID, 'comment' => $comment, 'errors' => $validateErrors];
                    return $returnArray;
                }
            } catch (\Exception $e) {
                header("Location: vaii_semestralka?c=Error&a=addComment");
                die();
            }
        } else {
            header("Location: vaii_semestralka?c=Topic&a=index&id=$topicID");
            die();
        }

        return $returnArray;
    }

    public function edit()
    {
        $user = "jano"; //TODO  z prihlasenia
        if (!isset($_POST['edit'])) {
            try {
                if(isset($_GET["id"])) {
                    $comment = Comment::getOne($_GET["id"]);
                    return ['comment'=>$comment];
                }
                else {
                    header("Location: vaii_semestralka?c=Error&a=getComment");
                    die();
                }

            } catch (\Exception $e)
            {
                header("Location: vaii_semestralka?c=Error&a=getComment");
                die();
            }
        }

        $returnArray = null;
        if ($_POST['edit'] == 1) {
            $tmpErr = [];
            $changeCategory = false;
            if(!isset($_POST['comment_text'])) {
                $tmpErr['errors']['text'][] =  "No comment text recieved!";
            }
            if(isset($tmpErr['errors']) > 0)
                return $tmpErr;

            $validateErrors = $this->validateComment($_POST['comment_text']);

            try {
                if(isset($_GET["id"])) {
                    $comment = Comment::getOne($_GET["id"]);
                    if($comment->getDeleted() == 1)
                    {
                        header("Location: vaii_semestralka?c=Error&a=editComment");
                        die();
                    }
                    $comment->setText($_POST['comment_text']);
                    $comment->setLastEdit(date('Y-m-d H:i:s'));
                    if ($validateErrors == null) {
                        if($comment->getAutor() == $user)
                        {
                            $comment->save();
                        }
                        $id = $_GET["id"];
                        header(("Location: vaii_semestralka?c=Topic&a=index&id=" . $comment->getTopicID()));
                        die();
                    } else {
                        $returnArray = ['comment'=>$comment, 'errors' => $validateErrors];
                    }
                }
                else {
                    header("Location: vaii_semestralka?c=Error&a=getComment");
                    die();
                }

            } catch (\Exception $e)
            {
                header("Location: vaii_semestralka?c=Error&a=editComment");
                die();
            }

        } else {
            try {
                if(isset($_GET["id"])) {
                    $comment = Comment::getOne($_GET["id"]);
                    header(("Location: vaii_semestralka?c=Topic&a=index&id=" . $comment->getTopicID()));
                    die();
                }
                else {
                    header("Location: vaii_semestralka?c=Error&a=getComment");
                    die();
                }

            } catch (\Exception $e)
            {
                header("Location: vaii_semestralka?c=Error&a=getComment");
                die();
            }
        }
        return $returnArray;
    }

    public function delete()
    {
        $user = "jano"; //TODO  z prihlasenia

        if (!isset($_POST['delete'])) {
            try {
                if(isset($_GET["id"])) {
                    $comment = Comment::getOne($_GET["id"]);
                    return ['comment'=>$comment];
                }
                else {
                    header("Location: vaii_semestralka?c=Error&a=getComment");
                    die();
                }

            } catch (\Exception $e)
            {
                header("Location: vaii_semestralka?c=Error&a=getComment");
                die();
            }
        };

        if ($_POST['delete'] == 1) {
            try {
                if(isset($_GET["id"])) {
                    $comment = Comment::getOne($_GET["id"]);
                    if($comment->getDeleted() == 1)
                    {
                        header("Location: vaii_semestralka?c=Error&a=deleteComment");
                        die();
                    }
                    if($comment->getAutor() == $user)
                    {
                        //$comment->delete();
                        $comment->setText("<i>This comment was deleted</i>");
                        $comment->setLastEdit(date('Y-m-d H:i:s'));
                        $comment->setDeleted(1);
                        $comment->save();
                        header(("Location: vaii_semestralka?c=Topic&a=index&id=" . $comment->getTopicID()));
                        die();
                    }
                }
                else {
                    header("Location: vaii_semestralka?c=Error&a=getComment");
                    die();
                }

            } catch (\Exception $e)
            {
                header("Location: vaii_semestralka?c=Error&a=deleteComment");
                die();
            }


        } else {
            try {
                if(isset($_GET["id"])) {
                    $comment = Comment::getOne($_GET["id"]);
                    header(("Location: vaii_semestralka?c=Topic&a=index&id=" . $comment->getTopicID()));
                    die();
                }
                else {
                    header("Location: vaii_semestralka?c=Error&a=getComment");
                    die();
                }

            } catch (\Exception $e)
            {
                header("Location: vaii_semestralka?c=Error&a=getComment");
                die();
            }
        }

        return null;
    }

    private function validateComment($comment_text)
    {
        $text_err = [];
        if (strlen($comment_text) < 3) {
            $text_err[] = "Min comment text lenght is 3!";
        }
        $bb = count($text_err);
        if ($bb > 0)
            return ["text" => $text_err];
        return null;
    }
}