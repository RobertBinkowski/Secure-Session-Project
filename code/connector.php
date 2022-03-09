<?php
// Connect to the Database
$servername = "localhost";
$username = "root";
$password = ""; // Unbrakable passowrd here xD
$dbname = "secure-app-project";
$conn = new mysqli($servername, $username, $password,$dbname);
if ($conn->connect_error) {
  die("No Connection");
}
//Create Database if non exists
// $query = "CREATE DATABASE IF NOT EXISTS $dbname";
// $query = "CREATE TABLE IF NOT EXISTS `secure-app-project`.`users` ( `ID` INT NOT NULL AUTO_INCREMENT , `Username` VARCHAR(1000) NOT NULL , `Password` VARCHAR(1000) NOT NULL , `Salt` VARCHAR(1000) NOT NULL , `Admin` BOOLEAN NOT NULL DEFAULT FALSE , PRIMARY KEY (`ID`)) ENGINE = InnoDB;";
// $query = "INSERT INTO IF NOT EXISTS `users` (`ID`, `Username`, `Password`, `Salt`, `Admin`) VALUES (NULL, 'admin', 'admin', 'admin', 'Yes');";
// $query = "INSERT INTO `log` (`ID`, `Action`, `Timestamp`, `User`, `IP`) VALUES (NULL, 'Random', current_timestamp(), '0', '192.168.1.1');";
// if ($conn->query($query) === TRUE) {
//     echo "Worked";
//   }
?>