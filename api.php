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
            //move_uploaded_file($_FILES["file"]["tmp_name"], $_FILES["file"]["name"]);
            //move_uploaded_file($_FILES["file"]["tmp_name"], './temp/'.$_FILES["file"]["name"]);
            
            
            $temp_file_name_with_ext = substr($_FILES['file']['tmp_name'],
            1 + strrpos($_FILES['file']['tmp_name'], "\\"));
            echo('-------Temp name+ ext: '.$temp_file_name_with_ext);
            $temp_file_name=basename($_FILES['file']['tmp_name'], ".tmp");
            //substr($temp_file_name_with_ext, 1 + strrpos($temp_file_name_with_ext, "."));
            echo('-------Temp name: '.$temp_file_name);
            $new_temp_file_name=$temp_file_name.'_'.$_FILES["file"]["name"];
            move_uploaded_file($_FILES["file"]["tmp_name"], './temp/'.$new_temp_file_name);

            $uplfilePath='./temp/'.$new_temp_file_name;
            

            echo "File was posted. Path: ".$file;
            echo('---------$file: ');
            $file=$_FILES["file"]["name"];
            print_r($file);
            echo('---------Имя загружаемого файла: '.$_FILES["file"]["name"]);
            //$pure_file = json_decode(file_get_contents($_FILES['file']['name'], true));
            //print_r($_FILES);
            echo("Type of file: ".$_POST["type"]);
            //echo('--------- PURE :');
            //print_r($pure_file);
            echo("uplfilePath: ".$uplfilePath);
            getDataFromFile($uplfilePath);
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