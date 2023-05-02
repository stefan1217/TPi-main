<?php

/**
 * Auteur:Stefan Nikolic
 * Page contenat tout le code php de la page inscription
 * Date de réalisation : 
 * Temps à disposition : 88 heures
 * Version : 1.0.0
 */
$nickname = filter_input(INPUT_POST, "nickname");
$password = filter_input(INPUT_POST, "password", FILTER_UNSAFE_RAW);
$message = "";
$btn = filter_input(INPUT_POST, "btn");

if (isset($_SESSION["nickname"])) {
    header("Location: ../index.php");
    die();
}
if ($btn != null) {
    if ($nickname != null && $password != null) {
        if (addUser($nickname, $password, date('Y-m-d H:i:s')) == null) {
            header("Location: login.php");
            die();
        } else {
            $message = addUser($nickname, $password, date('Y-m-d H:i:s'));
        }
    } else {
        $message = "Veuillez remplir tous les champs";
    }
}
