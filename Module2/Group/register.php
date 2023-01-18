<!--
This file is for a new user to register.
-->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="style/signup.css">
</head>
<body>
    <h1>Register</h1>
    <!-- text and button for register. -->
    <form class="registertext" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="POST">
        <label >Please input your username:</label>
        <br>
        <input type="text" name="newuser" placeholder="Input your Username"/>
        <br>
        <input type="submit" value="Register" />
    </form>
    <form class=back action="login.php" method="POST">
    <input type="submit" value="Back">
</form>
<!-- Write the new user information into the users.txt and create user's folders. -->
    <?php
    if (isset($_POST['newuser'])) {
        $newusername = $_POST['newuser'];
        echo "your user name is $newusername";
        if(is_dir("/home/jesse/module2/userfile/".$newusername)){
            echo "<h2 style='text-align: center;'>This name has been taken. Please enter a new one.</h2>";
        }
        else if(!preg_match('/^[\w_\.\-]+$/', $newusername)){
            echo "<h2 style='text-align: center;'>Invalid Username!</h2>";
        }
        else{
            echo "prepare create filefolder and append new user";
            mkdir('/home/jesse/module2/userfile/'.$newusername);

            mkdir('/home/jesse/module2/userfile/'.$newusername.'/share');

            mkdir('/home/jesse/module2/userfile/'.$newusername.'/private');

            mkdir('/home/jesse/module2/userfile/'.$newusername.'/temp');
      
            file_put_contents('/home/jesse/module2/users.txt', $newusername."\r\n", FILE_APPEND);
            echo "<h2 style='text-align: center;'>You have successfully registered! Redirecting to log in page in 5 seconds.</h2>";
            header("refresh:5;url=login.php");
        }   
    }
    ?>
<br>
</body>
</html>
