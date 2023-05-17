<?php
/**
 * Description: Page d'inscription
 */
require_once('../model/functions/user.php');
require_once('../controler/inscriptionsControler.php');
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/main.css">
    <title>Inscription</title>
</head>

<body>
    <h1>Inscription:</h1>
    <form method="post" action="">
        <p>Pseudo:</p>
        <input type="text" minlength="3" maxlength="15" name="nickname" placeholder="(15 caractères max)" required>
        <p>Mot de passe:</p>
        <input type="password" minlength="3" name="password" placeholder="mot de passe" required>
        <input type="submit" value="valider" name="btn">
        <a href="./login.php"></p>J'ai déjà un compte</p></a>
        <p class="message"><?= $message; ?></p>
    </form>
</body>

</html>