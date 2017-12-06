<!DOCTYPE html>
<html>
    <head>
        <title>Redirect</title>
    </head>
    <body>
        <?php
        session_start();
        echo "Your file has been shared! Please wait 5 seconds to be redirected to your page.";
        header("refresh:5;url=listing.php");
        exit;
        ?>
    </body>
</html>
