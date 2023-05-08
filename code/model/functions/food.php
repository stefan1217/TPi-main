<?php
/**
 * Auteur:Stefan Nikolic
 * Page contenat les functions pour l'utilisateur
 * Date de réalisation : 27.04.2023 - 17.05.2023
 * Temps à disposition : 88 heures
 * Version : 1.0.0
 */
require_once __DIR__ . '/../myDB.php';

function GetAllFood(){
    $sql = "SELECT category,name,picture_path from item";
    $param = [];
    $statement = dbRun($sql, $param);
    return $statement->fetchAll(PDO::FETCH_ASSOC);
}

function CreateGame($date_start,$score,$slice_count,$duration,$idUser,$status,$category){
    $sql = "INSERT INTO `game` (`date_start`,`date_last_update`,`score`,`slice_count`,`duration`,`idUser`,`status`,`category`) value (:date_start,:date_last_update,:score,:slice_count,:duration,:idUser,:status,:category)";
    $param = [
        'date_start' => $date_start,
        'date_last_update' => $date_start,
        'score' => $score,
        'slice_count' => $slice_count,
        'duration' => $duration,
        'idUser' => $idUser,
        'status' => $status,
        'category' => $category,
    ];
    dbRun($sql, $param);
}

function UpdateGame($date_start,$score,$slice_count,$duration,$idUser){
    $sql = "UPDATE `game` SET `date_last_update` = NOW(),`score`=:score,`slice_count` = :slice_count,`duration` = :duration WHERE idUser = :idUser AND date_start = :date_start"; 
    $param = [
        'score' => $score,
        'slice_count' => $slice_count,
        'duration' => $duration,
        'idUser' => $idUser,
        'date_start' => $date_start,
    ];
    dbRun($sql, $param); 
}

function GetOnGoingGames(){
    $sql = "SELECT game.idGame,game.category,game.date_start,game.date_last_update,game.score,game.slice_count,game.duration,user.nickname FROM game INNER JOIN user ON game.idUser = user.idUser where game.status = true";
    $param = [];
    $statement = dbRun($sql, $param);
    return $statement->fetchAll(PDO::FETCH_ASSOC);
}

function isUserInGame($idUser){
    $sql = "SELECT COUNT(idUser) from game where idUser = :idUser and status = true";
    $param = [
        'idUser' => $idUser,
    ];
    $statement = dbRun($sql, $param);
    return $statement->fetchAll(PDO::FETCH_ASSOC);
}

function JoinGame($idGame,$date_start,$date_last_update,$score,$slice_count,$duration,$idUser,$status,$category){
    if(isUserInGame($idUser) == 0){
    $sql = "INSERT INTO `game` (`idGame`,`date_start`,`date_last_update`,`score`,`slice_count`,`duration`,`idUser`,`status`,`category`) value (:idGame,:date_start,:date_last_update,:score,:slice_count,:duration,:idUser,:status,:category)";
    $param = [
        'idGame' => $idGame,
        'date_start' => $date_start,
        'date_last_update' => $date_last_update, 
        'score' => $score,
        'slice_count' => $slice_count,
        'duration' => $duration,
        'idUser' => $idUser,
        'status' => $status,
        'category' => $category,
    ];
    dbRun($sql, $param);
}
}