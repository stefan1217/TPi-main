<?php
require_once('../model/functions/food.php');

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        UpdateUserInformations();
        break;   
}

/**
 * function qui encode en json toutes les donnés des utilisateur presant dans la partie
 *
 * @return json
 */
function UpdateUserInformations(){
    if($id = filter_input(INPUT_GET, 'parentUserId', FILTER_VALIDATE_INT)){
        $users = GetAllUserInformations($id);
        echo json_encode([
             'users' => $users
             ],JSON_UNESCAPED_UNICODE);
        }    
}