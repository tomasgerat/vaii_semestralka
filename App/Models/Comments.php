<?php

namespace App\Models;

use App\App;
use PDO;
use PDOException;

class Comments
{
    protected static $db = null;
    protected static $pkColumn = 'id';
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
     * Gets a db columns from a model
     * @return mixed
     */
    protected static function getDbColumns()
    {
        return static::setDbColumns();
    }

    /**
     * Reads the table name from a model
     * @return mixed
     */
    protected static function getTableName()
    {
        return static::setTableName();
    }

    /**
     * Creates a new connection to DB, if connection already exists, returns the existing one
     */
    protected static function connect()
    {
        $config = App::getConfig();
        try {
            if (self::$db == null) {
                self::$db = new PDO('mysql:dbname=' . $config::DB_NAME . ';host=' . $config::DB_HOST, $config::DB_USER, $config::DB_PASS);
                self::$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }
        } catch (PDOException $e) {
            throw new \Exception('Connection failed: ' . $e->getMessage());
        }
    }

    /**
     * Gets DB connection for additional model methods
     * @return null
     */
    protected static function getConnection(): PDO
    {
        self::connect();
        return self::$db;
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

    public function getTimeBefor()
    {
        //2020-11-17 13:06:01
        $d1 = time();
        $d2 = strtotime($this->getLastEdit());
        $diff = $d1 - $d2;
        if (((int)($diff / 60 / 60 / 24 / 365)) > 0) {
            return (int)($diff / 60 / 60 / 24 / 365) . " y";
        }
        if (((int)($diff / 60 / 60 / 24)) > 0) {
            return (int)($diff / 60 / 60 / 24) . " d";
        }
        if (((int)($diff / 60 / 60)) > 0) {
            return (int)($diff / 60 / 60) . " h";
        }
        if (((int)($diff / 60)) > 0) {
            return (int)($diff / 60) . " m";
        }
        return ((int)($diff)) . " s";
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
}