<?php
/**
 * Description: Page de l'utilisateur
 */
require_once('../model/functions/user.php');
// Vérifie si l'utilisateur est connecté
if (!isset($_SESSION['nickname'])) {
    header("Location: ./login.php");
}
if (isset($_GET["delete"])) {
    DeleteUser($_SESSION["idUtilisateur"]);
    header("Location: ./login.php");
    die();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/main.css">
    <title>Account</title>
</head>

<body class="game-background">
    <section class="container">
        <p class="title">Pseudo: <?= $_SESSION["nickname"] ?></p>
        <a href="../index.php" class="link"><button class="account">Retour <<< </button></a>
        <button class="btn" onclick="DeleteUserYesOrNo()">Supprimer mon compte</button>
    </section>
    <script src="../js/user.js"></script>
</body>

</html>