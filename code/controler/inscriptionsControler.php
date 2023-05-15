<?php
/**
 * Description : Page qui contient tout le code php de la page isncriptions
 */

// On filtre les champs nickname et password
$nickname = filter_input(INPUT_POST, "nickname",FILTER_UNSAFE_RAW);
$password = filter_input(INPUT_POST, "password",FILTER_UNSAFE_RAW);
$btn = filter_input(INPUT_POST, "btn");
$message = "";

if (isset($_SESSION["nickname"])) {
    header("Location: ../index.php");
    die();
}
//On vérifie si l'utilisateur a appuyer sur le bouton
if ($btn != null) {
    if ($nickname != null && $password != null) {
        if (addUser($nickname, $password, date('Y-m-d H:i:s')) == null) {
            // Redirection vers la page login avec le message 
            header("Location: login.php?message=Votre compte vien d'étre crée");
            die();
        } else {
            // On stocke le message d'erreur
            $message = addUser($nickname, $password, date('Y-m-d H:i:s'));
        }
    } else {
        // On stocke le message d'erreur si un ou les deux champs sont vides
        $message = "Veuillez remplir tous les champs";
    }
}
