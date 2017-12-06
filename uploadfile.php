<?php
        include 'functions.php';
        session_start();
        
        // Get the filename and make sure it is valid
        $filename = replace_spaces(basename($_FILES['uploadedfile']['name']));
        if( !preg_match('/^[\w_\.\-]+$/', $filename) ){
                echo "Invalid filename";
                exit;
        }
        
        // Get the username and make sure it is valid
        $username = $_SESSION['username'];
        if( !preg_match('/^[\w_\-]+$/', $username) ){
                echo "Invalid username";
                exit;
        }
         
        $full_path = file_path($username,$filename);
         
        if( move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $full_path) ){
                header("Location: listing.php");
                exit;
        }else{
                header("Location: upload_failure.html");
                exit;
        }
        

?>