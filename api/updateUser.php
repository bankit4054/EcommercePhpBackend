<?php
include_once '../config/database.php';
// required headers
header('Content-Type: application/json');
include_once '../object/user.php';

// initialize database
$database = new Database();
$db = $database->getConnection();

$user = new User($db);
if ($user->updateUser())
{
    // set response code - 201 created
    http_response_code(201);
    // tell the user
    echo json_encode(array ("message" => "user was updated."));
}
// if unable to create the product, tell the user
else
{

    // set response code - 503 service unavailable
    http_response_code(503);

    // tell the user
    echo json_encode(array ("message" => "Unable to update user."));
}

?>