<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of dataBaseManager
 *
 * @author xendv
 */
class dataBaseManager {
    //put your code here
    public $host='localhost';
    public $port='5432';
    public $db='ftei_db';
    public $username='postgres';
    public $password='';
    
    public $db_connection;
    //private $url="jdbc:postgresql://localhost:5432";
    //private $db_connection_string = "host=".$host." port=".$port". dbname=".$db."";
    public $db_connection_string = "host=localhost port=5432 dbname=ftei_db user=postgres options='--client_encoding=UTF8'";
    
    public function connectToDb (){
        //$this->db_connection_string = "host=localhost port=5432 dbname=ftei_db options='--client_encoding=UTF8'";
        $dbconnect = pg_connect($this->db_connection_string);
        if (!$dbconnect) {
            die('Could not connect');
            return false;
        }
        else {
            $this->db_connection=$dbconnect;
            // set schema
            $query = "SET search_path TO ftei;";
            $res = pg_query($dbconnect, $query);
                 
            return true;
        }
        
    }

    public function getDBMainContent (){
        $dbconnect=$this->db_connection;
        //getting data from db
        $query = "SELECT * FROM main_info_tb";
        $res = pg_query($dbconnect, $query);
        /*while ($row = pg_fetch_row($res)) {
            echo "tableName: $row[0] columnName: $row[1]";
            echo "<br />\n";
        }*/

        while($row = pg_fetch_assoc($res))
        {
            $data[] = $row;
        }
        
        //print_r($data);

        if(isset($data))
        {
            header('Content-Type: application/json');
            //$noSlashes = str_replace("\\\\","",$data); /* no need for json_encode() */
            //$data = array_values($noSlashes[0]);
            /*foreach($data as $value)
            {
                //print_r($value);
                $value=str_replace("\\","",$value);
            }*/
            //$test = str_replace('\\\\', '\\', json_encode($data));
            echo json_encode($data);
        }
    }
    public function getDBIndContentByOKPO ($okpo){
        $dbconnect=$this->db_connection;
        //getting data from db
        $query = "SELECT * FROM indexes WHERE okpo='".$okpo."'";
        $res = pg_query($dbconnect, $query);

        while($row = pg_fetch_assoc($res))
        {
            $data[] = $row;
        }
        
        //print_r($data);

        if(isset($data))
        {
            header('Content-Type: application/json');
            echo json_encode($data);
        }
    }

    public function saveData($data_json_string){
        $dbconnect=$this->db_connection;

        //make array of assoc arrays fron json string
        $data = json_decode($data_json_string, true);

        foreach($data as $row) {
            //check if company exists in main_info_tb
            $query = "SELECT exists (select * FROM main_info_tb WHERE okpo='{$row['okpo']}')";
            $res = pg_query($dbconnect, $query);
            //$main
            //echo (PHP_EOL.$res);
            if ($res){
                //update or add values
                $query = "INSERT INTO main_info_tb (okpo) VALUES('{$row['okpo']}');
                INSERT INTO indexes(okpo) VALUES('{$row['okpo']}')";
                $res = pg_query($dbconnect, $query);
            }
            $this->updateRow($row);
            //print_r($row);
            //echo("---".count($csv).PHP_EOL);
        }

        //print_r($data);

        //$query = "SELECT * FROM indexes WHERE okpo='".$okpo."'";
        //$res = pg_query($dbconnect, $query); ???

    }
    public function updateRow($row){
        foreach ($row as $key => $table_item){
            if($key !='okpo'){
                //echo(PHP_EOL.$key);
                $table_name='indexes';
                if($key =='name') $table_name='main_info_tb';
                $query = "UPDATE {$table_name} SET {$key} = '{$table_item}'  WHERE okpo='{$row['okpo']}'";
                
                $res = pg_query($this->db_connection, $query);
            }
        }
    }
}
