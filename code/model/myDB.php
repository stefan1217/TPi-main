<?php
require_once("conf.php");

/**
 * function qui se connecte à la base de donnée
 *
 * @param string sql
 * @param string param
 * @return object
 */
function db(){
    static $myDb = null;
    if($myDb == null){
        $myDb = new PDO(
            "mysql:host=". DB_HOST . ";dbname=". DB_NAME . ";charset=utf8",DB_USER, DB_PASSWORD
        );
        $myDb->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $myDb->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    }
    return $myDb;
}

/**
 * function qui éxecute une requête sql
 *
 * @param string sql
 * @param string param
 * @return object
 */
function dbRun($sql, $param = null) 
    {
        $statement = db()->prepare($sql);

        $statement->execute($param);

        return $statement;
    }
