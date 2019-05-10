<?php
include_once '../config/database.php';
include_once '../object/user.php';

// initialize database
$database = new Database();
$db = $database ->getConnection();
//initialize product object
$user = new User($db);
// query user
$stmt = $user-> getUserDetails();
$num = $stmt ->rowCount();
// check if more than 0 record found
if($user->cust_name!=null){
    // create array
    $user_array = array(
        "id" =>  $user->cust_id,
        "name" => $user->cust_name,
        "email" => $user->cust_email,
        "address" => $user->cust_address,
        "city" => $user->cust_city 
    ); 
    // set response code - 200 OK
    http_response_code(200); 
    // make it json format
    echo json_encode($user_array);
} 
else{
    // set response code - 403 Not found
    http_response_code(403); 
    // tell the user product does not exist
    echo json_encode(array("message" => "user does not exist."));
}