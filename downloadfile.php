<?php
    //include 'functions.php';
    session_start();
    
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
    $username = $_SESSION['username'];
    if( !preg_match('/^[\w_\-]+$/', $username) ){
        echo "Invalid username";
        exit;
    }
     
    $full_path = sprintf("/home/gegbo/uploaded_files/%s/%s",$username,$filename); //filepath where file will be placed ;
     
    // Now we need to get the MIME type (e.g., image/jpeg).  PHP provides a neat little interface to do this called finfo.
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mime = $finfo->file($full_path);
     
    $allowedext = array("image/jpeg", "image/jpg", "image/png", "image/gif","text/plain","application/pdf");
    
    if(in_array($mime,$allowedext)) {
        header("Content-Type: ".$mime);
        readfile($full_path);
    }
    else {
        header('Content-Type: application/octet-stream');
        header("Content-Transfer-Encoding: Binary");
        header(sprintf("Content-disposition: filename=\"%s\"",$filename));
        readfile($full_path);
    }
?>