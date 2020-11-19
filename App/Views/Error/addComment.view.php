<?php /** @var Array $data */ ?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>F Delete</title>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
            integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
            crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
            integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
            crossorigin="anonymous"></script>
    <script src="vaii_semestralka/public/bootstrap/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="vaii_semestralka/public/fontawesome/css/all.css">
    <link rel="stylesheet" href="vaii_semestralka/public/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="vaii_semestralka/public/css/general.css">
    <link rel="stylesheet" href="vaii_semestralka/public/css/add.css">
</head>
<body>
<div class="container sticky-top">
    <nav class="navbar navbar-expand-md navbar-light custom_navbar">
        <a class="navbar-brand" href="?c=Home&a=index">
            <img src="vaii_semestralka/public/img/F.png" width="20" height="30" alt="">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mt-2 mt-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="?c=Home&a=index">
                        <i class="fa fa-home"></i> Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="fa fa-clock"></i> Recent</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="?c=Add&a=index">
                        <i class="fa fa-plus-circle"></i> Add</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link " href="?c=Profile&a=index">
                        <i class="fa fa-user"></i> Profile</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link " href="?c=Login&a=index">
                        <i class="fa fa-sign-out-alt"></i></a>
                </li>
            </ul>
            <form class="form-inline ml-auto mt-2 my-lg-0">
                <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-dark btn-outline-light my-2 my-sm-0" type="submit">Search</button>
            </form>
        </div>
    </nav>
</div>
<!-- **************************************************************** -->

<div class="container mt-5 mb-3">
    <p><h1>Internal Server Error</h1></p>
    <p><h1><?=$data['text']?></h1></p>
</div>

