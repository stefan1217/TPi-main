<?php

/**
 * Description : Page qui contient tout le code php de la page game
 */
$date = date('Y-m-d H:i:s');

// Vérifie si l'utilisateur est connecté
if (!isset($_SESSION['nickname'])) {
    header("Location: ./login.php");
    die();
}

// On vérifie si la variable de session existe
if (!isset($_GET["category"])) {
    // Rédirection
    header("Location:./categories.php");
    die();
} else {
    if (!isset($_GET["date_last_update"]) && !isset($_GET["date_start"]) && !isset($_GET["idGame"])) {
        if (isUserInGame($_SESSION["idUtilisateur"]) == 0) {
            // On vérifie si l'utilisateur arrive dupuis la page categories
            if (isset($_GET["startGame"])) {
                unset($_GET["startGame"]);
                // Création d'une nouvelle partie
                CreateGame($date, 0, 0, 0, $_SESSION['idUtilisateur'], true, $_GET["category"], $_SESSION['idUtilisateur']);
            }
        }
    } else {
        if (isset($_GET["startGame"])) {
            unset($_GET["startGame"]);
            // On vérifie si le joueur arrive de la page games
            if (JoinGame(
                $_GET["date_start"],
                $_GET["date_last_update"],
                $_GET['score'],
                $_GET['slice_count'],
                $_GET["duration"],
                $_SESSION['idUtilisateur'],
                true,
                $_GET["category"],
                $_GET['parentUserId']
            ) != null) {
                // Si la fonction retourne quelque chose on stocke le message d'erreur dans la variable $message
                $message = JoinGame(
                    $_GET["date_start"],
                    $_GET["date_last_update"],
                    $_GET['score'],
                    $_GET['slice_count'],
                    $_GET["duration"],
                    $_SESSION['idUtilisateur'],
                    true,
                    $_GET["category"],
                    $_GET['parentUserId']
                );
                // Redirection vers la page games.php avec le message d'erreur
                header("Location:./games.php?message=$message");
                die();
            }
        }
    }
}
// On vérifie si la rêquete HTTP à été réçu par la page
if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {

    if (isset($_POST['data'])) {

        $receivedData = json_decode($_POST['data']);
        // Si oui on met à jour les données de la partie
        UpdateGame($receivedData[0], $receivedData[1], $_SESSION['idUtilisateur'], $receivedData[2]);
    } else {
        echo "Aucune donnée reçue.";
    }
    exit;
}
