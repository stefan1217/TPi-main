<?php
require_once('../model/functions/user.php');
require_once('../model/functions/food.php');

if (!isset($_SESSION['nickname'])) {
    header("Location: ./login.php");
}
$games = GetOnGoingGames($_SESSION["idUtilisateur"]);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/main.css">
    <title>Home</title>
</head>

<body class="game-background">
    <section class="container">
        <a href="../pages/account.php" class="link">
            <p class="title">Pseudo: <?= $_SESSION["nickname"] ?></p>
        </a>
        <a href="../index.php" class="link"><button class="btn">Retour <<< </button></a>

        <?php foreach ($games as $game) {
        ?>
            <p class="games-text">Hôte: <?php echo $game["nickname"]; ?></p>
            <p class="games-text">Categorie: <?php echo $game["category"]; ?></p>
            <a href="game.php?startGame=true&category=<?= $game["category"] ?>&date_start=<?= $game["date_start"] ?>&date_last_update=<?= $game["date_last_update"] ?>&idGame=<?= $game["idGame"] ?>&score=<?= $game["score"] ?>&slice_count=<?= $game["slice_count"] ?>&duration=<?= $game["duration"] ?>&parentUserId=<?= $game["parentIdUser"] ?>&idUser=<?= $_SESSION["idUtilisateur"] ?>" class="link"><button class="btn">Rejoindre</button></a>
        <?php }
        if (isset($_GET['message'])) {
            echo "<p class='error-text'>" . $_GET['message'] . "</p>";
        }
        ?>
    </section>
</body>
</html>