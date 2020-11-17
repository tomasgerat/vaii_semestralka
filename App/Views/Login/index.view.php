<?php ?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
            integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
            crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
            integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
            crossorigin="anonymous"></script>

    <script src="vaii_semestralka/public/bootstrap/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="vaii_semestralka/public/bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="vaii_semestralka/public/css/reg_log.css">
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="headline">
                <h1>Welcome to FORUM</h1>
            </div>
        </div>
        <div class="col-sm-12 instructions">
            Please login or <a href="?c=Register&a=index">register</a>!
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <form class="login_form">
                <label for="username">Username</label>
                <input type="text" placeholder="Enter Username" id="username" required>

                <label for="password">Password</label>
                <input type="password" placeholder="Enter Password" id="password" required>

                <button type="button" onclick="location.href='?c=Home&a=index'">Login</button>

                <label>
                    <input type="checkbox" checked="checked" name="remember"> Remember me
                </label>

            </form>
        </div>
    </div>
</div>
</body>