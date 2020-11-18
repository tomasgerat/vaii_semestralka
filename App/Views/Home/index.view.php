<?php /** @var Array $data */ ?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>F Home</title>
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
    <link rel="stylesheet" href="vaii_semestralka/public/css/main.css">
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
                    <a class="nav-link active" href="?c=Home&a=index">
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
<div class="container">
    <!--<div class="row">
        <div class="d-none d-sm-block col-lg-8 col-md-8" id="top_navigation">
            <div class="navigation">
                <div class="float-left">
                    <a href="#" class="navigation_angle"><i class="fa fa-angle-left"></i></a>
                </div>
                <div class="float-left">
                    <ul>
                        <li class="navigation_page_num"><a href="#"><span class="badge badge-dark">1</span></a>
                        </li>
                        <li class="navigation_page_num"><a href="#"><span class="badge badge-dark">2</span></a>
                        </li>
                        <li class="navigation_page_num"><a href="#"><span class="badge badge-dark">3</span></a>
                        </li>
                        <li class="navigation_page_num"><a href="#"><span class="badge badge-dark">4</span></a>
                        </li>
                        <li class="navigation_page_num"><a href="#"><span class="badge badge-dark">5</span></a>
                        </li>
                        <li class="navigation_page_num"><a href="#"><span
                                        class="badge badge-dark">...</span></a></li>
                        <li class="navigation_page_num"><a href="#"><span class="badge badge-dark">10000</span></a>
                        </li>
                    </ul>
                </div>
                <div class="float-left"><a href="#" class="navigation_angle">
                        <i class="fa fa-angle-right"></i></a>
                </div>
            </div>
        </div>
    </div> -->
    <div class="row">
        <div class="d-none d-sm-block col-lg-8 col-md-8" id="top_navigation">
            <div class="navigation">

                <?php
                /** @var \App\Models\Topics[] $data */

                $pagesCount = (int)(count($data['topics']) / 10) + 1;
                if (($pagesCount > 1) && ((int)(count($data['topics']) % 10) == 0)) {
                    $pagesCount--;
                }
                $page = 0;
                if (isset($_GET['page'])) {
                    $page = $_GET['page'];
                }
                if ($pagesCount < 5) { ?>
                    <div class="float-left">
                        <a href=<?= $page < 1 ? "#" : "?c=Home&a=index&page=" . ($page - 1) ?> class="navigation_angle">
                            <i class="fa fa-angle-left"></i>
                        </a>
                    </div>
                    <div class="float-left">
                        <ul>
                            <?php for ($i = 0; $i < $pagesCount; $i++) { ?>
                                <li class="navigation_page_num">
                                    <a href="?c=Home&a=index&page=<?= $i ?>">
                                        <span class="badge badge-dark"><?= $i + 1 ?> </span>
                                    </a>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>
                    <div class="float-left">
                        <a href=<?= $page + 1 >= $pagesCount ? "#" : "?c=Home&a=index&page=" . ($page + 1) ?> class="navigation_angle">
                            <i class="fa fa-angle-right"></i>
                        </a>
                    </div>
                <?php } ?>
                <?php
                if ($pagesCount >= 5) {
                    $startIndex = $page;
                    $diff = $pagesCount - $page;
                    if ($diff < 5) {
                        $startIndex = $pagesCount - 5;
                    }
                    $endIndex = $startIndex + 5;
                    ?>

                    <div class="float-left">
                        <a href=<?= $page < 1 ? "#" : "?c=Home&a=index&page=" . ($page - 1) ?> class="navigation_angle">
                            <i class="fa fa-angle-left"></i>
                        </a>
                    </div>
                    <div class="float-left">
                        <ul>
                            <?php
                            if ($startIndex != 0) { ?>
                                <li class="navigation_page_num"><a href="?c=Home&a=index&page=0"><span
                                                class="badge badge-dark">1</span></a></li>
                                <li class="navigation_page_num"><a href="#"><span
                                                class="badge badge-dark">...</span></a></li>
                            <?php } ?>
                            <?php
                            for ($i = $startIndex; $i < $endIndex; $i++) { ?>
                                <li class="navigation_page_num">
                                    <a href="?c=Home&a=index&page=<?= $i ?>">
                                        <span class="badge badge-dark"><?= $i + 1 ?></span>
                                    </a>
                                </li>
                            <?php } ?>
                            <?php
                            if ($endIndex != $pagesCount) { ?>
                                <li class="navigation_page_num">
                                    <a href="#"><span class="badge badge-dark">...</span></a>
                                </li>
                                <li class="navigation_page_num">
                                    <a href="?c=Home&a=index&page=<?= $pagesCount - 1 ?>">
                                        <span class="badge badge-dark"><?= $pagesCount ?></span>
                                    </a>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>
                    <div class="float-left">
                        <a href=<?= $page + 1 >= $pagesCount ? "#" : "?c=Home&a=index&page=" . ($page + 1) ?> class="navigation_angle">
                            <i class="fa fa-angle-right"></i>
                        </a>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-8 col-md-8" id="topics_place">
            <!--Generovat podla databazy-->
            <?php
            /** @var \App\Models\Topics[] $data */
            //foreach ($data['topics'] as $topic) {
            $page = 0;
            if (isset($_GET['page'])) {
                $page = $_GET['page'];
            }
            $startIndex = $page * 10;
            $endIndex = $startIndex + 10;
            for ($i = $startIndex; $i < $endIndex; $i++) {
                if ($i >= count($data['topics'])) {
                    break;
                }
                $topic = $data['topics'][$i];
                ?>
                <div class="container topic_frame">
                    <div class="row">
                        <div class="container col-sm-10 col-12">
                            <div class="row ">
                                <div class="col-sm-3 col-12 topic_info">
                                    <div class="bold topic_category"> <?= $topic->getKategory() ?> </div>
                                    <div class="topic_author"><?= $topic->getAutor() ?></div>
                                    <div class="">
                                        <a href=<?= /** @var \App\Models\Topics $topic */
                                        "?c=Topic&a=delete&id=" . $topic->getID() ?> class="crud_button">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                        <a href=<?= /** @var \App\Models\Topics $topic */
                                        "?c=Topic&a=edit&id=" . $topic->getID() ?> class="crud_button">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-sm-9 col-12 topic_text">
                                    <h3>
                                        <a class="topic_headline" href= <?= /** @var \App\Models\Topics $topic */
                                        "?c=Topic&a=index&id=" . $topic->getID() ?>>
                                            <?= $topic->getTitle() ?>
                                        </a>
                                    </h3>
                                    <p>
                                        <?= $topic->getText() ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-2 col-12 stats topic_stats">
                            <div class="stats topic_comments">
                                <i class="fa fa-comment"></i>
                                <?= strlen($topic->getComments()) < 2 ? "0" . $topic->getComments() : $topic->getComments() ?>
                            </div>
                            <div class="stats topic_views">
                                <i class="fa fa-eye"></i>
                                <?= strlen($topic->getViews()) < 2 ? "0" . $topic->getViews() : $topic->getViews() ?>
                            </div>
                            <div class="stats topic_time">
                                <i class="fa fa-clock"></i>
                                <?= strlen($topic->getTimeBefor()) < 2 ? "0" . $topic->getTimeBefor() : $topic->getTimeBefor() ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
        <div class="col-lg-4 col-md-4">
            <div class="stats_block ">
                <h3>Categories</h3>
                <div class="line"></div>
                <ul class="categories_list" id="stats_place">
                    <!-- Generovat podla databazy-->
                    <?php /** @var \App\Models\Categories[] $data */ ?>
                    <li><a href="#">Computers <span
                                    class="badge badge-secondary float-right"><?= $data['categories'][0]->getComputers() ?></span></a>
                    </li>
                    <li><a href="#">Games <span
                                    class="badge badge-secondary float-right"><?= $data['categories'][0]->getGames() ?></span></a>
                    </li>
                    <li><a href="#">Science <span
                                    class="badge badge-secondary float-right"><?= $data['categories'][0]->getScience() ?></span></a>
                    </li>
                    <li><a href="#">Movies <span
                                    class="badge badge-secondary float-right"><?= $data['categories'][0]->getMovies() ?></span></a>
                    </li>
                    <li><a href="#">Music <span
                                    class="badge badge-secondary float-right"><?= $data['categories'][0]->getMusic() ?></span></a>
                    </li>
                    <li><a href="#">Other <span
                                    class="badge badge-secondary float-right"><?= $data['categories'][0]->getOther() ?></span></a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-8 col-md-8" id="bottom_navigation">
            <div class="navigation">

                <?php
                /** @var \App\Models\Topics[] $data */

                $pagesCount = (int)(count($data['topics']) / 10) + 1;
                if (($pagesCount > 1) && ((int)(count($data['topics']) % 10) == 0)) {
                    $pagesCount--;
                }
                $page = 0;
                if (isset($_GET['page'])) {
                    $page = $_GET['page'];
                }
                if ($pagesCount < 5) { ?>
                    <div class="float-left">
                        <a href=<?= $page < 1 ? "#" : "?c=Home&a=index&page=" . ($page - 1) ?> class="navigation_angle">
                            <i class="fa fa-angle-left"></i>
                        </a>
                    </div>
                    <div class="float-left">
                        <ul>
                            <?php for ($i = 0; $i < $pagesCount; $i++) { ?>
                                <li class="navigation_page_num">
                                    <a href="?c=Home&a=index&page=<?= $i ?>">
                                        <span class="badge badge-dark"><?= $i + 1 ?> </span>
                                    </a>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>
                    <div class="float-left">
                        <a href=<?= $page + 1 >= $pagesCount ? "#" : "?c=Home&a=index&page=" . ($page + 1) ?> class="navigation_angle">
                            <i class="fa fa-angle-right"></i>
                        </a>
                    </div>
                <?php } ?>
                <?php
                if ($pagesCount >= 5) {
                    $startIndex = $page;
                    $diff = $pagesCount - $page;
                    if ($diff < 5) {
                        $startIndex = $pagesCount - 5;
                    }
                    $endIndex = $startIndex + 5;
                    ?>

                    <div class="float-left">
                        <a href=<?= $page < 1 ? "#" : "?c=Home&a=index&page=" . ($page - 1) ?> class="navigation_angle">
                            <i class="fa fa-angle-left"></i>
                        </a>
                    </div>
                    <div class="float-left">
                        <ul>
                            <?php
                            if ($startIndex != 0) { ?>
                                <li class="navigation_page_num"><a href="?c=Home&a=index&page=0"><span
                                                class="badge badge-dark">1</span></a></li>
                                <li class="navigation_page_num"><a href="#"><span
                                                class="badge badge-dark">...</span></a></li>
                            <?php } ?>
                            <?php
                            for ($i = $startIndex; $i < $endIndex; $i++) { ?>
                                <li class="navigation_page_num">
                                    <a href="?c=Home&a=index&page=<?= $i ?>">
                                        <span class="badge badge-dark"><?= $i + 1 ?></span>
                                    </a>
                                </li>
                            <?php } ?>
                            <?php
                            if ($endIndex != $pagesCount) { ?>
                                <li class="navigation_page_num">
                                    <a href="#"><span class="badge badge-dark">...</span></a>
                                </li>
                                <li class="navigation_page_num">
                                    <a href="?c=Home&a=index&page=<?= $pagesCount - 1 ?>">
                                        <span class="badge badge-dark"><?= $pagesCount ?></span>
                                    </a>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>
                    <div class="float-left">
                        <a href=<?= $page + 1 >= $pagesCount ? "#" : "?c=Home&a=index&page=" . ($page + 1) ?> class="navigation_angle">
                            <i class="fa fa-angle-right"></i>
                        </a>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
</body>