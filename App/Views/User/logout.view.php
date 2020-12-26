<?php
/** @var Array $data */
include "common/header.php";
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12 mb-5 mt-5">
            <div class="headline">
                <h1 class="font-weight-bold">FORUM</h1>
            </div>
        </div>
    </div>
    <div class="row">
        <img id="bye_img" src="forum/public/img/bye.png">
    </div>
    <div class="row">
        <div class="container col-sm-12 col-md-5 mb-5 instructions">
            <h5>
                Thank you for using Forum. You have been logged out. To log into this site again, click below.
            </h5>
        </div>
        <div class="col-sm-12 instructions">
            <button type="button" onclick="location.href='?c=User&a=login'">Login</button>
        </div>
    </div>
</div>
</body>