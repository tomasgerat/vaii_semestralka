<?php


namespace App\Models;

use App\Core\Model;
class Topics extends Model
{
    protected $id;
    protected $title;
    protected $text;
    protected $created;
    protected $last_edit;
    protected $views;
    protected $autor;
    protected $kategory;
    protected $comments;

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
        return ['id', 'title', 'text', 'created', 'last_edit', 'views', 'kategory', 'autor', 'comments'];
    }

    static public function setTableName()
    {
        return "topic";
    }

    static  public function getAllForUser($login)
    {
        self::connect();
        try {
            //$stmt = self::$db->query("SELECT * FROM " . self::getTableName());
            //select distinct *, (select count(*) from comment where tt.ID = topicID) as comments
            // from topic as tt where (ID in (select distinct topicID from comment where autor like 'jano')) or (autor like 'jano');
            $stmt = self::$db->query("SELECT DISTINCT *, (select count(*) from comment where tt.ID = topicID) as comments FROM " . self::getTableName()
            . " as tt where ( ID in ".
            " (SELECT DISTINCT topicID from comment where autor like '" . $login . "' )) or (autor like '" . $login . "' )" );
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
    public function getKategory()
    {
       /* Computers10
        Games20
        Science30
        Movies45
        Music12
        Other*/
        switch ($this->kategory) {
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

    /**
     * @return mixed|string
     */
    public function getViews()
    {
        return $this->views;
    }

    /**
     * @return mixed
     */
    public function getComments()
    {
        return $this->comments;
    }

    public function getTimeBefor()
    {
        //2020-11-17 13:06:01
        $d1=time();
        $d2=strtotime($this->getCreated());
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
            return (int)($diff / 60 / 60) . " m";
        }
        return ((int)($diff / 60 )) . " s";
    }
}