<?php
    session_start();
    include 'functions.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <title>File Listing</title>
        <link rel='stylesheet' type='text/css' href='listing_style.css'>
    </head>
    <body>
        <?php
            if(isset($_GET['user'])) { //checks if username came from login page
                if(ctype_alnum($_GET['user'])) {
                    $_SESSION['username'] = $_GET['user'];
                }
                else {
                    header("Location: login.php");
                }
            }
                        
            $list_users = fopen("/home/gegbo/users.txt","a+");
            
            $directory = sprintf('/home/gegbo/uploaded_files/%s',$_SESSION['username']);
            
            if(strpos(file_get_contents("/home/gegbo/users.txt"),$_SESSION['username']) !== false) { //username is on the list
                echo "Welcome back, ".$_SESSION['username']."&nbsp;&nbsp;";
                
                //logout                                    
                echo "<form action='logout.php' method='POST'>";
                echo "<input class='logout' type='submit' value='Logout'>";
                echo "</form><br><br><br>";
                
                //option to delete user if needed
                echo "<form method='POST'>";
                echo "<input class='delete' type=submit formaction='deleteuser.php' name='delete' value='Delete Account'>";
                echo "</form>";
                                                
                if(is_dir($directory)) { //if directory exists
                    if($directory_resouce = opendir($directory)) {
                        while (($file = readdir($directory_resouce)) !== false) { //while there's still a file to be read
                            if(not_hidden($file)) {
                                echo "<div class='buttons'>";
                                //list file along with buttons to view and delete
                                echo "<form method='POST'>";
                                echo $file."&nbsp;<input type=submit formaction='downloadfile.php' name='view' value='View'>"."&nbsp;&nbsp;"."<input type=submit formaction='deletefile.php' name='delete' value='Delete'>"."&nbsp;&nbsp;";
                                echo "<input type='hidden' name='file' value=".$file.">";
                                echo "</form>";
                                
                                //option to share
                                echo "<form action='sharefile.php' method='POST'>";
                                echo "<input type='submit' value='Share'>";
                                echo "<input id='share' type='text' placeholder='Username want to share with' name='shareuser'/></label>"."<br>";
                                echo "<input type='hidden' name='file' value=".$file.">";
                                echo "</form>";
                                
                                echo "</div><br>";
                            }
                        }
                        closedir($directory_resouce);
                    }
                }
            }
            else { //add user to the list
                $user = $_SESSION['username'];
                fwrite($list_users,$user."\n");
                
                mkdir("/home/gegbo/uploaded_files/".$user,0755); //creates directory for new user
                
                echo "Welcome, ".$user."! Thanks for joining our service. &nbsp;&nbsp;";
                                
                //logout                                    
                echo "<form action='logout.php' method='POST'>";
                echo "<input class='logout' type='submit' value='Logout'>";
                echo "</form><br><br><br>";
                
                //option to delete user if needed 
                echo "<form method='POST'>"; 
                echo "<input class='delete' type=submit formaction='deleteuser.php' name='delete' value='Delete Account'>";
                echo "</form>";
            }
            
            fclose($list_users);
        ?>
        <form enctype="multipart/form-data" action="uploadfile.php" method="POST">
        <p>
            <input type="hidden" name="MAX_FILE_SIZE" value="40000000" />
            <label for="uploadfile_input">Choose a file to upload:</label><input name="uploadedfile" type="file" id="uploadfile_input" />
        </p>
        <p>
            <input type="submit" value="Upload File" />
        </p>
        </form>
    </body>
</html>