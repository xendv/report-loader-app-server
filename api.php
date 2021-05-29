<?php
    
	//require_once('./scripts-php/upload.php');
    header('Access-Control-Allow-Origin: http://localhost:3000');  
    require_once(__DIR__.'/scripts-php/classes/dataVisualiser.php');
    require_once(__DIR__.'/scripts-php/classes/dataUploader.php');
    require_once(__DIR__.'/scripts-php/classes/dataBaseManager.php');
    $upload_tmp_dir='./temp/';

    if ($_POST["action"]=="sendFileContent"){
        $file;
        if (is_uploaded_file($_FILES["file"]["tmp_name"])) {
            $file=$_FILES["file"]["tmp_name"];
            move_uploaded_file($_FILES["file"]["tmp_name"], $_FILES["file"]["name"]);
            $temp_file_name = substr($_FILES['file']['tmp_name'],
            1 + strrpos($_FILES['file']['tmp_name'], "\\"));
            echo('-------Temp name: '.$temp_file_name);

            echo "File was posted. Path: ".$file;
            echo('---------');
            $file=$_FILES["file"]["name"];
            print_r($file);
            echo('---------'.$_FILES["file"]["name"]);
            $pure_file = json_decode(file_get_contents($_FILES['file']['name'], true));
            echo("sfgge: ".$_FILES["file"]["name"]);
            //print_r($_FILES);
            echo("Type of file: ".$_POST["type"]);
            echo('--------- PURE :');
            print_r($pure_file);
           
            getDataFromFile($file);
            exit;
        }else {  
            echo 'No file was posted';
        }
    }

    
    
    function getDataFromFile($file){
        $dataVisualiser = new dataVisualiser;
        $data=$dataVisualiser->getDataFromCSVFileByPath($file);
        //echo $file;
        //$data=$dataVisualiser->getDataFromCSVFileByPath('./'.$tmp_name);
        echo "Данные файла: ";
        print_r($data);
    }
	
    //uploadData($_FILES["file"]["tmp_name"]);
    /*if (move_uploaded_file($_FILES["file"]["tmp_name"], "upload/".$_FILES['file']['name'])) {
        echo "done";
        exit;
    }*/

    //echo "failed";

?>