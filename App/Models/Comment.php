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
    protected $deleted;
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
        return ['id','text', 'created', 'last_edit', 'likes', 'deleted', 'topicID', 'autor'];
    }

    static public function setTableName()
    {
        return "comment";
    }

    static public function getAllForTopic($id)
    {
        self::connect();
        try {
            //$stmt = self::$db->query("SELECT * FROM " . self::getTableName());
            //select * from comment where 1 = topicID order by created;
            $stmt = self::$db->query("SELECT * from ".self::getTableName()." where ".$id." = topicID order by created");
            $dbModels = $stmt->fetchAll();
            $models = [];
            foreach ($dbModels as $model) {
                $tmpModel = new static();
                $data = array_fill_keys(self::getDbColumns(), null);
                foreach ($data as $key => $item) {
                    $tmpModel->$key = $model[$key];
                }
                $models[] = $tmpModel;
            }
            return $models;
        } catch (PDOException $e) {
            throw new \Exception('Query failed: ' . $e->getMessage());
        }
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

    /**
     * @return mixed
     */
    public function getDeleted()
    {
        return $this->deleted;
    }

    /**
     * @param mixed $deleted
     */
    public function setDeleted($deleted): void
    {
        $this->deleted = $deleted;
    }
}