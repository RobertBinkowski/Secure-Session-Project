<?php 

// Error Check
function queryDatabase($query){
    include "connector.php";
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

function checkDetails($username, $password) {
    $data = getDetails("SELECT * FROM `users`");

}

function generateSalt(){
    $salt = random_bytes(10);
    return $salt;
} // Done

function hashFunction($data, $salt){
    $hash = $data + $salt;

    //create a hash function here

    return $hash;
}
?>