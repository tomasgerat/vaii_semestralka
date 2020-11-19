<?php

namespace App\Models;

use App\Core\Model;

class Comment extends Model
{
    protected $id;
    protected $text;
    protected $created;
    protected $last_edit;
    protected $likes;
    protected $topicID;
    protected $autor;

    public function __construct($text = "", $created = "", $last_edit = "", $likes = "", $topicID="", $autor = "")
    {
        $this->text = $text;
        $this->created = $created;
        $this->last_edit = $last_edit;
        $this->likes = $likes;
        $this->autor = $autor;
        $this->topicID = $topicID;
        $this->autor = $autor;
    }

    static public function setDbColumns()
    {
        return ['id','text', 'created', 'last_edit', 'likes', 'topicID', 'autor'];
    }

    static public function setTableName()
    {
        return "comment";
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed|string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @return mixed|string
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * @return mixed|string
     */
    public function getLastEdit()
    {
        return $this->last_edit;
    }

    /**
     * @return mixed|string
     */
    public function getLikes()
    {
        return $this->likes;
    }

    /**
     * @return mixed|string
     */
    public function getTopicID()
    {
        return $this->topicID;
    }

    /**
     * @return mixed|string
     */
    public function getAutor()
    {
        return $this->autor;
    }

    /**
     * @param mixed|string $text
     */
    public function setText($text): void
    {
        $this->text = $text;
    }

    /**
     * @param mixed|string $last_edit
     */
    public function setLastEdit($last_edit): void
    {
        $this->last_edit = $last_edit;
    }

    /**
     * @param mixed|string $likes
     */
    public function setLikes($likes): void
    {
        $this->likes = $likes;
    }
}