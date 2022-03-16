<?php
    session_start();
    if (!isset($_SESSION['Username'])){
        header("Location:signin.php");
    }
    if(!isset($_SESSION['oneHourTimeOut'])){
        $_SESSION['oneHourTimeOut'] = time(); // One Hour
    }
    if(time() - $_SESSION['oneHourTimeOut'] == 60*60){
        header("Location:code/logOut.php");
    }
    if(!isset($_SESSION['timeOut'])){
        $_SESSION['timeOut'] = time(); // 10 min
    }
    if(time() - $_SESSION['timeOut'] == 10*60){
        header("Location:code/logOut.php");
    }
?>
<!DOCTYPE html>
<html>
<head>
<title>Project - Dashboard</title>
</head>
<body>
    <?php include "components/nav.php"; ?>
    <main>
        <h1>Hello <?php echo $_SESSION["Username"]; ?></h1>
        <h2>Dashboard</h2>


        <p>
            This is some dashboard here. 
            I was going to add some data here... but I was too lazy.
        </p>
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