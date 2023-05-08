<?php
require_once(__DIR__ . '/model/functions/user.php');
/**
 * Auteur:Stefan Nikolic
 * Page home
 * Date de réalisation : 27.04.2023 - 17.05.2023
 * Temps à disposition : 88 heures
 * Version : 1.0.0
 */
if (!isset($_SESSION['nickname'])) {
    header("Location: pages/login.php");
}
if (isset($_GET["logout"])) {
    logOut();
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/main.css">
    <title>Home</title>
</head>

<body class="game-background">
    <section class="container">
        <a href="./pages/account.php" class="link">
            <p class="title">Pseudo: <?= $_SESSION["nickname"] ?></p>
        </a>
        <a href="./pages/categories.php" class="link"><button class="btn">Joueur</button></a>
        <a href="./pages/games.php" class="link"><button class="btn">Rejoindre une partie</button></a>
        <a href="" class="link"><button class="btn">Règles</button></a>
        <a href="./index.php?logout" class="link"><button class="btn">Deconexion</button></a>
    </section>
</body>

</html>