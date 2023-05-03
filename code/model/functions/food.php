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