<?php
session_start();

require_once __DIR__ . '/../myDB.php';
// La date est mise à l'heure de Zurich
date_default_timezone_set('Europe/Zurich');


/**
 * fonction qui permet la connexion d'un utilisateur
 *
 * @param string $nickname (pseudo du joueur)
 * @param string $pwd (mot de passe du joueur)
 * @return bool
 */
function LoginUser($nickname, $pwd)
{
    $conn = db();
    // Vérification de l'email
    $query = $conn->prepare("SELECT * FROM user WHERE `nickname` = :nickname;");
    $query->bindParam(":nickname", $nickname, PDO::PARAM_STR);
    $query->execute();
    $result = $query->fetch(PDO::FETCH_ASSOC);
    if ($result !== null && $result != "" && $result !== false) {
        // Vérification du mot de passe
        if (password_verify($pwd, $result["password"])) {
            // création des varaibles de session une fois que l'utilisateur est connecté
            $_SESSION['idUtilisateur'] = $result["idUser"];
            $_SESSION['nickname'] =  $result["nickname"];
            return true;
        }
    }
}

/**
 * fonction qui permet de récupérer un utilisateur selon son nom
 *
 * @param string $nickname (pseudo du joueur)
 * @return array
 */
function selectUserbyNickname($nickname)
{
    $conn = db();
    // Vérification de l'email
    $query = $conn->prepare("SELECT * FROM user WHERE `nickname` = :nickname;");
    $query->bindParam(":nickname", $nickname, PDO::PARAM_STR);
    $query->execute();
    $result = $query->fetch(PDO::FETCH_ASSOC);
    return $result;
}

/**
 * fonction qui permet d'inscrire un utilisateur
 *
 * @param string $nickname (pseudo du joueur)
 * @param string $hash_pass (mot de passe haché du joueur)
 * @param DateTime $registration_date (date d'inscription du joueur)
 * @return void || string
 */
function addUser($nickname, $hash_pass, $registration_date)
{
    $pdo = db();
    if (selectUserbyNickname($nickname) == null) {
        $query = $pdo->prepare("INSERT INTO `user` 
        (`nickname`,`password`,`registration_date`)VALUES(?,?,?)");
        $query->execute([$nickname, password_hash($hash_pass, PASSWORD_DEFAULT), $registration_date]);
    } else {
        return "Pseudo déjà utilisé";
    }
}
/**
 * fonction qui permet la déconnexion d'un utilisateur
 *
 * @return void
 */
function LogOut()
{
    // Supprime toutes les variables de session
    $_SESSION = [];
    // Supprime la session
    session_destroy();
    // Redirige l'utilisateur vers la page home
    header("Location: ./index.php");
    die();
}

/**
 * function qui permet de supprimer un compte utilisateur
 *
 * @param int $idUser (l'id du joueur)
 * @return void
 */
function DeleteUser($idUser)
{
    $sql = "DELETE from user where idUser = :idUser";
    $param = [
        'idUser' => $idUser,
    ];
    dbRun($sql, $param);
    $_SESSION = [];
    // Supprime la session
    session_destroy();
}
