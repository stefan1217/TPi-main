<?php
require_once('../model/functions/user.php');
require_once('../model/functions/food.php');

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
<body class="game-background" onload="methodGet()">
    <section class="container">
        <a href="../pages/account.php" class="link"><p class="title">Pseudo: <?=$_SESSION["nickname"]?></p></a>
        <a href="../index.php" class="link"><button class="btn">Retour <<</button></a>
        <a href="game.php?category=fruit&parentUserId=<?= $_SESSION["idUtilisateur"]?>" class="link"><button class="btn">Fruit</button></a>
        <a href="game.php?category=légume" class="link"><button class="btn">Légume</button></a>
        <a href="game.php?category=légumineuse" class="link"><button class="btn">Légumineuse</button></a>
        <a href="game.php?category=céréale" class="link"><button class="btn">Céréale</button></a>
        <a href="game.php?category=féculent" class="link"><button class="btn">Féculent</button></a>   
    </section>
    <script src="../js/functionsFood.js" ></script> 
</body>
</html>