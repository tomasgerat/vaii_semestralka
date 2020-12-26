<?php


namespace App\Models;

use App\Core\Model;

class Topic  extends Model
{
    protected $id;
    protected $title;
    protected $text;
    protected $created;
    protected $edited;
    protected $views;
    protected $category;
    protected $autor;

    private $autorObj = null;

    /**
     * Topic constructor.
     * @param $title
     * @param $text
     * @param $created
     * @param $edited
     * @param $views
     * @param $category
     * @param $autor
     */
    public function __construct($title="", $text="", $created="", $edited="", $views="", $category="", $autor="")
    {
        $this->title = $title;
        $this->text = $text;
        $this->created = $created;
        $this->edited = $edited;
        $this->views = $views;
        $this->category = $category;
        $this->autor = $autor;
    }


    static public function setDbColumns()
    {
        return ['id', 'title', 'text', 'created', 'edited', 'views', 'category', 'autor'];
    }

    static public function setTableName()
    {
        return 'topic';
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id): void
    {
        $this->id = $id;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title): void
    {
        $this->title = $title;
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


    public function getViews()
    {
        return $this->views;
    }

    public function setViews($views): void
    {
        $this->views = $views;
    }

    public function getCategory()
    {
        return $this->category;
    }

    public function setCategory($category): void
    {
        $this->category = $category;
    }

    public function getAutor()
    {
        return $this->autor;
    }

    public function setAutor($autor): void
    {
        $this->autor = $autor;
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