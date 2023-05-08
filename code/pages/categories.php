<?php
require_once('../model/functions/user.php');
/**
 * Auteur:Stefan Nikolic
 * Page categories
 * Date de réalisation : 27.04.2023 - 17.05.2023
 * Temps à disposition : 88 heures
 * Version : 1.0.0
 */
if(!isset($_SESSION['nickname'])){
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
    <title>Home</title>
</head>
<body class="game-background">
    <section class="container">
        <a href="../pages/account.php" class="link"><p class="title">Psudo: <?=$_SESSION["nickname"]?></p></a>
        <a href="../index.php" class="link"><button class="btn">Retour <<</button></a>
        <a href="game.php?categorie=fruit" class="link"><button class="btn">Fruit</button></a>
        <a href="game.php?categorie=légume" class="link"><button class="btn">Légumes</button></a>
        <a href="game.php?categorie=légumineuse" class="link"><button class="btn">Légumineuses</button></a>
        <a href="game.php?categorie=céréale" class="link"><button class="btn">Céréales</button></a>
        <a href="game.php?categorie=féculent" class="link"><button class="btn">Féculent</button></a>   
    </section>
</body>
</html>