<?php
include_once '../config/database.php';

// required headers
header('Content-Type: application/json');
include_once '../object/cart.php';

// initialize database
$database = new Database();
$db = $database->getConnection();

$cart = new Cart($db);

   
if ($products = $cart->getCartProducts())
{
	//print_r($products);
        // set response code - 503 service unavailable
        http_response_code(200);
        // tell the user
        echo json_encode($products);
    
}

// if unable to create the product, tell the user
else
{
    // set response code - 503 service unavailable
    http_response_code(400);
    // tell the user
    echo json_encode(array ("message" => "Product is already added", "Product Added" => false));
}

?>