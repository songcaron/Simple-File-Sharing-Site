<?php
    function file_path($username,$file_name) {
        $file = replace_spaces($file_name);
        return sprintf("/home/gegbo/uploaded_files/%s/%s",$username,$file); //filepath where file will be placed 
    }
    
    function not_hidden($file) {
        if($file[0] != '.') {
            return true;
        }
    }
    
    function replace_spaces($file) {
        return str_replace(" ","",$file);
    }
?> 