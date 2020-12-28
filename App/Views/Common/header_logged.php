<?php /** @var Array $data */
$title = isset($data["tabTitle"]) ? $data["tabTitle"] : "Forum";
$css = isset($data["tabCss"]) ? $data["tabCss"] : "";
$active = isset($data["tabActive"]) ? $data["tabActive"] : "";
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title> <?=$title ?> </title>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
            integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
            crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="forum/public/bootstrap/js/bootstrap.min.js"></script>
    <script src="forum/public/ckeditor/ckeditor.js"></script>
    <link rel="stylesheet" href="forum/public/fontawesome/css/all.css">
    <link rel="stylesheet" href="forum/public/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="forum/public/css/general.css">
    <?php if(!empty($css)) echo '<link rel="stylesheet" href="forum/public/css/' . $css . '">' ?>
</head>
<body>
<div class="container-fluid sticky-top">
    <nav class="navbar navbar-expand-md navbar-light custom_navbar">
        <a class="navbar-brand" href="?c=Content&a=home">
            <img src="forum/public/img/F.png" width="20" height="30" alt="">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mt-2 mt-lg-0">
                <li class="nav-item">
                    <a class="nav-link <?php if($active == "home") echo 'active' ?>" href="?c=Content&a=home">
                        <i class="fa fa-home"></i> Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php if($active == "recent") echo 'active' ?>" href="?c=Content&a=recent">
                        <i class="fa fa-clock"></i> Recent</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php if($active == "add") echo 'active' ?>" href="?c=Topic&a=add">
                        <i class="fa fa-plus-circle"></i> Add</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php if($active == "profile") echo 'active' ?>" href="?c=User&a=profile">
                        <i class="fa fa-user"></i> Profile</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link only_icon" href="?c=User&a=logout">
                        <i class="fa fa-sign-out-alt"></i></a>
                </li>
            </ul>
            <form class="form-inline ml-auto mt-2 my-lg-0" method="get" >
                <input type="hidden" name="c" value="Content">
                <input type="hidden" name="a" value="search">
                <input class="form-control mr-sm-2" type="search" name="searchText" id="searchText" placeholder="Search" aria-label="Search">
                <button class="btn btn-dark btn-outline-light my-2 my-sm-0" type="submit">Search</button>
            </form>
        </div>
    </nav>
</div>
<!-- **************************************************************** -->

