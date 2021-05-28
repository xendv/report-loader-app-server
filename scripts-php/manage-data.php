<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once(__DIR__.'\load-data.php');
require_once(__DIR__.'\classes\dataUploader.php');

//if ()

switch ($_POST['request']){
    case "get_main_table_data":
        echo <<<EOF
        <thead>
        <tr><th>id</th> <th>ОКПО</th> <th>Название предприятия</th></tr>
        </thead>
        EOF;
        break;
    default :
    break;
}


//$data = $dataUploader->getDataFromFile( 'data.csv' );
//print_r( $data );

