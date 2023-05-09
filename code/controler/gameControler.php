<?php
date_default_timezone_set('Europe/Zurich');
$date = date('Y-m-d H:i:s');
if (!isset($_SESSION['nickname'])) {
    header("Location: ./login.php");
    die();
}
if (!isset($_GET["category"])) {
    header("Location:./categories.php");
    die();
} else {
    if (!isset($_GET["date_last_update"]) && !isset($_GET["date_start"]) && !isset($_GET["idGame"])) {
        if(isUserInGame($_SESSION["idUtilisateur"])== 0){
        CreateGame(date('Y-m-d H:i:s'),0,0,0,$_SESSION['idUtilisateur'],true,$_GET["category"],$_SESSION['idUtilisateur']);
        }
    } else {
        if (JoinGame($_GET["date_start"], $_GET["date_last_update"], $_GET['score'], $_GET['slice_count'], $_GET["duration"], $_SESSION['idUtilisateur'], true, $_GET["category"],$_GET['parentIdUser']) != null) {
            header("Location:./games.php?message='Vous avez déjà rejoint cette partie'");
            die();
        }
    }
}
if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {

    if (isset($_POST['data'])) {
        $receivedData = json_decode($_POST['data']);
        UpdateGame($date,$receivedData[0],$receivedData[1],$receivedData[2],$_SESSION['idUtilisateur'],$receivedData[3]);
    } 
   
}
