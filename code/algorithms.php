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
    $_SESSION["Username"] = $username;
    header("Location:dashboard.php");
}//DONE

function displayAlert($alert){
    echo "<script>alert('$alert')</script>";
}//DONE

function logInCheck($user, $pass){
    include "code/connector.php";
    $query = "SELECT * FROM `users`";
    $query = $conn->query($query);
    if ($query->num_rows > 0){
        while($row = $query->fetch_assoc()){
            if(strcmp($row['Username'], $user) == 0){
                if(strcmp($pass,deHashFunction($row['Password'],$row['Salt'])) == 0){
                    displayAlert("Welcome $user");
                    $_SESSION['num_login_fail'] = 0;
                    $_SESSION['Username'] = $user;
                    header("Location:dashboard.php");
                }
                break;
            }
        }
    }else{
        displayAlert("No Users");
    }
}//DONE

function checkInput($input){
    if($input == ""){
        return FALSE;
    }
    return TRUE;
}


function getDetails($sqlQuery){
    include "connector.php";
    $result = $conn->query($sqlQuery);
    //Catch neferious actions
    try {
        if ($result->num_rows > 0){
            return $result;
        }else{
            die("Error");
        }
    } catch (Throwable $th) {
        die("Error");
    }
}

function changePass($user, $newPass) {
    include "code/connector.php";
    $query = "SELECT * FROM `users` WHERE `Username` LIKE '$user'";
    $query = $conn->query($query);
    $query = "UPDATE `users` SET `Password` = '$newPass' WHERE `users`.`ID` = 2;";

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

function deHashFunction($data, $salt){
    //dehash it here - Not Done


    //Remove Salt by removing teh salt by it's length
    $deSalted = substr($data, strlen($salt));
    return $deSalted;
}

function hashFunction($data, $salt){
    //First add salt to the password
    $hash = $salt . $data;

    //create a hash function here
    //So you can be decripted?
    //Single Hash Function

    return $hash;
}
?>