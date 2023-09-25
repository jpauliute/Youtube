<?php
session_start();

require_once('pdo.php');
require_once('config.php');
require_once('related/sql.php');
require_once('functionality/functions.php');

if (isUser) {
    $data = getData();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Youtube</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Serif:opsz@8..144&display=swap" rel="stylesheet">
</head>

<body>
    <main>

        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container">
            <a class = 'navbar-brand text-danger' href = '?pg='><img style="width:40%" src = 'download.png' alt = ''></a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup"
                    aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse d-flex justify-content-end" id="navbarNavAltMarkup">
                    <div class="navbar-nav d-flex mx-3">
                        <form method="GET" class="form-inline my-2 my-lg-0 d-flex">
                            <input class="form-control mr-sm-2" 
                            name="s" 
                            type="search" 
                            placeholder=""
                            value="<?= $s ?>"
                                aria-label="Search">
                            <button class="btn btn-outline-danger mx-2 my-sm-0" type="submit">Search</button>
                        </form>
                    </div>
                    <div class="navbar-nav">
                        <a class="nav-item nav-link" href="?pg=">Home</a>
                        <?php if (!isUser): ?>
                            <a class="nav-item nav-link" href="?pg=login">Sign-in</a>
                            <a class="nav-item nav-link" href="?pg=registration">Become a member</a>
                        <?php endif; ?>
                        <?php if (isUser): ?>
                            <a class="nav-item nav-link" href="?pg=addVideo">Add video</a>
                            <a class="nav-item nav-link disabled" href="javascript:void(0)">
                                <?php echo $data['nick'] ?>
                            </a>
                            <a class="nav-item nav-link" href="?pg=logout">Log out</a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </nav>

        <div class="container">
            <?php

            $pg = isset($_GET['pg']) ? $_GET['pg'] : '';

            switch ($pg) {
                case '':
                    include './views/home.php';
                    break;
                case 'registration':
                    include './views/registration.php';
                    break;
                case 'login':
                    include './views/login.php';
                    break;
                case 'addVideo':
                    include './views/addVideo.php';
                    break;
                case 'logout':
                    session_destroy();
                    header('Location: ?pg=');
                    break;
                case 'video':
                    include './views/video.php';
                    break;
            }

            ?>
        </div>
    </main>
</body>

</html>