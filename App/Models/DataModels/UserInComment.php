<?php


namespace App\Models\DataModels;


class UserInComment extends ADataModel
{
    public $id;
    public $text;
    public $created;
    public $edited;
    public $likes;
    public $deleted;
    public $topic;
    public $autor;
    public $login;
    static public function setDbColumns()
    {
        return ['id', 'text', 'created', 'edited', 'likes', 'deleted', 'topic', 'autor', 'login'];
    }
}