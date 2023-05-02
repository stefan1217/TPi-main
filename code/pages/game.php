<?php
require_once('../model/functions/user.php');
/**
 * Auteur:Stefan Nikolic
 * Page du jeu
 * Date de réalisation : 27.04.2023 - 17.05.2023
 * Temps à disposition : 88 heures
 * Version : 1.0.0
 */
if (!isset($_SESSION['nickname'])) {
    header("Location: ./login.php");
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/main.css">
    <title>Jeu</title>
</head>

<body class="game-background">
    <p class="text">Pseudo :<?= $_SESSION['nickname'] ?></p>
    <p class="text">Score : </p>
    <canvas id="canvas"></canvas>
    <script src="../js/script.js"></script>
</body>

</html>