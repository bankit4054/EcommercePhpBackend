<?php
include_once '../config/database.php';

// required headers
header('Content-Type: application/json');
include_once '../object/cart.php';

// initialize database
$database = new Database();
$db = $database->getConnection();

$cart = new Cart($db);
// initialize database
$database = new Database();
$db = $database ->getConnection();

if ($cart->removeFromCart()){
    http_response_code(200); 
} 
else{
    http_response_code(400); 
}