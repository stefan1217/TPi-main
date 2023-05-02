<?php
require_once('../model/functions/user.php');
/**
 * Auteur:Stefan Nikolic
 * Page du compte utilisateur
 * Date de réalisation : 27.04.2023 - 17.05.2023
 * Temps à disposition : 88 heures
 * Version : 1.0.0
 */
if (!isset($_SESSION['nickname'])) {
    header("Location: ./login.php");
}
if (isset($_GET["delete"])) {
    DeleteUser($_SESSION["idUtilisateur"]);
    header("Location: ./login.php");
    die();
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/main.css">
    <title>Compte</title>
</head>

<body class="game-background">
    <section class="container">
        <p class="title">Psudo: <?= $_SESSION["nickname"] ?></p>
        <button class="btn" onclick="DeleteUserYesOrNo()">Suprimer mon compte</button>
    </section>

    <script src="../js/user.js"></script>
</body>

</html>