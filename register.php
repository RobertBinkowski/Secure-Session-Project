<?php
    session_start();
    if (isset($_SESSION['Username'])){
        header("Location:dashboard.php");
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
        <h1>Project - Sign Up</h1>
        
        <form action="POST">
            <label for="Username">Username:</label><br>
            <input type="text" name="Username"><br>
            <label for="Password">Password:</label><br>
            <input type="password"><br>
            <label for="repeatPassword">Repeat Password:</label><br>
            <input type="repeatPassword"><br>
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