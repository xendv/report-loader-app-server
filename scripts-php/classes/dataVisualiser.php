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


class dataVisualiser {
    public $colDelimiter='|';
    public $rowDelimiter='\n';
    public $header=[];

    /*public function getDataFromDB(){
        $dataBaseManager = new dataBaseManager;
        if ($dataBaseManager->connectToDb()){
            alert("Connected");
        }
        else alert("Error in connection");
    }*/

    public function getDataFromCSVFileByPath($file_path, $col_delimiter = '|', $row_delimiter = '\\n',  $file_encodings = ['cp1251','UTF-8']){
        //checking file existence
        if( ! file_exists($file_path) )
            return false;
        else{
            //ini_set("auto_detect_line_endings", true);
            //$file_content = trim( file_get_contents( $file_path ) );
            /*$file_content = trim( file_get_contents( $file_path ) );
            //return $this->getDataFromCSVFile($file_content);

            $encoded_cont = mb_convert_encoding( $file_content, 'UTF-8', mb_detect_encoding($file_content, $file_encodings) );
            //echo($file_content);
            unset( $file_content );
            
            $lines = explode( $row_delimiter, trim($encoded_cont) );
            $lines = array_filter( $lines );
            $lines = array_map( 'trim', $lines );
            //print_r($lines);
            foreach ($lines as $line){
                echo($line.PHP_EOL."----".PHP_EOL);
            }
            
            $data = [];
            foreach( $lines as $key => $line ){
               // echo $key.PHP_EOL;
               
                //if($line==0){
                    
                //}
                //else {
                    $data[] = str_getcsv( $line, $col_delimiter); // linedata
                    unset( $lines[$key] ); 
                //}

            }*/
            //echo "------";
            $rows = array_map(function($v){return str_getcsv($v, "|");}, file($file_path));
            $header = array_shift($rows);
            $this->header=$header;
            //print_r($header);

            $columns_count=count($header);
            $csv = [];
            foreach($rows as $row) {
                if (count($row)!=$columns_count){
                    throw new ErrorException("Неправильная структура таблицы");
                }
                $csv[] = array_combine($header, $row);
                //print_r($row);
                //echo("---".count($csv).PHP_EOL);
            }
            //print_r($csv);
            //$this->header=array_values($header);
            //print_r($this->header);

            $data=json_encode($csv);

            //delete temp file
            unlink($file_path);

            return $data;
            
        }
    }

    public function getDataFromDBFFileByPath($file_path, $col_delimiter = '|', $row_delimiter = '\n',  $file_encodings = ['cp1251','UTF-8']){

    }
}
