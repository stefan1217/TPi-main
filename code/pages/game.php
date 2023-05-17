<?php
/**
 * Description: Page du jeu
 */
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
    <title>Game</title>
</head>
<body class="game-background">
    <div id="informations"> 
    <p  id="nickaname" class="text">Joueurs : <?= $_SESSION['nickname']; ?></p>
    <p class="text" id="speed">Vitesse :</p>
    <p class="text" id="time">Temps :</p>
    </div>
    <canvas id="canvas" ></canvas>
    <div id="result"></div>
    <div id="game-over-menu">
    <h1>Vous avez perdu!</h1>
    <p id="duration"></p>
    <p id="winner"></p>
    <button id="game-over-menu-button" class="btn-game-over">Retour</button>
    </div> 
    <script src="../js/game.js" type="module"></script>
    <script src="../js/sendDataToPhp.js" type="module"></script>
    <script src="../js/addBadFood.js" type="module" ></script>
    <script src="../js/updateUsers.js" type="module"></script>
</body>
</html>