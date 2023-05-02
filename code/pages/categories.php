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
        <a href="game.php?categorie=Fruit" class="link"><button class="btn">Fruit</button></a>
        <a href="game.php?categorie=Légumes" class="link"><button class="btn">Légumes</button></a>
        <a href="game.php?categorie=Légumineuses" class="link"><button class="btn">Légumineuses</button></a>
        <a href="game.php?categorie=Céréales" class="link"><button class="btn">Céréales</button></a>
        <a href="game.php?categorie=Féculent" class="link"><button class="btn">Féculent</button></a>   
    </section>
</body>
</html>