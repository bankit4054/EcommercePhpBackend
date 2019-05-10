<?php
include_once '../config/database.php';
// required headers
header('Content-Type: multipart/form-data');

include_once '../object/review.php';

// initialize database
$database = new Database();
$db = $database->getConnection();

$review = new Review($db);

if ($review->addReview())
{
    // set response code - 201 created
    http_response_code(201);
    // tell the user
    echo json_encode(array ("message" => "review added successfully."));
}

// if unable to add  the review, tell the user
else
{

    // set response code - 503 service unavailable
    http_response_code(503);

    // tell the user
    echo json_encode(array ("message" => "Unable to add review."));
}

?>