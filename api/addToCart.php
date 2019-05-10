<?php
include_once '../config/database.php';

// required headers
header('Content-Type: application/json');
include_once '../object/cart.php';

// initialize database
$database = new Database();
$db = $database->getConnection();

$cart = new Cart($db);
// $cart->updateQuantity()
if (!$cart->isProductExists())
{
    if ($cart->addProductToCart()) {
        // set response code - 201 created
        http_response_code(201);
        // tell the user
        echo json_encode(array ("message" => "Product was added.", "ProductAdded" => true));
    } else {
        // set response code - 503 service unavailable
        http_response_code(400);
        // tell the user
        echo json_encode(array ("message" => "Unable to add product", "ProductAdded" => false));
    }
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