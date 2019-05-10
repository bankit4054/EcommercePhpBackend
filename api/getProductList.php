<?php
include_once '../config/database.php';
include_once '../object/products.php';

// initialize database
$database = new Database();
$db = $database ->getConnection();
//initialize product object
$product = new Product($db);
// query products
$stmt = $product-> read();
$num = $stmt ->rowCount();
// check if more than 0 record found
if($num>0){
   // product array
   $products_arr = array();
   $products_arr["products"] = array();   
   // retrieve data from database
   while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
    // extract row
    // this will make $row['name'] to
    // just $name only
    extract($row);
	
    $product_item=array(
        "product_id" => (int)$product_id,
        "product_title" => $product_title,
        "product_description" => $product_description,
        "product_rating" => (int)$product_rating,
        "product_price" => (int)$product_price,
        "product_image" => $product_img
    );

    array_push($products_arr["products"], $product_item);
}

// set response code - 200 OK
http_response_code(200);

// show products data in json format
echo json_encode($products_arr);
}
else{ 
    // set response code - 404 Not found
    http_response_code(404); 
    // tell the user no products found
    echo json_encode(
        array("message" => "No products found.")
    );
}