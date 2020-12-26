<?php


namespace App\Models;


use App\Core\Model;

class Comment extends Model
{
    protected $id;
    protected $text;
    protected $created;
    protected $edited;
    protected $likes;
    protected $deleted;
    protected $topic;
    protected $autor;

    private $topicObj = null;
    private $autorObj = null;

    /**
     * Comment constructor.
     * @param $text
     * @param $created
     * @param $edited
     * @param $likes
     * @param $deleted
     * @param $topic
     * @param $autor
     */
    public function __construct($text="", $created="", $edited="", $likes="", $deleted="", $topic="", $autor="")
    {
        $this->text = $text;
        $this->created = $created;
        $this->edited = $edited;
        $this->likes = $likes;
        $this->deleted = $deleted;
        $this->topic = $topic;
        $this->autor = $autor;
    }

    static public function setDbColumns()
    {
        return ['id', 'text', 'created', 'edited', 'likes', 'deleted', 'topic', 'autor'];
    }

    static public function setTableName()
    {
        return 'comment';
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id): void
    {
        $this->id = $id;
    }

    public function getText()
    {
        return $this->text;
    }

    public function setText($text): void
    {
        $this->text = $text;
    }

    public function getCreated()
    {
        return $this->created;
    }

    public function setCreated($created): void
    {
        $this->created = $created;
    }

    public function getEdited()
    {
        return $this->edited;
    }

    public function setEdited($edited): void
    {
        $this->edited = $edited;
    }

    public function getLikes()
    {
        return $this->likes;
    }

    public function setLikes($likes): void
    {
        $this->likes = $likes;
    }

    public function getDeleted()
    {
        return $this->deleted;
    }

    public function setDeleted($deleted): void
    {
        $this->deleted = $deleted;
    }

    public function getTopic()
    {
        return $this->topic;
    }

    public function setTopic($topic): void
    {
        $this->topic = $topic;
    }

    public function getAutor()
    {
        return $this->autor;
    }

    public function setAutor($autor): void
    {
        $this->autor = $autor;
    }

    public function getTopicObj()
    {
        if($this->topicObj == null)
        {
            try {
                $this->topicObj = Topic::getOne($this->autor);
            } catch (\Exception $e) {

            }
        }
        return $this->topicObj;
    }

    public function getAutorObj()
    {
        if($this->autorObj == null)
        {
            try {
                $this->autorObj = User::getOne($this->autor);
            } catch (\Exception $e) {

            }
        }
        return $this->autorObj;
    }

}