<?php

require_once('../model/functions/food.php');

switch($_SERVER['REQUEST_METHOD']){
    case 'GET' :
    methodGET();
    break;
    }

//On stocke tous les positions récuperer de la bd dans un format json 
function methodGET(){
    $foods =  GetAllFood();
    echo json_encode([
         'foods' => $foods
         ],JSON_UNESCAPED_UNICODE);
        }