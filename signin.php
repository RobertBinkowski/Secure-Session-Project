<?php
    session_start();
    if (isset($_SESSION['Username'])){
        header("Location:dashboard.php");
    }
    if(!isset($_SESSION['num_login_fail'])){
        $_SESSION['num_login_fail'] = 0;
        $_SESSION['last_login_time'] = time();
    }
    include "code/connector.php";  

?>
<!DOCTYPE html>
<html>
<head>
<title>Project - Sign In</title>
</head>
<body>
    <?php include "components/nav.php"; ?>
    <main>
        <h1>Project - Sign In</h1>
        
        <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <?php
                include "code/algorithms.php";
                if($_SESSION['num_login_fail'] >= 3){
                    if($_SERVER["REQUEST_METHOD"] == "POST"){ // Check for post
                        if(checkInput($_POST['Username']) == TRUE && checkInput($_POST['Password']) == TRUE){ // Check input
                            logInCheck($_POST['Username'],$_POST['Password']); //check for login details
                        }
                        $_SESSION['num_login_fail']++;
                        $_SESSION['last_login_time'] = time();
                        displayAlert("Wrong Details Entered. Username: $_POST[Username], Password: $_POST[Password]");
                    }
                }else{
                    if(time() - $_SESSION['last_login_time'] < 60*60 ){
                        displayAlert("Access Blocked for 3 min");
                    }else{
                        $_SESSION['num_login_fail'] = 0;
                        displayAlert("Access Restored");
                    }
                    displayAlert("Still on the time out");
                }
            ?>
            <label for="Username">Username:</label><br>
            <input type="text" name="Username" required><br>
            <label for="Password">Password:</label><br>
            <input type="password" name="Password" required><br>
            <input type="submit" value="Sign In">
        </form>

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