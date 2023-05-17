<?php

/**
 * Description : Page de connection à la base de donné 
 */

require_once("conf.php");
/**
 * fonction qui se connecte à la base de données
 *
 * @param string sql
 * @param string param
 * @return object
 */
function db()
{
    try {
        static $myDb = null;
        if ($myDb == null) {
            $myDb = new PDO(
                "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8",
                DB_USER,
                DB_PASSWORD
            );
            $myDb->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $myDb->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        }
        return $myDb;
    } catch (Exception $e) {
        die("services  momentanément indisponible. Merci de réessayer plus tard");
    }
}

/**
 * fonction qui exécute une requête SQL
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




