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
<title>Project - Change Password</title>
</head>
<body>
    <?php include "components/nav.php"; ?>
    <main>
        <h1>Hello <?php echo $_SESSION["Username"]; ?></h1>
        <h2>Change Password</h2>

        <form method="POST">
            <label for="oldPass">Old Password:</label><br>
            <input type="password" passwordrules="required: upper; required: lower; required: digit; 
                 minlength: 8; allowed: [-().&@?'#,/&quot;+]; max-consecutive: 2" name="oldPass"><br>
            <label for="newPass">New Password:</label><br>
            <input type="password" passwordrules="required: upper; required: lower; required: digit; 
                 minlength: 8; allowed: [-().&@?'#,/&quot;+]; max-consecutive: 2" name="newPass">
            <label for="confPass">Confirm Password:</label><br>
            <input type="password" passwordrules="required: upper; required: lower; required: digit; 
                 minlength: 8; allowed: [-().&@?'#,/&quot;+]; max-consecutive: 2" name="confPass"><br>
            <input type="submit" value="Chaneg Password">
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