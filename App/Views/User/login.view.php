<?php
/** @var Array $data */

include "Common/header.php"
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="headline">
                <h1>Welcome to FORUM</h1>
            </div>
        </div>
        <div class="col-sm-12 instructions">
            Please login or <a href="?c=User&a=register">register</a>!
        </div>
        <div class="col-sm-12 instructions">
            <?php
            if(isset($data['error'])) {
            ?>
                <div class="text-center text-danger mb-3">
                    <?= $data['error'] ?>
                </div>
            <?php } ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <form class="login_form" action="?c=User&a=login" method="post">
                <label for="username">Username</label>
                <input type="text" placeholder="Enter login" name="login" id="login" required>

                <label for="password">Password</label>
                <input type="password" placeholder="Enter password" name="password" id="password" required>

                <input type="submit" name="submit" value="Login">

            </form>
        </div>
    </div>
</div>
</body>