<?php
require_once('../model/functions/user.php');
require_once('../model/functions/food.php');
require_once('../controler/gameControler.php');

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
<body class="game-background" onload="UpdateUserInformation()">
<div id="informations" > 
    <p  id="nickaname" class="text">Pseudo :<?= $_SESSION['nickname'] ?></p>
    <p class="text"  id="score">Score : </p>
    <p class="text" id="time" >Temps :</p>
    </div>
    <canvas id="canvas" ></canvas>
    <div id="result"></div>
    <div id="game-over-menu">
    <h1>Vous avez perdu!</h1>
     <h2 id="game-over-menu-score">Votre score est de :</h2>
    <button id="game-over-menu-button">Retour</button>
    </div>  
    <script src="../js/script.js" ></script>
    <script src="../js/functionsFood.js" ></script>
</body>
</html>