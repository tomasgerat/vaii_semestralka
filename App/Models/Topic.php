<?php


namespace App\Models;

use App\Core\Model;
class Topic extends Model
{
    protected $id;
    protected $title;
    protected $text;
    protected $created;
    protected $last_edit;
    protected $views;
    protected $autor;
    protected $kategory;

    public function __construct($title = "", $text = "", $created = "", $last_edit = "", $views = "", $autor = "", $kategory = "")
    {
        $this->title = $title;
        $this->text = $text;
        $this->created = $created;
        $this->last_edit = $last_edit;
        $this->views = $views;
        $this->autor = $autor;
        $this->kategory = $kategory;
    }

    static public function setDbColumns()
    {
        return ['id', 'title', 'text', 'created', 'last_edit', 'views', 'kategory', 'autor'];
    }

    static public function setTableName()
    {
        return "topic";
    }

    /**
     * @return mixed
     */
    public function getID()
    {
        return $this->id;
    }

    /**
     * @return mixed|string
     */
    public function getTitle()
    {
        return $this->title;
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
    public function getAutor()
    {
        return $this->autor;
    }

    /**
     * @return mixed|string
     */
    public function getViews()
    {
        return $this->views;
    }

    /**
     * @param mixed|string $title
     */
    public function setTitle($title): void
    {
        $this->title = $title;
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
     * @param mixed|string $kategory
     */
    public function setKategory($kategory): void
    {
        $this->kategory = $kategory;
    }

    /**
     * @param mixed|string $views
     */
    public function setViews($views): void
    {
        $this->views = $views;
    }
}