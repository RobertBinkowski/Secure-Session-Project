<?php 
    session_start();
    include "code/connector.php";
?>
<!DOCTYPE html>
<html>
<head>
<title>Project</title>
</head>
<body>
    <?php include "components/nav.php"; ?>
    <main>
        <h1>Index</h1>
        <p>
            This is the Index Page.
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