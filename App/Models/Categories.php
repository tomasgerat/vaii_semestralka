<?php


namespace App\Models;

use App\App;
use PDO;
use PDOException;

class Categories
{
    protected static $db = null;
    private $computers;
    private $games;
    private $science;
    private $movies;
    private $music;
    private $other;
    static public function getDbColumns()
    {
        return ['computers', 'games', 'science', 'movies', 'music', 'other'];
    }

    static public function getTableName()
    {
        return "topic";
    }

    static public function getAllCategories() {
        self::connect();
        try {
      /*      select (select count(*) from topic where kategory=0) as computers,
       (select count(*) from topic where kategory=1) as games,
       (select count(*) from topic where kategory=2) as science,
        (select count(*) from topic where kategory=3) as movies,
       (select count(*) from topic where kategory=4) as music,
        (select count(*) from topic where kategory=5) as other;*/
            $stmt = self::$db->query("select (select count(*) from topic where kategory=0) as computers,
       (select count(*) from topic where kategory=1) as games,
       (select count(*) from topic where kategory=2) as science,
        (select count(*) from topic where kategory=3) as movies,
       (select count(*) from topic where kategory=4) as music,
        (select count(*) from topic where kategory=5) as other");
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
    protected static function getConnection() : PDO
    {
        self::connect();
        return self::$db;
    }

    /**
     * @return mixed
     */
    public function getComputers()
    {
        return $this->computers;
    }

    /**
     * @return mixed
     */
    public function getGames()
    {
        return $this->games;
    }

    /**
     * @return mixed
     */
    public function getScience()
    {
        return $this->science;
    }

    /**
     * @return mixed
     */
    public function getMovies()
    {
        return $this->movies;
    }

    /**
     * @return mixed
     */
    public function getMusic()
    {
        return $this->music;
    }

    /**
     * @return mixed
     */
    public function getOther()
    {
        return $this->other;
    }
}