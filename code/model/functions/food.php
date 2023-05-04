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

function CreateGame($date_start,$score,$slice_count,$duration,$idUser){
    $sql = "INSERT INTO `game` (`date_start`,`date_last_update`,`score`,`slice_count`,`duration`,`idUser`) value (:date_start,:date_last_update,:score,:slice_count,:duration,:idUser)";
    $param = [
        'date_start' => $date_start,
        'date_last_update' => $date_start,
        'score' => $score,
        'slice_count' => $slice_count,
        'duration' => $duration,
        'idUser' => $idUser,
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