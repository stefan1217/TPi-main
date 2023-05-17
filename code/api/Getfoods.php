<?php
require_once('../model/functions/food.php');

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        methodGET();
        break;   
}
/**
 * fonction qui récupère tous les aliments et les  encode en JSON 
 *
 * @return json // liste d'aliments en format JSON
 */
function methodGET()
{
    $foods =  GetAllFood();  
        echo json_encode([
            'foods' => $foods,
        ], JSON_UNESCAPED_UNICODE);
}


