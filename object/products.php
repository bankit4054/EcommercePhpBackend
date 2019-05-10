<?php
class Product{ 
    // database connection and table name
    private $conn; 
    // object properties
    public $product_id;
    public $product_title;
    public $product_description;
    public $product_rating;
    public $product_price;
    public $product_image; 
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }
    // read products
    function read(){ 
    // select all query
    $query = "SELECT * 
            FROM products"; 
    // prepare query statement
    $stmt = $this->conn->prepare($query); 
    // execute query
    $stmt->execute(); 
    
	return $stmt;
    }
    //get product details
    function getProductDetail()
    {
        $this->product_id = $_POST["productId"];
        $query = "SELECT * FROM products WHERE
                product_id = $this->product_id ";
        // prepare query statement
        $stmt = $this->conn->prepare($query);
        // bind id of user 
        $stmt->bindParam(":productId", $this->product_id);
        // execute query
        $stmt->execute();
        // get retrieved row
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        // set values to object properties
		
        $this->product_id = (int)$row['product_id'];
        $this->product_title = $row['product_title'];
        $this->product_price = (int)$row['product_price'];
        $this->product_description = $row['product_description'];
        $this->product_image = $row['product_img'];
        $this->product_rating= (int)$row['product_rating'];
        return $stmt;

    }
}
