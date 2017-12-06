<?php
    include 'functions.php';
    session_start();
    
    $user = $_SESSION['username'];
    
    //removes user from users.txt and any empty lines
    $list_users = file_get_contents('/home/gegbo/users.txt');
    $list_users = str_replace($user."","",$list_users);
    $list_users = preg_replace('/^\h*\v+/m', '', $list_users);
    file_put_contents('/home/gegbo/users.txt',$list_users);
    
    //removes files from directory (if any) then removes directory itself
    $directory = sprintf('/home/gegbo/uploaded_files/%s',$_SESSION['username']);
    
    if(is_dir($directory)) { //if directory exists
        if($directory_resouce = opendir($directory)) {
            while (($file = readdir($directory_resouce)) !== false) { //while there's still a file to be read
                if(not_hidden($file)) {
                    $file_path = sprintf($directory."/%s",$file);
                    unlink($file_path);
                }
            }
            closedir($directory_resouce);
        }
    }
    
    rmdir($directory);
    
    //Redirects to login page
    header("Location: login.php");
?> 