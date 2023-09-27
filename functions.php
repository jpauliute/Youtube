<?php

function hasKeys($requiredKeys, $post)
{
    $postKeys = array_keys($post);
    $intersect = array_intersect($requiredKeys, $postKeys);

    $postKeysC = count($postKeys);

    if ($postKeysC === count($intersect) and $postKeysC === count($requiredKeys)) {
        return true;
    }

    return false;
}

function userExists($nick)
{
    return S::fetchColumn('id', 'users', 'nick=:nick', [':nick' => $nick]);
}

function randomString($length)
{
    $letters = 'abcdefghiyjklmnopqrstuvwxzABCDEFGHIYJKLMNOPQRSTUVWXZ0123456789';
    return substr(str_shuffle($letters), 0, $length);
}

function getSalt($by, $value)
{
    return S::fetchColumn('salt', 'users', $by . '=:value', [
        ':value' => $value
    ]);
}

function isLoggedIn()
{
    if (!isset($_SESSION['nick']) or !isset($_SESSION['pass'])) {
        return false;
    }

    return S::fetchColumn('id', 'users', 'nick=:nick AND pass=:pass', [
        ':nick' => $_SESSION['nick'],
        ':pass' => $_SESSION['pass']
    ]);
}

function getData()
{
    return S::fetch('*', 'users', 'nick=:nick AND pass=:pass', [
        ':nick' => $_SESSION['nick'],
        ':pass' => $_SESSION['pass']
    ]);
}

function getAllCategories()
{
    return S::fetchAll('SELECT * FROM categories', []);
}

function validatePostResult($err, $success)
{
    if (!empty($err)) {
        return '
        <div class="alert alert-danger" role="alert">
            ' . $err . '
        </div>
        ';
    }

    if (!empty($success)) {
        echo '
        <div class="alert alert-success" role="success">
            ' . $success . '
        </div>
        ';
    }
}

function userCheck($action)
{
    if (($action === 'isUser' and isUser) or ($action === 'isNotUser' and !isUser)) {
        header("Location: ?pg=");
        exit;
    }
}

function isValidRequestMethod($requestMethod)
{
    return $requestMethod === 'POST';
}

function isValidPost($keys)
{
    return isValidRequestMethod($_SERVER['REQUEST_METHOD']) and hasKeys($keys, $_POST);
}

function showVideo($video)
{
    echo "<div class='col mb-4'>
        <a href='?pg=video&vid=" . $video['vid'] . "'>
            <img src='https://i3.ytimg.com/vi/" . $video['vid'] . "/maxresdefault.jpg' alt='video'>
            <h5 class='mt-2 text-dark'>" . $video['name'] . "</h5>
            <sup>".getUserNickById($video['uid'])."</sup>
            <sup class='text-muted'> " . $video['views'] . " views</sup>
        </a>
    </div>";
}

function getUserNickById($id) {
    return S::fetchColumn('nick', 'users', 'id=:id', [':id' => $id]);
}

?>