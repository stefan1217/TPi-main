<?php
require_once('../model/functions/user.php');
require_once('../model/functions/food.php');
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
if (!isset($_GET["categorie"])) {
    header("Location:./categories.php");
}
else{
CreateGame(date('Y-m-d H:i:s'),0,0,0,$_SESSION['idUtilisateur']);

}
$date = date('Y-m-d H:i:s');
if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {

    if (isset($_POST['data'])) {
        $receivedData = json_decode($_POST['data']);
        UpdateGame($date,$receivedData[0],$receivedData[1],$receivedData[2],$_SESSION['idUtilisateur']);
    } else {
        echo "Aucune donnée reçue.";       
    }
    exit;
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
<body class="game-background" onload='methodGet()'>
    <div id="informations">
    <p class="text">Pseudo :<?= $_SESSION['nickname'] ?></p>
    <p class="text"  id="score">Score : </p>
    <p class="text" >Temps :</p>
    <canvas id="canvas"></canvas>
    <div id="result"></div>
    </div>
   
    <script src="../js/script.js"></script>
    <script src="../js/functionsFood.js"></script>
</body>

</html>