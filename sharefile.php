<?php
    include 'functions.php';
    session_start();
    
    //check to see if the username entered is already in directory
    $shareuser = $_POST['shareuser'];
    $list_users = fopen("/home/gegbo/users.txt","r+");
    $directory = sprintf('/home/gegbo/uploaded_files/%s',$shareuser);
    
    
    $filename = $_POST['file'];
    
    // We need to make sure that the filename is in a valid format; if it's not, display an error and leave the script.
    // To perform the check, we will use a regular expression.
    if( !preg_match('/^[\w_\.\-]+$/', $filename) ){
        echo "Invalid filename";
        exit;
    }
    
    // Get the username and make sure that it is alphanumeric with limited other characters.
    // You shouldn't allow usernames with unusual characters anyway, but it's always best to perform a sanity check
    // since we will be concatenating the string to load files from the filesystem.
    if( !preg_match('/^[\w_\-]+$/', $shareuser) ){
        echo "Invalid username";
        exit;
    }
        
    $original_path = file_path($_SESSION['username'],$filename);
    $share_path = file_path($shareuser,$filename);
    
    if(isset($_POST['shareuser'])){
        if(strpos(file_get_contents("/home/gegbo/users.txt"),$shareuser) !== false){//checks if the other user exists
            if(is_dir($directory)){//if other user's directory exists
                copy($original_path,$share_path);
                header("Location: redirect.php");
                exit;
            }
        }
        else{
            echo $shareuser." does not exist.";
        }
        fclose($list_users);
        
    }

?>