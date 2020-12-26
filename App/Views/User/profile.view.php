<?php
/** @var Array $data */

use \App\Models\Tools;

include dirname(__DIR__) . "../Common/header_logged.php";

$first_name = isset($data["first_name"]) ? $data["first_name"] : "";
$last_name = isset($data["last_name"]) ? $data["last_name"] : "";
$e_mail = isset($data["e_mail"]) ? $data["e_mail"] : "";
$login = isset($data["login"]) ? $data["login"] : "";
$full_name = $first_name . ' ' . $last_name;
if (empty($full_name))
    $full_name = $login;
$errors = isset($data["errors"]) ? $data["errors"] : [];

?>

<div class="container mt-5 mb-3">
    <div class="row">
        <?php echo Tools::getErrorDiv("unknow", $errors) ?>
    </div>
    <div class="row">
        <div class="container col-12 col-md-6 text-center">
            <div class="text-center text-dark mb-5" id="success" name="success">
                <h5>
                    <?php if (isset($data["success"])) echo $data["success"] ?>
                </h5>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12 col-md-6">
            <div class="profile_holder">
                <img src="forum/public/img/profile_img.png" class="profil_img" alt="profile image">
                <h1><?= $full_name ?></h1>
            </div>
        </div>
        <div class="col-12 col-md-6">
            <div class="profile_info">
                <form class="info_form mb-5" method="post" action="?c=User&a=profile">
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="login">Login</label>
                        </div>
                        <div class="col-md-8">
                            <input disabled type="text" class="form-control" id="login" name="login"
                                   value="<?= $login ?>">
                        </div>
                    </div>
                    <?php echo Tools::getErrorDiv("login", $errors) ?>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="first_name">First name</label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" class="form-control" id="first_name" name="first_name"
                                   value="<?= $first_name ?>">
                        </div>
                    </div>
                    <?php echo Tools::getErrorDiv("first_name", $errors) ?>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="last_name">First name</label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" class="form-control" id="last_name" name="last_name"
                                   value="<?= $last_name ?>">
                        </div>
                    </div>
                    <?php echo Tools::getErrorDiv("last_name", $errors) ?>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="e_mail">E-mail</label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" class="form-control" id="e_mail" name="e_mail" value="<?= $e_mail ?>"  required>
                        </div>
                    </div>
                    <?php echo Tools::getErrorDiv("e_mail", $errors) ?>
                    <button type="submit" name="submit" class="mb-3 btn  btn-lg btn-dark btn-block btn-outline-light">
                        Save
                    </button>
                </form>
                <form class="info_form mt-5" method="post" action="?c=User&a=change_password">
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="password">Password:</label>
                        </div>
                        <div class="col-md-8">
                            <input type="password" class="form-control" id="password" name="password" value="" required>
                        </div>
                    </div>
                    <?php echo Tools::getErrorDiv("password", $errors) ?>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="confirm_pass">Confirm password:</label>
                        </div>
                        <div class="col-md-8">
                            <input type="password" class="form-control" id="confirm_pass" name="confirm_pass" value="" required>
                        </div>
                    </div>
                    <button type="submit" name="submit" class="mb-3 btn  btn-lg btn-dark btn-block btn-outline-light">
                        Change
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
</body?