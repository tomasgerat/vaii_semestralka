<?php

namespace App\Models\DataModels;

class UserInTopic {
    public $id;
    public $title;
    public $text;
    public $created;
    public $edited;
    public $views;
    public $autor;
    public $category;
    public $comments;
    public $login;
    public static function getDbColumns()
    {
        return ['id', 'title', 'text', 'created', 'edited', 'views', 'category', 'autor', 'comments', 'login'];
    }

    public function getKategory()
    {
        switch ($this->category) {
            case 0:
                return "Computers";
            case 1:
                return "Games";
            case 2:
                return "Science";
            case 3:
                return "Movies";
            case 4:
                return "Music";
            case 5:
                return "Other";
        }
        return "Other";
    }

    public function getTimeBefor()
    {
        //2020-11-17 13:06:01

        $d1=time();
        $d2=strtotime($this->created);
        $diff = $d1 - $d2;
        if(((int)($diff / 60 / 60 / 24 / 365)) > 0) {
            return (int)($diff / 60 / 60 / 24 / 365) . " y";
        }
        if(((int)($diff / 60 / 60 / 24 )) > 0) {
            return (int)($diff / 60 / 60 / 24) . " d";
        }
        if(((int)($diff / 60 / 60 )) > 0) {
            return (int)($diff / 60 / 60) . " h";
        }
        if(((int)($diff / 60  )) > 0) {
            return (int)($diff / 60 ) . " m";
        }
        return ((int)($diff)) . " s";
    }
}