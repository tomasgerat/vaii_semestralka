<?php


namespace App\Controllers;


use App\Config\Configuration;
use App\Core\AControllerBase;
use App\Models\Authentificator;
use App\Models\Tools;
use App\Models\User;

class UserController extends AControllerBase
{

    public function index()
    {
        return $this->redirect("?c=User&a=login");
    }

    public function login()
    {
        $data = [];
        $data["tabTitle"] = "Login";
        if (!Tools::checkIssetPost(["submit", "login", "password", "remember"])) {
            return $this->html($data, "login");
        }

        if (Authentificator::getInstance()->login($_POST['login'], $_POST['password'])) {
            return $this->redirect("?c=Content&a=home");
        } else {
            $data = ["error" => "Wrong login or password!"];
            return $this->html($data, "login");
        }
        //TODO zapamatat si ma, remember me checkbox
    }

    public function logout()
    {
        Authentificator::getInstance()->logout();
        return $this->html(null, "logout");
    }

    public function register()
    {
        //TODO kontrola ci su hesla rovnake, cez javascript a disable/enable submit button
        //TODO ajax na realtime kontrolu ci uzivatelske meno,email uz neexistuje
        $data = [];
        $data["tabTitle"] = "Register";
        if (!Tools::checkIssetPost(["submit", "login", "password", "e_mail"])) {
            return $this->html($data, "register");
        }
        $data["login"] = $login = $_POST["login"];
        $data["password"] = $password = $_POST["password"];
        $data["e_mail"] = $e_mail = $_POST["e_mail"];
        $data["first_name"] = $first_name = (isset($_POST["first_name"]) ? $_POST["first_name"] : "");
        $data["last_name"] = $last_name = (isset($_POST["last_name"]) ? $_POST["last_name"] : "");
        if (!User::existsLogin($login)) {
            if (!User::existsEmail($e_mail)) {
                $errors = $this->validateUser($login, $password, $e_mail, $first_name, $last_name);
                if (count($errors) == 0) {
                    $user = new User($login, password_hash($password, PASSWORD_DEFAULT), $e_mail, $first_name, $last_name);
                    try {
                        $user->save();
                        $data["tabTitle"] = "Registered";
                        return $this->html($data, "registered");
                    } catch (\Exception $e) {
                        $errors["unknown"] = "Could not save User. " . (Configuration::DEBUG_EXCEPTIONS ? $e->getMessage() : "");
                    }
                }
            } else {
                $errors["e_mail"] = "E-mail already used.";
            }
        } else {
            $errors["login"] = "Login already used.";
        }
        $data["errors"] = $errors;
        return $this->html($data, "register");
    }

    public function profile()
    {
        if (!Authentificator::getInstance()->isLogged()) {
            return $this->redirect("?c=User&a=login");
        } else {
            $data = [];
            $data["tabTitle"] = "Profile";
            $data["tabCss"] = "profile.css";
            $data["tabActive"] = "profile";

            /** @var User $loggedUser */
            $loggedUser = Authentificator::getInstance()->getLoggedUser();
            $data["login"] = $loggedUser->getLogin();
            $data["e_mail"] = $loggedUser->getEMail();
            $data["first_name"] = $loggedUser->getFirstName();
            $data["last_name"] = $loggedUser->getLastName();
            if (!Tools::checkIssetPost(["submit", "e_mail"])) {
                return $this->html($data, "profile");
            }
            $data["e_mail"] = $e_mail = $_POST["e_mail"];
            $data["first_name"] = $first_name = (isset($_POST["first_name"]) ? $_POST["first_name"] : "");
            $data["last_name"] = $last_name = (isset($_POST["last_name"]) ? $_POST["last_name"] : "");
            if (!User::existsEmail($e_mail) || $e_mail == $loggedUser->getEMail()) {
                $errors = $this->validateUser($loggedUser->getLogin(), "1234567890123456", $e_mail, $first_name, $last_name);
                if (count($errors) == 0) {
                    $loggedUser->setEMail($e_mail);
                    $loggedUser->setFirstName($first_name);
                    $loggedUser->setLastName($last_name);
                    try {
                        $loggedUser->save();
                        $data["success"] = "Profile updated successfully.";
                        return $this->html($data, "profile");
                    } catch (\Exception $e) {
                        $errors["unknown"] = "Could not save User. " . (Configuration::DEBUG_EXCEPTIONS ? $e->getMessage() : "");
                    }
                }
            } else {
                $errors["e_mail"] = "E-mail already used.";
            }
            $data["errors"] = $errors;
            $data["success"] = "Failed to update profile.";
            return $this->html($data, "profile");
        }
    }

    public function change_password()
    {
        //TODO kontrola ci su hesla rovnake, cez javascript a disable/enable submit button
        if (!Authentificator::getInstance()->isLogged()) {
            return $this->redirect("?c=User&a=login");
        } else {
            $data = [];
            $data["tabTitle"] = "Profile";
            $data["tabCss"] = "profile.css";
            $data["tabActive"] = "profile";

            /** @var User $loggedUser */
            $loggedUser = Authentificator::getInstance()->getLoggedUser();
            $data["login"] = $loggedUser->getLogin();
            $data["password"] = $loggedUser->getPassword();
            $data["e_mail"] = $loggedUser->getEMail();
            $data["first_name"] = $loggedUser->getFirstName();
            $data["last_name"] = $loggedUser->getLastName();
            if (!Tools::checkIssetPost(["submit", "password"])) {
                return $this->html($data, "profile");
            }
            $password = $_POST["password"];
            $errors = $this->validateUser($loggedUser->getLogin(), $password, $loggedUser->getEMail(), $loggedUser->getFirstName(), $loggedUser->getLastName());
            if (count($errors) == 0) {
                $loggedUser->setPassword(password_hash($password, PASSWORD_DEFAULT));
                try {
                    $loggedUser->save();
                    $data["success"] = "Password changed successfully.";
                    return $this->html($data, "profile");
                } catch (\Exception $e) {
                    $errors["unknown"] = "Could not save User. " . (Configuration::DEBUG_EXCEPTIONS ? $e->getMessage() : "");
                }
            }
            $data["errors"] = $errors;
            $data["success"] = "Failed to change password.";
            return $this->html($data, "profile");
        }
    }

    private function validateUser($login, $password, $e_mail, $first_name, $last_name): array
    {
        $errors = [];
        if (strlen($login) < 3 || strlen($login) > 30) {
            $errors["login"] = "Login lenght is between 3 and 30 chars.";
        } else if (preg_match('/[\'^£$%&*()}{@#~?><,|=_+¬-]/', $login)) {
            $errors["login"] = "Login can not contains special chars.";
        }

        if (strlen($password) < 8) {
            $errors["password"] = "Minimal password length is 8.";
        }

        if (!filter_var($e_mail, FILTER_VALIDATE_EMAIL)) {
            $errors["e_mail"] = "Invalid email format";
        }

        if (strlen($first_name) > 0 && preg_match('/[\'^£$%&*()}{@#~?><,|=_+¬-]/', $first_name)) {
            $errors["first_name"] = "First name can not contains special chars.";
        }

        if (strlen($last_name) > 0 && preg_match('/[\'^£$%&*()}{@#~?><,|=_+¬-]/', $last_name)) {
            $errors["last_name"] = "Last name can not contains special chars.";
        }

        return $errors;
    }
}