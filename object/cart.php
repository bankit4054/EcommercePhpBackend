<?php
class Cart
{
    // database connection and table name
    private $conn;
    private $table_name = "sales";

    // object properties
    public $salesId;
    public $fk_userid;
    public $fk_productid;
    public $quantity;

    // constructor with $db as database connection
    public function __construct($db)
    {
        $this->conn = $db;
    }
    
    //insert user data into databse 
    function addProductToCart()
    {
        $this->fk_userid = $_POST["userId"];
        $this->fk_productid = $_POST["productId"];
        $this->quantity = $_POST["quantity"];

        $query = "INSERT INTO sales (fk_userid, fk_productid, quantity) VALUES(:userId, :productId, :quantity)";

        // prepare query
        $stmt = $this->conn->prepare($query);
        // bind values
        $stmt->bindParam(":userId", $this->fk_userid);
        $stmt->bindParam(":productId", $this->fk_productid);
        $stmt->bindParam(":quantity", $this->quantity);
        // execute query
        if ($stmt->execute())
        {
            return true;
        }
        return false;
    }

    
    // check if product is exists
    function isProductExists()
    {
        $this->fk_userid = $_POST["userId"];
        $this->fk_productid = $_POST["productId"];
        $this->quantity = $_POST["quantity"];
	
        $query = "SELECT fk_productid FROM sales WHERE fk_userid = '$this->fk_userid'";
		
        // prepare query
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $data  = $stmt->fetchAll();
		
        foreach($data as $row) {
            if ($this->fk_productid == $row['fk_productid']) {
                return true;
            }
        }
		
        return false;
    }


    //get User details
    function updateQuantity()
    {
        $this->fk_userid = $_POST["userId"];
        $this->fk_productid = $_POST["productId"];
        $this->quantity = $_POST["quantity"];

        $query = "SELECT quantity FROM sales WHERE fk_userid = '$this->fk_userid' AND fk_productid = '$this->fk_productid'";

        // prepare query statement
        $stmt = $this->conn->prepare($query);
        
        // execute query
        $stmt->execute();

        // get retrieved row
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $num = $stmt ->rowCount();
        
        if ($num == 1) {
            
            $query = "UPDATE sales SET quantity = '$this->quantity' WHERE fk_userid = '$this->fk_userid' AND fk_productid = '$this->fk_productid'";
            
            $stmt = $this->conn->prepare($query);
            if ($stmt->execute())
            {
                return true;
            }
            return false;
        } 
        else {
            return false;
        }
    }
	
	function getCartProducts()
    {
        $this->fk_userid = $_POST["userId"];
	
        $query = "select sales.fk_userid, sales.fk_productid, sales.quantity, products.product_title, products.product_price
				from sales left join products 
				on sales.fk_productid = products.product_id 
				WHERE sales.fk_userid = '$this->fk_userid'";

        // prepare query statement\
        $stmt = $this->conn->prepare($query);
        
        // execute query
        $stmt->execute();	
		
		$products_arr["products"] = array();
	
		
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
			extract($row);
			$product_item=array(
				"product_id" => (int)$fk_productid,
				"product_title" => $product_title,
				"userid" => (int)$fk_userid,
				"quantity" => (int)$quantity,
				"product_price" => (int)$product_price
			);
	
			array_push($products_arr["products"], $product_item);
		}
		
        return $products_arr;
    }
	
	function removeFromCart() {
		$this->fk_userid = $_POST["userId"];
        $this->fk_productid = $_POST["productId"];

        $query = "DELETE FROM `sales` WHERE fk_userid = '$this->fk_userid' AND fk_productid = '$this->fk_productid'";

        // prepare query statement
        $stmt = $this->conn->prepare($query);
		
		// execute query
        if ($stmt->execute())
        {
            echo ("Product Removed");
            return true;
        }
        return false;
	}
}
?>