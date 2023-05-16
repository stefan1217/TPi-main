<?php
require_once __DIR__ . '/../myDB.php';
/**
 * fonction qui permet de récupere la liste des aliments
 * 
 * @return array 
 */
function GetAllFood(){
    $sql = "SELECT category,name,picture_path from item";
    $param = [];
    $statement = dbRun($sql, $param);
    return $statement->fetchAll(PDO::FETCH_ASSOC);
}
/**
 * fonction qui permet de créer une nouvelle partie
 *
 * @param DateTime $date_start
 * @param int $score
 * @param int $slice_count
 * @param int $duration
 * @param int $idUser
 * @param bool $status
 * @param string $category
 * @param int $parentIdUser
 * @return void
 */
function CreateGame($date_start,$score,$slice_count,$duration,$idUser,$status,$category,$parentIdUser){
    $sql = "INSERT INTO `game` (`date_start`,`date_last_update`,`score`,`slice_count`,`duration`,`idUser`,`status`,`category`,`parentIdUser`) value 
    (:date_start,:date_last_update,:score,:slice_count,:duration,:idUser,:status,:category,:parentIdUser)";
    $param = [
        'date_start' => $date_start,
        'date_last_update' => $date_start,
        'score' => $score,
        'slice_count' => $slice_count,
        'duration' => $duration,
        'idUser' => $idUser,
        'status' => $status,
        'category' => $category,
        'parentIdUser' => $parentIdUser,
    ];
    dbRun($sql, $param);
}

/**
 * fonction qui permet de mettre à jour les informations d'une partie déjà en cours 
 *
 * @param int $score
 * @param int $slice_count
 * @param int $idUser
 * @param bool $status
 * @return void
 */
function UpdateGame($score,$slice_count,$idUser,$status){
    $sql = "UPDATE `game` SET `date_last_update` = NOW(),`score`=:score,`slice_count` = :slice_count,`duration` = TIMEDIFF(date_last_update, date_start),`status` = :status 
    WHERE idUser = :idUser AND status = true"; 
    $param = [
        'score' => $score,
        'slice_count' => $slice_count,
        'status' => $status,
        'idUser' => $idUser,
    ];
    dbRun($sql, $param); 
}

/**
 * fonction qui permet de récupérer toutes les parties en cours
 * 
 * @param $idUser
 * @return array
 */
function GetOnGoingGames($idUser){

    $sql = "SELECT game.idGame,game.category,game.date_start,game.date_last_update,game.score,game.slice_count,game.duration,game.parentIdUser,user.nickname FROM game 
    INNER JOIN user ON game.idUser = user.idUser where game.status = true and game.parentIdUser != :parentIdUser and game.idUser != :idUser";
    $param = [
        'parentIdUser' => $idUser,
        'idUser' => $idUser,
    ];
    $statement = dbRun($sql, $param);
    return $statement->fetchAll(PDO::FETCH_ASSOC);
}
/**
 * fonction qui permet de vérifier si un joueur n'est pas déjà dans une partie en cours
 *
 * @param int $idUser
 * @return boolean
 */
function isUserInGame($idUser){
    $sql = "SELECT COUNT(idUser) from game where idUser = :idUser and status = true and parentIdUser=:parentIdUser";
    $param = [
        'idUser' => $idUser,
        'parentIdUser' => $idUser,
    ];
    $statement = dbRun($sql, $param)->fetch(PDO::FETCH_ASSOC);
    return $statement["COUNT(idUser)"];
}

/**
 * fonction qui récupère le nombre de joueurs présant dans une partie
 * 
 * @param $parentIdUser
 * @param $date_start
 * @return int
 */
function nbPlayersInGame($parentIdUser,$date_start){
    $sql = "SELECT COUNT(parentIdUser) from game where parentIdUser = :parentIdUser and status = true and date_start = :date_start";
    $param = [
        'parentIdUser' => $parentIdUser,
        'date_start' => $date_start,
    ];
    $statement = dbRun($sql, $param)->fetch(PDO::FETCH_ASSOC);
    return $statement["COUNT(parentIdUser)"];
}

/**
 * fonction qui permet de créer une nouvelle partie pour un joueur qui veut rejoindre une partie déjà en cours
 *
 * @param DateTime $date_start
 * @param DateTime $date_last_update
 * @param int $score
 * @param int $slice_count
 * @param int $duration
 * @param int $idUser
 * @param string $status
 * @param string $category
 * @return void || string
 */
function JoinGame($date_start,$date_last_update,$score,$slice_count,$duration,$idUser,$status,$category,$parentIdUser){
    if(nbPlayersInGame($parentIdUser,$date_start)!=2){
    if(isUserInGame($idUser) < 2){
    $sql = "INSERT INTO `game` (`date_start`,`date_last_update`,`score`,`slice_count`,`duration`,`idUser`,`status`,`category`,`parentIdUser`) 
    value (:date_start,:date_last_update,:score,:slice_count,:duration,:idUser,:status,:category,:parentIdUser)";
    $param = [
        'date_start' => $date_start,
        'date_last_update' => $date_last_update, 
        'score' => $score,
        'slice_count' => $slice_count,
        'duration' => $duration,
        'idUser' => $idUser,
        'status' => $status,
        'category' => $category,
        'parentIdUser' => $parentIdUser,
    ];
    dbRun($sql, $param);
}
else {
    return "Vous avez déjà rejoint cette partie!";
}
    }
    else{
        return "La partie est pleine!";
    }
}

/**
 * fonction qui permet de récuperer toutes les infromations des joueurs présant dans une partie et trient les jouers selon leurs scores
 * 
 * @param $parentIdUser
 * @return array
 */
function GetAllUserInformations($parentIdUser){
    $sql = "SELECT game.score,game.idUser,game.slice_count,game.date_start,game.duration,user.nickname 
    from game INNER JOIN user ON game.idUser = user.idUser 
    where game.parentIdUser = :parentIdUser and game.status = true order by game.score asc";
    $param = [
        'parentIdUser' => $parentIdUser,
    ];
    $statement = dbRun($sql, $param)->fetchAll(PDO::FETCH_ASSOC);
    return $statement;
}





