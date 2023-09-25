<?php
require_once('related/sql.php');
require_once('functionality/functions.php');

$pepper = "Ec9xKCX8";

$s = isset($_GET['s']) ? htmlentities($_GET['s']) : '';
$page = (isset($_GET['page']) AND !empty($_GET['page'])) ? (int) $_GET['page'] : 1;

define("isUser", isLoggedIn());
?>