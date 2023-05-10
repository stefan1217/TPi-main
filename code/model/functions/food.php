<?php
require_once __DIR__ . '/../myDB.php';
/**
 * function qui permet de récupere toute la liste des aliments
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
 * function qui permet de créer une nouvelle partie
 *
 * @param DateTime $date_start
 * @param int $score
 * @param int $slice_count
 * @param int $duration
 * @param int $idUser
 * @param bool $status
 * @param string $category
 * @return void
 */
function CreateGame($date_start,$score,$slice_count,$duration,$idUser,$status,$category,$parentIdUser){
    $sql = "INSERT INTO `game` (`date_start`,`date_last_update`,`score`,`slice_count`,`duration`,`idUser`,`status`,`category`,`parentIdUser`) value (:date_start,:date_last_update,:score,:slice_count,:duration,:idUser,:status,:category,:parentIdUser)";
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
 * function qui permet de mettre à jour les informations d'une partie déjà en cours 
 *
 * @param DateTIme $date_start
 * @param int $score
 * @param int $slice_count
 * @param int $duration
 * @param int $idUser
 * @return void
 */
function UpdateGame($score,$slice_count,$duration,$idUser,$status){
    $sql = "UPDATE `game` SET `date_last_update` = NOW(),`score`=:score,`slice_count` = :slice_count,`duration` = :duration,`status` = :status WHERE idUser = :idUser AND status = true"; 
    $param = [
        'score' => $score,
        'slice_count' => $slice_count,
        'duration' => $duration,
        'status' => $status,
        'idUser' => $idUser,
    ];
    dbRun($sql, $param); 
}

/**
 * function qui permet de récupérer toutes les parties en cours
 *
 * @return array
 */
function GetOnGoingGames($idUser){
    $sql = "SELECT game.idGame,game.category,game.date_start,game.date_last_update,game.score,game.slice_count,game.duration,game.parentIdUser,user.nickname FROM game INNER JOIN user ON game.idUser = user.idUser where game.status = true and game.parentIdUser != :parentIdUser and game.idUser != :idUser";
    $param = [
        'parentIdUser' => $idUser,
        'idUser' => $idUser,
    ];
    $statement = dbRun($sql, $param);
    return $statement->fetchAll(PDO::FETCH_ASSOC);
}
/**
 * function qui permet de vérifier si un joueur n'est pas déjà dans une partie en cours
 *
 * @param int $idUser
 * @return boolean
 */
function isUserInGame($idUser){
    $sql = "SELECT COUNT(idUser) from game where idUser = :idUser and status = true";
    $param = [
        'idUser' => $idUser,
    ];
    $statement = dbRun($sql, $param)->fetch(PDO::FETCH_ASSOC);
    return $statement["COUNT(idUser)"];
}
/**
 * function qui permet de créer une nouvelle partie pour un joueur qui veut rejoindre une partie en cours
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
    if(isUserInGame($idUser) == 0){
    $sql = "INSERT INTO `game` (`date_start`,`date_last_update`,`score`,`slice_count`,`duration`,`idUser`,`status`,`category`,`parentIdUser`) value (:date_start,:date_last_update,:score,:slice_count,:duration,:idUser,:status,:category,:parentIdUser)";
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

function GetAllUserInformations($parentIdUser){
    $sql = "SELECT game.score,game.slice_count,user.nickname from game INNER JOIN user ON game.idUser = user.idUser where game.parentIdUser = :parentIdUser and game.status = true";
    $param = [
        'parentIdUser' => $parentIdUser,
    ];
    $statement = dbRun($sql, $param)->fetchAll(PDO::FETCH_ASSOC);
    return $statement;
}





