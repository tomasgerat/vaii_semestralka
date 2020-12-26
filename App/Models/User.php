<?php

namespace  App\Models;

use App\Core\Model;

class User extends Model
{
    protected $id;
    protected $login;
    protected $password;
    protected $e_mail;
    protected $first_name;
    protected $last_name;

    /**
     * User constructor.
     * @param $login
     * @param $password
     * @param $e_mail
     * @param $first_name
     * @param $last_name
     */
    public function __construct($login="", $password="", $e_mail="", $first_name="", $last_name="")
    {
        $this->login = $login;
        $this->password = $password;
        $this->e_mail = $e_mail;
        $this->first_name = $first_name;
        $this->last_name = $last_name;
    }

    public static function existsEmail(string $e_mail) : bool
    {
        try {
            return (count(User::getAll("e_mail = ?", [$e_mail])) == 0 ? false : true);
        } catch (\Exception $e) {
            return true;
        }
    }

    public static function existsLogin(string $login) : bool
    {
        try {
            return (count(User::getAll("login = ?", [$login])) == 0 ? false : true);
        } catch (\Exception $e) {
            return true;
        }
    }

    static public function setDbColumns()
    {
        return [ 'id', 'login', 'password', 'e_mail', 'first_name', 'last_name'];
    }

    static public function setTableName()
    {
        return 'user';
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id): void
    {
        $this->id = $id;
    }

    public function getLogin()
    {
        return $this->login;
    }

    public function setLogin($login): void
    {
        $this->login = $login;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password): void
    {
        $this->password = $password;
    }

    public function getEMail()
    {
        return $this->e_mail;
    }

    public function setEMail($e_mail): void
    {
        $this->e_mail = $e_mail;
    }

    public function getFirstName()
    {
        return $this->first_name;
    }

    public function setFirstName($first_name): void
    {
        $this->first_name = $first_name;
    }

    public function getLastName()
    {
        return $this->last_name;
    }

    public function setLastName($last_name): void
    {
        $this->last_name = $last_name;
    }
}