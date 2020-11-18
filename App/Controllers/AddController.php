<?php


namespace App\Controllers;

use App\Core\AControllerBase;
use App\Models\Topic;
use App\Models\User;

class AddController extends AControllerBase
{
    public function index()
    {
        return null;
    }

    public function create()
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
        if (!isset($_POST['create'])) return null;

        $returnArray = null;
        if ($_POST['create'] == 1) {
            $tmpErr = [];
            if(!isset($_POST['topic_name'])) {
                $tmpErr['errors']['title'][] =  "No topic title recieved!";
            }
            if(!isset($_POST['topic_text'])) {
                $tmpErr['errors']['text'][] =  "No topic text recieved!";
            }
            if(!isset($_POST['category'])) {
                $tmpErr['errors']['category'][] =  "No topic category recieved!";
            }
            if(isset($tmpErr['errors']) > 0)
                return $tmpErr;

           // $test = $this->validateTopic($_POST['topic_name'], $_POST['topic_text'], $_POST['category']);
            $validateErrors = $this->validateTopic($_POST['topic_name'], $_POST['topic_text'], $_POST['category']);

            $created = date('Y-m-d H:i:s');
            $last_edit = $created;
            $topic = new Topic($_POST['topic_name'], $_POST['topic_text'],$created, $last_edit,0,$user,$_POST['category']);

            if ($validateErrors == null) {
                $lastIndex = $topic->save();
                header("Location: vaii_semestralka?c=Topic&a=index&id=$lastIndex");
                die();
            } else {
                $returnArray = ['topic'=>$topic, 'errors' => $validateErrors];
            }
        } else {
            header("Location: http://localhost/vaii_semestralka?c=Home&a=index");
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
        if($topic_category < 0 || $topic_category > 5) {
            $category_err[] = "Category is not valid!";
        }
        $aa=count($title_err);
        $bb=count($text_err);
        $cc=count($category_err);
        if($aa > 0 || $bb > 0 || $cc > 0)
            return ["title" => $title_err, "text" => $text_err, "category" => $category_err];
        return null;
        // TODO
      /*  return ((count($name_err) > 0 || count(($text_err) > 0) || count(($category_err) > 0))
            ? ["name" => $name_err, "text" => $text_err, "category" => $category_err] : null);*/
    }
}