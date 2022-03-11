<?php
// Connect to the Database
$servername = "localhost";
$username = "root";
$password = ""; // Unbrakable passowrd here xD
$dbname = "project";
$users = "users";
$logs = "logs";
$conn = new mysqli($servername, $username, $password);
if (!$conn) {
  die("No Connection" . $conn->connect_error);
}
echo "Successful conneciton <br>";

// Create Database if non exists
try {
    $databaseConnection = mysqli_select_db($conn, $dbname);
}catch(throwable $e){
    include "algorithms.php";
    $query = "CREATE DATABASE IF NOT EXISTS $dbname;";
    $conn->query($query);
    $query = "CREATE TABLE IF NOT EXISTS $dbname.$users ( `ID` INT NOT NULL AUTO_INCREMENT , `Username` VARCHAR(1000) NOT NULL , `Password` VARCHAR(1000) NOT NULL , `Salt` VARCHAR(1000) NOT NULL , `Admin` BOOLEAN NOT NULL DEFAULT FALSE , PRIMARY KEY (`ID`)) ENGINE = InnoDB;";
    $conn->query($query);
    $query = "CREATE TABLE IF NOT EXISTS $dbname.$logs ( `ID` INT NOT NULL AUTO_INCREMENT , `Username` VARCHAR(1000) NOT NULL , `IP` VARCHAR(1000) NOT NULL, `Access` BOOLEAN NOT NULL DEFAULT FALSE , PRIMARY KEY (`ID`)) ENGINE = InnoDB;";
    if($conn->query($query) === TRUE){
        $salt = generateSalt();
        $username = hashFunction("ADMIN",$salt);
        $password = hashFunction("SaD_2021",$salt);
        $query="INSERT INTO $dbname.$users (`ID`, `Username`, `Password`, `Salt`, `Admin`) VALUES (1, $username, $password, $salt, 'Yes');";
        if($conn->query($query) === TRUE){
            echo "Worked ALL";
        }
    }
}
$conn = mysqli_connect($servername, $username, $password, $dbname);
?>