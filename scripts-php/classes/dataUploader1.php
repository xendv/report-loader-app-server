<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of dataUpoader
 *
 * @author xendv
 */


class dataUploader {
    public $colDelimiter='|';
    public $rowDelimiter='\n';
    public function getDataFromFile($file_path, $col_delimiter = '|', $row_delimiter = '\n',  $file_encodings = ['cp1251','UTF-8']){
        //checking file existence
        if( ! file_exists($file_path) )
            return false;
        
        $file_content = trim( file_get_contents( $file_path ) );
        $encoded_cont = mb_convert_encoding( $file_content, 'UTF-8', mb_detect_encoding($file_content, $file_encodings) );
        
        unset( $file_content );
        
        $lines = explode( $row_delimiter, trim($encoded_cont) );
	$lines = array_filter( $lines );
	$lines = array_map( 'trim', $lines );
        
        $data = [];
	foreach( $lines as $key => $line ){
		$data[] = str_getcsv( $line, $col_delimiter ); // linedata
		unset( $lines[$key] );
	}

	return $data;
    }
    public function connect()
    {
        $dataBaseManager = new dataBaseManager;
        if ($dataBaseManager->connectToDb()){
            alert("Connected");
        }
        else alert("Error in connection");
    }
    
    
}
