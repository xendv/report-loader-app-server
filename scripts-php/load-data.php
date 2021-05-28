<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once(__DIR__.'\classes\dataBaseManager.php');
require_once(__DIR__.'\classes\dataUploader.php');
//if ()

$dataUploader = new dataUploader;
$dataUploader->connect();

//$data = $dataUploader->getDataFromFile( 'data.csv' );
//print_r( $data );

