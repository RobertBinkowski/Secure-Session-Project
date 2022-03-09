<?php 

// Error Check
function queryDatabase($query){
    $servername = "localhost";
    $username = "root";
    $password = ""; // Unbrakable passowrd here xD
    $dbname = "secure-app-project";
    $conn = new mysqli($servername, $username, $password,$dbname);
    try{
        if ($conn->query($query) === TRUE) {
            logData("Database Query: $query");
          }
    } catch(Throwable $th){
        logData($th->getMessage());
    }
}

function logData($action){
    $query = "";
    try{
        queryDatabase($query);
    }catch(Throwable $th){
        echo $th->getMessage();
    }
}

function checkInput($input){
    if($input == ""){
        die("error");
    }
    
    return $input;
}


function getDetails($sqlQuery){
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

function checkDetails($username, $password) {
    $data = getDetails("SELECT * FROM `users`");

}


function hashFunction($data, $hash){

}
?>