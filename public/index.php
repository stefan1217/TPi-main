<?php
require_once(__DIR__.'../../private/pages/user.php');

if(!isset($_SESSION["nickname"])){
    header("Location: ../private/pages/login.php");
    die();
}
else{
    header("Location: ../private/pages/menu.php");
    die();
}
