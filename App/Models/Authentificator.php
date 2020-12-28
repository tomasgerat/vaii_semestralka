<?php

namespace App\Models;

use App\Models\User;

class Authentificator
{
    private static $instance = null;
    /**
     * Authentificator constructor.
     */
    private function __construct()
    {
        session_start();
    }

    public static function getInstance() {
        if(self::$instance == null)
        {
            self::$instance = new Authentificator();
        }
        return self::$instance;
    }

    public function login($login, $password)
    {
        $users = User::getAll("login = ?", [$login]);
        if(count($users) == 1) {
            $user = $users[0];
            if(password_verify($password, $user->getPassword())) {
                $_SESSION['user'] = $user;
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function logout()
    {
        if(isset($_SESSION['user'])) {
            unset($_SESSION['user']);
            session_destroy();
        }
    }

    public function getLoggedUser()
    {
        return $_SESSION['user'];
    }

    public function isLogged()
    {
        return (isset($_SESSION['user']) && $_SESSION['user'] != null);
    }

    public function isAdminLogged() {
        if(isset($_SESSION['user']) && $_SESSION['user'] != null) {
            /** @var User $user */
            $user = $this->getLoggedUser();
            if($user->getLogin() == "admin") {
                return true;
            }
        }
        return false;
    }
}