<?php
    session_start();
    if (!isset($_SESSION['Username'])){
        header("Location:signin.php");
    }else if(strcmp($_SESSION['Username'], 'ADMIN') != 0){
        header("Location:dashboard.php");
    }
    include "code/connector.php";
?>
<!DOCTYPE html>
<html>
<head>
<title>Project - Logs</title>
</head>
<body>
    <?php include "components/nav.php"; ?>
    <main>
        <h1>Hello <?php echo $_SESSION["Username"]; ?></h1>
        <h2>logs</h2>


        <?php 
        
            include "code/algorithms.php";
            echo showAllLogs();

        ?>
        <style>
                main{
                    min-height: 100vh;
                    padding-top:5em;
                }
                .returnData{
                    width: 100vw;
                    max-width: 1000px;
                }
        </style>
    </main>
    <?php include "components/footer.php"; ?>

</body>
</html>