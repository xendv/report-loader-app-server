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

    public function getDataFromCSVFileByPath($file_path, $col_delimiter = '|', $row_delimiter = '\\n',  $file_encodings = ['cp1251','UTF-8']){
        //checking file existence
        if( ! file_exists($file_path) )
            return false;
        else{
            $rows = array_map(function($v){return str_getcsv($v, "|");}, file($file_path));
            $header = array_shift($rows);
            foreach ($header as &$header_){
                $header_=strtolower($header_);
            }
            
            //print_r($header);
            if(in_array('okpo', $header)){
                $this->header=$header;
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
            else throw new ErrorException("Нет ОКПО!");
            
        }
    }

    public function getDataFromDBFFileByPath($file_path, $file_encodings = ['cp1251','UTF-8']){
        if( ! file_exists($file_path) )
        return false;
        else{
            $db = dbase_open($file_path, 0);
            if ($db){
                //getting headers
                $headers = [];
                foreach (dbase_get_header_info($db) as $header){
                    array_push($headers, strtolower($header['name']));
                } 
                $this->header=$headers;
                array_push($headers, 'deleted');
                $dbf = [];
                //combining array
                for($lineNumber = 1; $lineNumber <= dbase_numrecords($db); $lineNumber++) {
                    $row = dbase_get_record($db, $lineNumber);

                    array_push($dbf, array_combine($headers, $row));
                }

                $data=json_encode($dbf);
                dbase_close($db);
                //delete temp file
                unlink($file_path);
                
                return $data;

            }
            else return "COULDN'T OPEN DBF FILE";
        }
    }
}
