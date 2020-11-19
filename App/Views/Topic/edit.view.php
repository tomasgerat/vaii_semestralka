<?php /** @var Array $data */ ?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>F Edit</title>
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
<?php
$topic_title = "";
$topic_text = "";
$topic_id = -1;
//$topic_category = null;
$title_erors = [];
$text_errors = [];
$category_errors = [];
if ($data != null) {
    if (isset($data['topic'])) {
        /** @var \App\Models\Topics $topic */
        $topic = $data['topic'];
        $topic_title = $topic->getTitle();
        $topic_text = $topic->getText();
       // $topic_category = $topic->getKategory();
        $topic_id = $topic->getID();
    }
    if (isset($data['errors'])) {
        if (isset($data['errors']['title'])) {
            $title_erors = $data['errors']['title'];
        }
        if (isset($data['errors']['text'])) {
            $text_errors = $data['errors']['text'];
        }
        if (isset($data['errors']['category'])) {
            $category_errors = $data['errors']['category'];
        }
    }
}
?>
<div class="container mt-5 mb-3">
    <div id="add_form_holder">
        <form class="info_form" action="?c=Topic&a=edit&id=<?=$topic_id?>" method="post" autocomplete="off">
            <div class="row mb-3">
                <label for="topic_name">Topic name</label>
                <input type="text" class="form-control" id="topic_name" name="topic_name"
                       placeholder="Name of the topic" value="<?= $topic_title ?>" required>
                <p class="text_erors">
                    <?php
                    foreach ($title_erors as $err) { ?>
                        <?=$err?><br>
                        <?php
                    }
                    ?>
                </p>
            </div>
            <div class="row mb-3">
                <label for="topic_text">Topic text:</label>
                <textarea class="form-control" rows="10" id="topic_text" name="topic_text" required><?=$topic_text?></textarea>
                <p class="text_erors">
                    <?php
                    foreach ($text_errors as $err) { ?>
                        <?=$err?><br>
                        <?php
                    }
                    ?>
                </p>
            </div>
            <div class="dropdown mb-3 ml-0">
                <select name="category" id="category" class="btn-block btn-dark select_item">
                    <option value="" disabled selected>Unchanged category</option>
                    <option value="0">Computers</option>
                    <option value="1">Games</option>
                    <option value="2">Science</option>
                    <option value="3">Movies</option>
                    <option value="4">Music</option>
                    <option value="5">Other</option>
                </select>
                <p class="text_erors">
                    <?php
                    foreach ($category_errors as $err) { ?>
                        <?=$err?><br>
                        <?php
                    }
                    ?>
                </p>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <button type="submit" name="edit" value="1"
                            class="mb-3 btn btn-block btn-lg btn-dark btn-outline-light">
                        Save
                    </button>
                </div>
                <div class="col-md-6">
                    <button type="submit" name="edit" value="0"
                            class="mb-3 btn btn-block btn-lg btn-dark btn-outline-light">
                        Cancel
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

