<?php
    session_start();
    if (!isset($_SESSION['Username'])){
        header("Location:signin.php");
    }
    include "code/connector.php";
    if(time() - $_SESSION['oneHourTimeOut'] == 60*60){
        header("Location:code/logOut.php");
    }
    $_SESSION['timeOut'] = time(); // 10 min
    if(time() - $_SESSION['timeOut'] == 10*60){
        header("Location:code/logOut.php");
    }
?>
<!DOCTYPE html>
<html>
<head>
<title>Project - User Info</title>
</head>
<body>
    <?php include "components/nav.php"; ?>
    <main>
        <h1>Hello <?php echo $_SESSION["Username"]; ?></h1>
        <h2>User Info</h2>


        <?php 
            echo "Your username is: ". $_SESSION["Username"];
        ?>
        <br>
        <br>
        <a href="changePassword.php">Change Password</a> 
        <style>
                main{
                    min-height: 100vh;
                    padding-top:5em;
                }
        </style>
    </main>
    <?php include "components/footer.php"; ?>

</body>
</html>