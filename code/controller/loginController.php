<?php
$nickname = filter_input(INPUT_POST, "nickname", FILTER_UNSAFE_RAW);
$password = filter_input(INPUT_POST, "password", FILTER_UNSAFE_RAW);
$btn = filter_input(INPUT_POST, "btn");
$message = "";

if (isset($_SESSION["nickname"])) {
    header("Location: ../index.php");
    die();
}
if ($btn != null) {
    if ($nickname != null && $password != null) {
        if (LoginUser($nickname, $password)) {
            header("Location: ../index.php");
        } else {
            $message = "Un des champs est incorrect";
        }
    } else {
        $message = "Veuillez remplir tous les champs";
    }
}
