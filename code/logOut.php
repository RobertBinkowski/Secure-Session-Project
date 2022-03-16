<?php
    session_start();
    session_unset();
    echo "Succesfully Logged Out";
    header("Location:../signIn.php");
?>