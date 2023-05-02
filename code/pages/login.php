<?php

/**
 * Auteur:Stefan Nikolic
 * Page login 
 * Date de réalisation : 27.04.2023 - 17.05.2023
 * Temps à disposition : 88 heures
 * Version : 1.0.0
 */
require_once('../model/functions/user.php');
require_once('../controller/loginController.php');
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/main.css">
    <title>Login</title>
</head>

<body>
    <h1>Connexion</h1>
    <form method="post" action="">
        <p>Pseudo : </p>
        <input type="text" name="nickname" placeholder="pseudo du joueur" required>
        <p>Mot de passe:</p>
        <input type="password" name="password" placeholder="mot de passe" required>
        <input type="submit" value="valider" name="btn">
        <a href="./inscriptions.php">
            <p>Je n'ai pas de compte</p>
        </a>
        <p class="message"><?= $message ?></p>
    </form>
</body>

</html>