<?php

/**
 * Description : Page qui contient tout le code php de la page login
 */

// On filtre les champs nickname et password
$nickname = filter_input(INPUT_POST, "nickname", FILTER_UNSAFE_RAW);
$password = filter_input(INPUT_POST, "password", FILTER_UNSAFE_RAW);
$btn = filter_input(INPUT_POST, "btn");
$message = "";
// Vérifie si l'utilisateur est connecté
if (isset($_SESSION["nickname"])) {
    header("Location: ../index.php");
    die();
}
if (isset($_GET["message"])) {
    $message = $_GET["message"];
}
if ($btn != null) {
    if ($nickname != null && $password != null) {
        if (LoginUser($nickname, $password)) {
            // Redirection vers la page index.php si la connection a fonctionné
            header("Location: ../index.php");
        } else {
            // On stocke le message d'erreur si un ou des champs sont incorrectes
            $message = "Un ou des champs sont incorrect";
        }
    } else {
        // On stocke le message d'erreur si un ou les deux champs sont vides
        $message = "Veuillez remplir tous les champs";
    }
}
