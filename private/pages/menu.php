<?php
require_once(__DIR__.'/user.php');
/**
 * Auteur:Stefan Nikolic
 * Page home
 * Date de réalisation : 
 * Temps à disposition : 88 heures
 * Version : 1.0.0
 */
if(!isset($_SESSION['nickname'])){
    header("Location:login.php");
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../public/css/main.css">
    <title>Home</title>
</head>
<body>
    <section class="container">
        <p class="title">Pesudo</p>
        <a href="jeu.php"><button class="btn">Joueur</button></a>
        <a href=""><button class="btn">Règles</button></a>
        <a href=""><button class="btn">Classement</button></a>
        <a href="./logout.php"><button class="btn">Deconexion</button></a>   
    </section>
</body>
</html>