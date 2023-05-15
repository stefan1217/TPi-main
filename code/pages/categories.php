<?php
/**
 * Description: Page des catégories
 */
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
<body class="game-background">
    <section class="container">
        <a href="../pages/account.php" class="link"><p class="title">Pseudo: <?=$_SESSION["nickname"]?></p></a>
        <a href="../index.php" class="link"><button class="account">Retour <<</button></a>
        <a href="game.php?category=fruit&startGame=true&parentUserId=<?= $_SESSION["idUtilisateur"]?>&idUser=<?=$_SESSION["idUtilisateur"]?>" class="link"><button class="btn">Fruit</button></a>
        <a href="game.php?category=légume&startGame=true&parentUserId=<?= $_SESSION["idUtilisateur"]?>&idUser=<?=$_SESSION["idUtilisateur"]?>" class="link"><button class="btn">Légume</button></a>
        <a href="game.php?category=légumineuse&startGame=true&parentUserId=<?= $_SESSION["idUtilisateur"]?>&idUser=<?=$_SESSION["idUtilisateur"]?>" class="link"><button class="btn">Légumineuse</button></a>
        <a href="game.php?category=céréale&startGame=true&parentUserId=<?= $_SESSION["idUtilisateur"]?>&idUser=<?=$_SESSION["idUtilisateur"]?>" class="link"><button class="btn">Céréale</button></a>
        <a href="game.php?category=féculent&startGame=true&parentUserId=<?= $_SESSION["idUtilisateur"]?>&idUser=<?=$_SESSION["idUtilisateur"]?>" class="link"><button class="btn">Féculent</button></a>   
    </section>
  
</body>
</html>