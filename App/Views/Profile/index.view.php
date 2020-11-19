<?php ?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>F Profile</title>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
            integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
            crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="vaii_semestralka/public/bootstrap/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="vaii_semestralka/public/fontawesome/css/all.css">
    <link rel="stylesheet" href="vaii_semestralka/public/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="vaii_semestralka/public/css/general.css">
    <link rel="stylesheet" href="vaii_semestralka/public/css/profile.css">
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
                    <a class="nav-link active" href="?c=Profile&a=index">
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
    <div class="row">
        <div class="col-12 col-md-6">
            <div class="profile_holder">
                <img src="vaii_semestralka/public/img/profile_img.png" class="profil_img" alt="profile image">
                <h1 id="holder_fullname">Tomas Gerat</h1>
            </div>
        </div>
        <div class="col-12 col-md-6">
            <div class="profile_info">
                <form class="info_form">
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="fullname">Name</label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" class="form-control" id="fullname" value="Tomas Gerat">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="username">Username</label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" class="form-control" id="username" value="tomas">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="email">Email</label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" class="form-control" id="email" value="gerat9@stud.uniza.sk">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="phoneNumber">Phone number:</label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" class="form-control" id="phoneNumber" value="+42195632156">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="password">Password:</label>
                        </div>
                        <div class="col-md-8">
                            <input type="password" class="form-control" id="password" value="">
                        </div>
                    </div>
                    <button type="button" class="mb-3 btn  btn-lg btn-dark btn-block btn-outline-light" onclick="preformSave()">
                        Save
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>