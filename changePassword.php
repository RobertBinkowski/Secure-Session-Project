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
<title>Project - Change Password</title>
</head>
<body>
    <?php include "components/nav.php"; ?>
    <main>
        <h1>Hello <?php echo $_SESSION["Username"]; ?></h1>
        <h2>Change Password</h2>

        <form method="POST">
            <label for="oldPass">Old Password:</label><br>
            <input type="password" name="oldPass"><br>
            <label for="newPass">New Password:</label><br>
            <input type="password" name="newPass"><br>
            <label for="confPass">Confirm Password:</label><br>
            <input type="password" name="confPass"><br>
            <input type="submit" value="Chaneg Password">
        </form>
        <style>
                main{
                    min-height: 100vh;
                    padding-top:5em;
                }
        </style>
        <?php
            include "code/algorithms.php";
            if($_SERVER["REQUEST_METHOD"] == "POST"){ // Check for POST
                if(strcmp($_POST['newPass'], $_POST['confPass']) == 0){ // Ensure they are the same
                    echo changePass($_POST['oldPass'],$_POST['newPass']); //change password
                }else{
                    echo "Make sure the new and the old password is the same";
                }
            }
        ?>
    </main>
    <?php include "components/footer.php"; ?>

</body>
</html>