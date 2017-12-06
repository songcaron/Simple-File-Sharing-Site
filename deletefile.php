<?php
    include 'functions.php';
    session_start();
    
    $filename = $_POST['file'];
    echo $filename."<br>";
    
    // We need to make sure that the filename is in a valid format; if it's not, display an error and leave the script.
    // To perform the check, we will use a regular expression.
    if( !preg_match('/^[\w_\.\-]+$/', $filename) ){
        echo "Invalid filename";
        exit;
    }
    
    // Get the username and make sure that it is alphanumeric with limited other characters.
    // You shouldn't allow usernames with unusual characters anyway, but it's always best to perform a sanity check
    // since we will be concatenating the string to load files from the filesystem.
    $username = $_SESSION['username'];
    if( !preg_match('/^[\w_\-]+$/', $username) ){
        echo "Invalid username";
        exit;
    }
    
    $full_path = file_path($username, $filename);
    echo $full_path."<br>";
    
    unlink($full_path);
    header("Location: listing.php");
    exit();
?> 