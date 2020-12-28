<?php
/** @var Array $data */

include "Common/header.php";

$errors = isset($data["errors"]) ? $data["errors"] : [];
function getErrorDiv($key, $errors) : string {
    $result = '<div class="text text-danger mb-3" id="' .$key .'" name="' . $key . '">';
    if(isset($errors[$key])) {
        $result = $result . $errors[$key];
    }
    $result = $result . '</div>';
    return $result;
}

$first_name = isset($data["first_name"]) ? $data["first_name"] : "";
$last_name = isset($data["last_name"]) ? $data["last_name"] : "";
$e_mail = isset($data["e_mail"]) ? $data["e_mail"] : "";
$login = isset($data["login"]) ? $data["login"] : "";

?>

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="headline">
                <h1>Welcome to FORUM</h1>
            </div>
        </div>
        <div class="col-sm-12 instructions">
            Please register your account!
        </div>
        <?php  echo (getErrorDiv("unknown", $errors)) ?>
    </div>
    <div class="row">
        <div class="col-sm-12 col_login_form">

            <form class="login_form" method="post" action="?c=User&a=register">

                <label for="first_name">First name</label>
                <input type="text" placeholder="Enter your first name" id="first_name" name="first_name" value="<?=$first_name?>">
                <?php  echo (getErrorDiv("first_name", $errors)) ?>

                <label for="last_name">Last name</label>
                <input type="text" placeholder="Enter your last name" id="last_name" name="last_name" value="<?=$last_name?>">
                <?php  echo (getErrorDiv("last_name", $errors)) ?>

                <label for="login">Login</label>
                <input type="text" placeholder="Enter login" id="login"  name="login" value="<?=$login?>" required>
                <?php  echo (getErrorDiv("login", $errors)) ?>

                <label for="e_mail">Email</label>
                <input type="text" placeholder="Enter your e-mail address" id="e_mail" name="e_mail" value="<?=$e_mail?>" required>
                <?php  echo (getErrorDiv("e_mail", $errors)) ?>

                <label for="password">Password</label>
                <input type="password" placeholder="Enter Password" id="password" name="password" required>
                <?php  echo (getErrorDiv("password", $errors)) ?>

                <label for="confirmPass">Confirm Password</label>
                <input type="password" placeholder="Enter Password again" id="confirmPass" name="confirmPassword" required>
                <?php  echo (getErrorDiv("confirmPass", $errors)) ?>

                <input type="submit" id="submit" name="submit" value="Register">

                <label>
                    Already have an account? <a href="?c=User&a=login">Sign in</a>.
                </label>

            </form>
        </div>
    </div>
</div>
</body>
