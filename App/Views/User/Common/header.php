<?php /** @var Array $data */
    $title = isset($data["tabTitle"]) ? $data["tabTitle"] : "Forum";
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title> <?=$title ?> </title>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
            integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
            crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
            integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
            crossorigin="anonymous"></script>

    <script src="forum/public/bootstrap/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="forum/public/bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="forum/public/css/general.css">
    <link rel="stylesheet" href="forum/public/css/reg_log.css">
</head>

<body>
    <div class="container">
        <nav class="navbar navbar-expand-md navbar-light custom_navbar">
            <a class="navbar-brand" href="?c=Content&a=home">
                <img src="forum/public/img/F.png" id="img_logo" alt="">
            </a>

        </nav>
    </div>