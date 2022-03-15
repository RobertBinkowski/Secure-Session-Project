<?php
    session_start();
    if (isset($_SESSION['Username'])){
        header("Location:dashboard.php");
    }
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
        <?php
                include "code/algorithms.php";
                if($_SERVER["REQUEST_METHOD"] == "POST"){ // Check for post
                    logInCheck($_POST['Username'],$_POST['Password']); //check for login details
                }
            ?>
    </main>
    <?php include "components/footer.php"; ?>
</body>
</html>