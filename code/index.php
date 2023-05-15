<?php
/**
 * Description: Page principale
 */
require_once(__DIR__ . '/model/functions/user.php');

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

<body class="game-background" onload="GetAllFood()">
    <section class="container">
    <p class="title">Pseudo: <?= $_SESSION["nickname"] ?></p>
        <a href="./pages/account.php" class="link">
            <button class="account">Mon compte</button>
        </a>
        <a href="./pages/categories.php" class="link"><button class="btn">Jouer</button></a>
        <a href="./pages/games.php" class="link"><button class="btn">Rejoindre une partie</button></a>
        <a href="./pages/rules.php" class="link"><button class="btn">Règles</button></a>
        <a href="./index.php?logout" class="link"><button class="btn">Déconnexion</button></a>
    </section>
    <script src="./js/getFoods.js"></script> 
</body>
</html>