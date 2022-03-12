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
<title>Project - Sign UP</title>
</head>
<body>
    <?php include "components/nav.php"; ?>

    <main>
        <h1>Project - Sign UP</h1>
        
        <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <?php
                include "code/algorithms.php";
                if($_SERVER["REQUEST_METHOD"] == "POST"){
                    if(strcmp($_POST['Password'], $_POST['repeatPassword']) != 0){
                        echo "ERROR!! -Make sure Password and Repeat Password is the same";
                    }else{
                        if(checkInput($_POST['Username']) == TRUE && checkInput($_POST['Password']) == TRUE){
                            registerUser($_POST['Username'],$_POST['Password']);
                        }else{
                            displayAlert("Please make sure you satisfy the requirements");
                        }
                    }
                }
            ?>
            <br>
            <label for="Username">Username:</label><br>
            <input type="text" name="Username" required><br>
            <label for="Password">Password:</label><br>
            <input type="password" name="Password" required><br>
            <label for="repeatPassword">Repeat Password:</label><br>
            <input type="password" name="repeatPassword" required><br>
            <input type="submit" value="Sign UP">
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