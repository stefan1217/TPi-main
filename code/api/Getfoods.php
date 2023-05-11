<?php
require_once('../model/functions/food.php');

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        methodGET();
        break;   
}
/**
 * function qui encode en json tous les aliments 
 *
 * @return json
 */
function methodGET()
{
    $foods =  GetAllFood();  
        echo json_encode([
            'foods' => $foods,
        ], JSON_UNESCAPED_UNICODE);
}


