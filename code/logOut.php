<?php
    session_start();
    session_unset();
    echo "<script>alert('Successfully Logged Out')</script>";
    header("Location:index.php");
?>