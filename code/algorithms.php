<?php
// Error Check
function queryDatabase($query){
    include "connector.php";
    try{
        if ($conn->query($query) === TRUE) {
            logData("Database Query", "SERVER", "1");
            return $conn->query($query);
          }
    } catch(Throwable $th){
        logData($th->getMessage(),"SERVER","1");
    }
}//DONE

function logData($action, $user, $access){
    $ipAddress = $_SERVER['REMOTE_ADDR'];
    $query = "INSERT INTO `logs` (`ID`, `Username`, `IP`, `Access`, `Action`) VALUES (NULL, '$user', '$ipAddress', '$access', '$action');";
    try{
        queryDatabase($query);
    }catch(Throwable $th){
        echo $th->getMessage();
    }
}//DONE

function registerUser($username, $password){
    $salt = generateSalt();
    $password = hashFunction($password, $salt) ;
    $query = "INSERT INTO `users` (`ID`, `Username`, `Password`, `Salt`, `Admin`) VALUES (NULL, '$username', '$password', '$salt', '0');";
    try{
        queryDatabase($query);
        logData("Registration",$username,1);
    }catch(exception $e){
        logData("Register - Failed: $e",$username,0);
    }
    displayAlert("Account - Registered Successfully");
    //Log them in here....
    header("Location:signIn.php");
}//DONE

function displayAlert($alert){
    echo "<script>alert('$alert')</script>";
}//DONE

function endTimer(){
    sleep(2*60);
    $_SESSION['num_login_fail'] = 0;
    displayAlert("Access Restored");
}//Done

function logInCheck($user, $pass){
    include "code/connector.php";
    if(!isset($_SESSION['num_login_fail'])){ // Set if not set
        $_SESSION['num_login_fail'] = 0;
        $_SESSION['last_login_time'] = time();
    }
    if($_SESSION['num_login_fail'] >= $maxAttemps){
        if(time() - $_SESSION['last_login_time'] < 30 ){
            displayAlert("Still on the time out");
            endTimer();
            logData("Login - Timeout - Attempt",$user,'0');
            die();
        }
    }
    //Log In check
    if(checkInput($user) == TRUE && checkInput($pass) == TRUE){
        $query = "SELECT * FROM `users`";
        $query = $conn->query($query);
        if ($query->num_rows > 0){
            while($row = $query->fetch_assoc()){
                if(strcmp($row['Username'], $user) == 0){
                    if(strcmp($row['Password'],hashFunction($pass,$row['Salt'])) == 0){
                        displayAlert("Welcome $user");
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
            displayAlert("No Users");
        }
    }
    $_SESSION['num_login_fail']++;
    $_SESSION['last_login_time'] = time();
    displayAlert("Wrong Details Entered. Username: '$_POST[Username]', Password: '$_POST[Password]'");
    if($_SESSION['num_login_fail'] >= $maxAttemps){
        if(time() - $_SESSION['last_login_time'] < 60*60 ){
            logData("Max attempt reached",$user, '0');
            displayAlert("Access Blocked for 3 min");
        }else{
            // $_SESSION['num_login_fail'] = 0;
            displayAlert("Access Restored");
        }
    }
}//DONE

function checkInput($input){
    if($input == ""){
        return FALSE;
    }
    $checkArray = ["<",">", "/", "//"];
    foreach($checkArray as $item){
        if(strpos($input, $item) == TRUE){
            return FALSE;
            die();
        }
    }
    return TRUE;
}//DONE

function changePass($oldPass, $newPass) {
    include "code/connector.php";
    //Check Input
    if(checkInput($newPass) == FALSE || checkInput($oldPass) == FALSE){
        displayAlert("Wrong Input");
        die();
    }
    //Check old pass
    $id = $_SESSION['ID'];
    $query = "SELECT * FROM `users` WHERE `ID` = '$id' ";
    $acc = $conn->query($query)->fetch_assoc();
    if(!(strcmp($acc['Password'],hashFunction($oldPass, $acc['Salt']) == 0 ))){
        displayAlert("Wrong Password");
        die();
    }
    $query = $conn->query($query);
    $salt = generateSalt();
    $newPass = hashFunction($newPass,$salt);
    $query = "UPDATE `users` SET `Password` = '$newPass' WHERE `users`.`ID` = '$id';";
    $conn->query($query);
    $query = "UPDATE `users` SET `Salt` = '$salt' WHERE `users`.`ID` = '$id';";
    $conn->query($query);
    displayAlert("Password Changed");
    //Log out
    include "logOut.php";
}

function showAllLogs() {
    include "connector.php";
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
        $output = $output . "No Logs? - Impossible!";
    }
    return $output;
}//Done

function generateSalt(){
    //Genius Salt creation - Do not question it please.
    //Shuffles the string, then cuts out a random snippit
    $salt = substr(str_shuffle("SomeSaltsShouldNeverBeTemperedWith"),rand(10,32));
    return $salt;
} // Done

function hashFunction($data, $salt){
    include "variables.php";
    //First add salt to the password
    $hash = hash( $hashAlgorithm ,$salt . $data);

    return $hash;
}
?>