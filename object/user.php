<?php
class User
{
    // database connection and table name
    private $conn;
    private $table_name = "customer";

    // object properties
    public $cust_id;
    public $cust_name;
    public $cust_email;
    public $cust_password;
    public $cust_address;
    public $cust_city;

    // constructor with $db as database connection
    public function __construct($db)
    {
        $this->conn = $db;
    }

    //insert user data into databse 
    function addUser()
    {
        $this->cust_name = $_POST["name"];
        $this->cust_email = $_POST["email"];
        $this->cust_password = $_POST["password"];
        $this->cust_address = $_POST["address"];
        $this->cust_city = $_POST["city"];

        $query = "INSERT INTO customer (cust_name,cust_email,cust_password,cust_address,cust_city)
        VALUES(:name, :email, :password, :address, :city)";
        echo $query;


        // prepare query
        $stmt = $this->conn->prepare($query);
        // bind values
        $stmt->bindParam(":name", $this->cust_name);
        $stmt->bindParam(":email", $this->cust_email);
        $stmt->bindParam(":password", $this->cust_password);
        $stmt->bindParam(":address", $this->cust_address);
        $stmt->bindParam(":city", $this->cust_city);
        // execute query
        if ($stmt->execute())
        {
            echo ("Query executed");
            return true;
        }
        return false;
    }
	
	function updateUser()
    {
		$this->cust_id = $_POST["id"];
        $this->cust_name = $_POST["name"];
        $this->cust_email = $_POST["email"];
        $this->cust_password = $_POST["password"];
        $this->cust_address = $_POST["address"];
        $this->cust_city = $_POST["city"];

        $query = "UPDATE customer SET cust_name= '$this->cust_name' ,cust_email='$this->cust_email',cust_password='$this->cust_password',cust_address='$this->cust_address',cust_city='$this->cust_city' WHERE cust_id = '$this->cust_id'";
        
        // prepare query
        $stmt = $this->conn->prepare($query);
        // bind values
        
        if ($stmt->execute())
        {
            return true;
        }
        return false;
    }
	
    //get User details
    function getUserDetails()
    {
        $this->cust_email = $_POST["email"];
        $this->cust_password=$_POST["password"];
        $query = "SELECT * FROM customer WHERE
                cust_email = '$this->cust_email' AND cust_password = '$this->cust_password' ";
        // prepare query statement
        $stmt = $this->conn->prepare($query);
        // bind id of user 
        $stmt->bindParam(":email", $this->cust_email);
        $stmt->bindParam(":password", $this->cust_password);
        // execute query
        $stmt->execute();
        // get retrieved row
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        // set values to object properties
        $this->cust_id = (int)$row['cust_id'];
        $this->cust_name = $row['cust_name'];
        $this->cust_email = $row['cust_email'];
        $this->cust_address = $row['cust_address'];
        $this->cust_city = $row['cust_city'];
        return $stmt;

    }
}
?>