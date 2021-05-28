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
        }
        else {
            $db_connection=$dbconnect;
            // set schema
            /*$query = "SET search_path TO ftei;";
            $res = pg_query($dbconnect, $query);
            
            //getting data from db
            $query = "SELECT * FROM main_info_tb";
            $res = pg_query($dbconnect, $query);
            while ($row = pg_fetch_row($res)) {
                echo "tableName: $row[0] columnName: $row[1]";
                echo "<br />\n";
            }*/
            return true;
        }
    }
}
