<?php
require_once(__DIR__.'/user.php');

$nickname = filter_input(INPUT_POST, "nickname", FILTER_UNSAFE_RAW);
$password = filter_input(INPUT_POST, "password", FILTER_UNSAFE_RAW);
$btn = filter_input(INPUT_POST, "btn");
if($btn !=null){
    if($nickname!=null && $password !=null)
    {
    if(LoginUser($nickname,$password)){
        header("Location: ../../public/index.php");
    }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
<form method="post" action="">
    <label for="nickname">Pseudo :</label>
    <input type="text" name="nickname" placeholder="pseudo du joueur" required>
    <label for="pssword">Mot de passe:</label>
    <input type="password" name="password" placeholder="mot de passe" required>
    <input type="submit" value="valider" name="btn">
    </form>
</body>
</html>