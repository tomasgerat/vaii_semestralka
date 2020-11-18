<?php


namespace App\Models;

use App\App;
use App\Core\Model;
use PDO;
use PDOException;

class User
{
    protected static $db = null;
    protected static $pkColumn = 'login';
    private $login;
    private $password;
    private $e_mail;
    private $name;
    private $surname;

    /**
     * User constructor.
     */
    public function __construct($login="", $password="", $e_mail="", $name="", $surname="")
    {
        $this->login = $login;
        $this->password = $password;
        $this->e_mail = $e_mail;
        $this->name = $name;
        $this->surname = $surname;
    }

    /**
     * Gets a db columns from a model
     * @return mixed
     */
    protected static function getDbColumns()
    {
        return ['login', 'password', 'e_mail', 'name', 'surname'];
    }

    /**
     * Reads the table name from a model
     * @return mixed
     */
    protected static function getTableName()
    {
        return 'user';
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
     * Return an array of models from DB
     * @return static[]
     */
    static public function getAll()
    {
        self::connect();
        try {
            $stmt = self::$db->query("SELECT * FROM " . self::getTableName());
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
     * Gets one model by primary key
     * @param $login
     * @throws \Exception
     */
    static public function getOne($login)
    {
        self::connect();
        try {
            $sql = "SELECT * FROM " . self::getTableName() . " WHERE login=\"$login\"";
            $stmt = self::$db->prepare($sql);
            $stmt->execute([$login]);
            $model = $stmt->fetch();
            if ($model) {
                $data = array_fill_keys(self::getDbColumns(), null);
                $tmpModel = new static();
                foreach ($data as $key => $item) {
                    $tmpModel->$key = $model[$key];
                }
                return $tmpModel;
            } else {
                throw new \Exception('Record not found!');
            }
        } catch (PDOException $e) {
            throw new \Exception('Query failed: ' . $e->getMessage());
        }
    }

    /**
     * Saves the current model to DB (if model login exists, updates it, else creates a new model)
     * @return mixed
     */
    public function save()
    {
        self::connect();
        try {
            $data = array_fill_keys(self::getDbColumns(), null);
            foreach ($data as $key => &$item) {
                $item = $this->$key;
            }
            $l = $data[self::$pkColumn]; //login
            $sql = "SELECT * FROM " . self::getTableName() . " WHERE login=\"$l\"";
            $stmt = self::$db->prepare($sql);
            $stmt->execute([$l]);
            $model = $stmt->fetch();
            if ($model == null) {
                $arrColumns = array_map(fn($item) => (':' . $item), array_keys($data));
                $columns = implode(',', array_keys($data));
                $params = implode(',', $arrColumns);
                $sql = "INSERT INTO " . self::getTableName() . " ($columns) VALUES ($params)";
                self::$db->prepare($sql)->execute($data);
                return self::$db->lastInsertId();
            } else {
                $arrColumns = array_map(fn($item) => ($item . '=:' . $item), array_keys($data));
                $columns = implode(',', $arrColumns);
                $sql = "UPDATE " . self::getTableName() . " SET $columns WHERE login=:" . self::$pkColumn;
                self::$db->prepare($sql)->execute($data);
                return $data[self::$pkColumn];
            }
        } catch (PDOException $e) {
            throw new \Exception('Query failed: ' . $e->getMessage());
        }
    }

    /**
     * Deletes current model from DB
     * @throws \Exception If model not exists, throw an exception
     */
    public function delete()
    {
        if ($this->{self::$pkColumn} == null) {
            return;
        }
        self::connect();
        try {
            $sql = "DELETE FROM " . self::getTableName() . " WHERE login=?";
            $stmt = self::$db->prepare($sql);
            $stmt->execute([$this->{self::$pkColumn}]);
            if ($stmt->rowCount() == 0) {
                throw new \Exception('Model not found!');
            }
        } catch (PDOException $e) {
            throw new \Exception('Query failed: ' . $e->getMessage());
        }
    }

    /**
     * @return mixed
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @return mixed
     */
    public function getEMail()
    {
        return $this->e_mail;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getSurname()
    {
        return $this->surname;
    }
}