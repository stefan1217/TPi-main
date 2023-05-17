<?php

/**
 * Description: Page des règles
 */
require_once('../model/functions/user.php');
// Vérifie si l'utilisateur est connecté
if (!isset($_SESSION['nickname'])) {
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
    <title>Rules</title>

<body class="game-background">
    <section class="container">
        <a href="../pages/account.php" class="link">
            <p class="title">Pseudo: <?= $_SESSION["nickname"] ?></p>
        </a>
        <a href="../index.php" class="link"><button class="account">Retour <<< </button></a>
        <ul>
            <!--Règles-->
            <li class="description">Slim Ninja est un jeu à but pédagogique qui permet aux joueurs
                d'apprendre les différents groupes d'aliments.
            </li>
            <li class="description">
                Les joueurs peuvent choisir entre 5 modes de jeu (Céréale, Fruit, Légume, Légumineuse, Féculent).
            </li>
            <li class="description">
                Les différents aliments de toutes les catégories tombent aléatoirement sur l'écran de haut vers le bas.
            </li>
            <li class="description">
                Pour gagner des points les joueurs doivent appuyer avec le cursor de la souris sur les bons aliments de la catégorie choisie.
            </li>
            <li class="description">
                Si le joueur n'appuie pas sur le bon aliment de la catégorie avant qu'il attegne le bas de l'écran il perd 2 points.
            </li>
            <li class="description">
                Les joueurs perdent 2 points aussi lorsqu'ils appuient sur les mauvais alimetns (malbouffe).
            </li>
            <li class="description">
                Des aliments malsains apparaissent de tant en temps sur l'écran,
                si le joueur appuie sur l'un de ces aliments le jeu s'arrête immédiatement.
            </li>
            <li class="description">
                Le jeu est aussi arrêté si le score du jouer devient négatif.
            </li>
            <li class="description">
                En mode multijoueur le joueur qui a le score le plus élevé fait à défiler les aliments de l'autre joueur plus vite.
            </li>
            <li class="description">
                Le dernier joueur restant de la partie est le gagnant!
            </li>
        </ul>
        <h2 class="description-h2">
            Voici un schéma qui montre de quel groupe font partie les aliments présant dans le jeu:
        </h2>
        <img class="img-rules" src="../img/groupes-aliments.png" alt="tier-list">
    </section>
</body>

</html>