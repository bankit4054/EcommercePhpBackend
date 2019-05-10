<?php
include_once '../config/database.php';
include_once '../object/products.php';

// initialize database
$database = new Database();
$db = $database ->getConnection();
//initialize product object
$product = new Product($db);
// query user
$stmt = $product-> getProductDetail();
$num = $stmt ->rowCount();
// check if more than 0 record found
if($product->product_id!=null){
    // create array
    $products_arr = array(
        "product_id" =>  $product->product_id,
        "product_title" => $product->product_title,
        "product_description" => $product->product_description,
        "product_price" => $product->product_price,
        "product_image" => $product->product_image,
        "product_rating"=>$product->product_rating
    ); 
    // set response code - 200 OK
    http_response_code(200); 
    // make it json format
    echo json_encode($products_arr);
} 
else{
    // set response code - 404 Not found
    http_response_code(404); 
    // tell the user product does not exist
    echo json_encode(array("message" => "product does not exist."));
}