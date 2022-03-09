<?php
    session_start();
    if (!isset($_SESSION['Username'])){
        header("Location:signin.php");
    }
    include "code/connector.php";
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
            echo $_SESSION["Username"];
            echo $_SESSION["Password"];
        ?>
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