<?php
    
	//require_once('./scripts-php/upload.php');
    header('Access-Control-Allow-Origin: http://localhost:3000');  
    require_once(__DIR__.'/scripts-php/classes/dataVisualiser.php');
    require_once(__DIR__.'/scripts-php/classes/dataUploader.php');
    require_once(__DIR__.'/scripts-php/classes/dataBaseManager.php');
    $upload_tmp_dir='./temp/';

    if ($_POST["action"]=="sendFileContent"){
        if (is_uploaded_file($_FILES["file"]["tmp_name"])) {
            $uploaded_file=$_FILES["file"]["tmp_name"];
            $original_file=$_FILES["file"]["name"];
            echo "- File was posted. Path: ".$uploaded_file.PHP_EOL;
            echo('- Original file name: '.$original_file.PHP_EOL);
            echo("- Original file type: ".$_POST["type"].PHP_EOL);        
            
            $temp_file_name_with_ext = substr($_FILES['file']['tmp_name'],
            1 + strrpos($_FILES['file']['tmp_name'], "\\"));
            echo('- Temp name + ext: '.$temp_file_name_with_ext.PHP_EOL);

            $temp_file_name=basename($_FILES['file']['tmp_name'], ".tmp");
            echo('- Temp name: '.$temp_file_name.PHP_EOL);

            $new_temp_file_name=$temp_file_name.'_'.$_FILES["file"]["name"];
            move_uploaded_file($_FILES["file"]["tmp_name"], './temp/'.$new_temp_file_name);

            $newTempFilePath='./temp/'.$new_temp_file_name;           

            echo("- New temp file path: ".$newTempFilePath.PHP_EOL);
            getDataFromFile($newTempFilePath);
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