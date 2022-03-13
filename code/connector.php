<?php
// Connect to the Database
include "variables.php";
$conn = new mysqli($DBservername, $DBusername, $DBpassword);
if (!$conn) {
  die("No Connection" . $conn->connect_error);
}

// Create Database if non exists
try {
    $databaseConnection = mysqli_select_db($conn, $DBname);
}catch(throwable $e){
    include "algorithms.php";
    $query = "CREATE DATABASE IF NOT EXISTS $DBname;";
    $conn->query($query);
    $query = "CREATE TABLE IF NOT EXISTS $DBname.$DBusers ( `ID` INT NOT NULL AUTO_INCREMENT , `Username` VARCHAR(1000) NOT NULL , `Password` VARCHAR(1000) NOT NULL , `Salt` VARCHAR(1000) NOT NULL , `Admin` BOOLEAN NOT NULL DEFAULT FALSE , PRIMARY KEY (`ID`)) ENGINE = InnoDB;";
    $conn->query($query);
    $query = "CREATE TABLE IF NOT EXISTS $DBname.$DBlogs ( `ID` INT NOT NULL AUTO_INCREMENT , `Username` VARCHAR(1000) NOT NULL , `IP` VARCHAR(1000) NOT NULL, `Access` BOOLEAN NOT NULL DEFAULT FALSE , PRIMARY KEY (`ID`)) ENGINE = InnoDB;";
    if($conn->query($query) === TRUE){
        $salt = generateSalt();
        $adminUser = "ADMIN";
        $AdminPass = hashFunction("SaD_2021",$salt);
        $query="INSERT INTO $DBname.$DBusers (`ID`, `Username`, `Password`, `Salt`, `Admin`) VALUES (NULL, '$adminUser', '$AdminPass', '$salt', '1');";
        if($conn->query($query) === TRUE){
            // echo "
            // Database Created!
            // <br>
            // Just because I trust you very much. I will give you the login and password to the Admin user.
            // But I trust that you will not use it for any nefarious reasons.
            // Trust is important.
            // ID: 'ADMIN'
            // Password: 'SaD_2021'
            // ";
        }
    }
}
$conn = mysqli_connect($DBservername, $DBusername, $DBpassword, $DBname);
?>