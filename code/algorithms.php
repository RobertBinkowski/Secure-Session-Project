<?php
//DOME
function logData($action, $user, $access){
    $conn = new mysqli("localhost", "root", "","project");
    $ipAddress = $_SERVER['REMOTE_ADDR'];
    //INSERT INTO `logs` (`ID`, `Username`, `Action`, `IP`, `Access`) VALUES (NULL, 'a', 'SDFSDF', '192', '0');
    $query = "INSERT INTO `logs` (`ID`, `Username`, `Action`, `IP`, `Access`) VALUES (NULL, '$user', '$action', '$ipAddress', '$access');";
    try{
        $conn->query($query);
    }catch(Throwable $th){
        echo "Error Logging Data";
    }
}//DONE

//DONE
function registerUser($username, $password){
    $conn = new mysqli("localhost", "root", "","project");
    if(checkInput($username)&& checkInput($password)){
        $salt = generateSalt();
        $hashedpassword = hashFunction($password, $salt);
        $query = "INSERT INTO `users` (`ID`, `Username`, `Password`, `Salt`, `Admin`) VALUES (NULL, '$username', '$hashedpassword', '$salt', '0');";
        try{
            $conn->query($query);
            logData("Registery Competed",$username, 1);
        }catch(Exception $e){
            logData("Failed to Register","None",'');
            echo "Failed to create User<br>Username: $username<br>Password: $password<br>Username is taken";
            exit();
        }
    }else{
        echo "Do not use Scrypts Please" ;
    }
    echo "User Created";
    $conn->close();
}//DONE

//DONE
function logInCheck($user, $pass){
    if(checkInput($user)&& checkInput($pass)){

        $conn = new mysqli("localhost", "root", "","project");
        //Log In check
        if(checkInput($user) == TRUE && checkInput($pass) == TRUE){
            $query = "SELECT * FROM `users`";
            $query = $conn->query($query);
            if ($query->num_rows > 0){
                while($row = $query->fetch_assoc()){
                    if(strcmp($row['Username'], $user) == 0){
                        if(strcmp($row['Password'],hashFunction($pass,$row['Salt'])) == 0){
                            $_SESSION['ID'] = $row['ID'];
                            $_SESSION['num_login_fail'] = 0;
                            $_SESSION['Username'] = $user;
                            logData("User Looged In",$user, '1');
                            header("Location:dashboard.php");
                        }
                        break;
                    }
                }
            }else{
                return "No users";
            }
        }
        $_SESSION['failedAttempt']++;
        $_SESSION['timer'] = time();

        $output = "Wrong Details Entered. Username: '$_POST[Username]', Password: '$_POST[Password]'";
        echo $output;
    }else{
        echo "You Tried to enter a script or you wran out of tries and you have to wait 5 min" ;
    }
}//DONE

//DONE
function checkInput($input){ // Sanitize input
    if($input == ""){
        return FALSE;
    }
    $checkArray = ["<",">", "/", "//", "%"];
    foreach($checkArray as $item){
        if(strpos($input, $item) !== FALSE){
            return FALSE;
        }
    }
    return TRUE;
}//DONE

//DONE
function changePass($oldPass, $newPass) {
    $conn = new mysqli("localhost", "root", "","project");
    //Check Input
    if(checkInput($newPass) == FALSE || checkInput($oldPass) == FALSE){
        return "Wrong Input";
    }
    //Check old pass
    $id = $_SESSION['ID'];
    $query = "SELECT * FROM `users` WHERE `ID` = '$id' ";
    $acc = $conn->query($query)->fetch_assoc();
    if(!(strcmp($acc['Password'],hashFunction($oldPass, $acc['Salt']) == 0 ))){
        return "Wrong Password";
    }
    $query = $conn->query($query);
    $salt = generateSalt();
    $newPass = hashFunction($newPass,$salt);
    $query = "UPDATE `users` SET `Password` = '$newPass' WHERE `users`.`ID` = '$id';";
    $conn->query($query);
    $query = "UPDATE `users` SET `Salt` = '$salt' WHERE `users`.`ID` = '$id';";
    $conn->query($query);
    return "Password Changed";
}//DONE

//DONE
function showAllLogs() {
    $conn = new mysqli("localhost", "root", "","project");
    $query = "SELECT * FROM `logs`";
    $query = $conn->query($query);
    $output = "";
    if($query->num_rows > 0){
        $output = $output . "<table class='returnData'><tr><th>ID</th><th>Username</th><th>IP Adderss</th><th>Action</th><th>Access Granted</th></tr>";
        while($row = $query->fetch_assoc()){
            $output = $output . "<tr><th>". $row['ID'] . "</th><th>" . $row['Username']. "</th><th>" . $row['IP'] . "</th><th>" . $row['Action']."</th><th>";
            if($row['Access'] == 1){
                $output = $output . "Yes</th></tr>";
            }else{
                $output = $output . "No</th></tr>";
            }                     
        }
        $output = $output . "</table>";
    }else{
        $output = $output . "No Logs";
    }
    echo $output;
}//Done

//DONE
function generateSalt(){
    //Genius Salt creation - Do not question it please.
    //Shuffles the string, then cuts out a random snippit
    $salt = substr(str_shuffle("SomeSaltsShouldNeverBeTemperedWith"),rand(15,32));
    return $salt;
} // Done

//DONE
function hashFunction($data, $salt){
    include "variables.php";
    //First add salt to the password
    $hash = hash( $hashAlgorithm ,$salt . $data);

    return $hash;
}//DONE
?>