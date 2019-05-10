<?php
class Review
{
    // database connection and table name
    private $conn;

    // object properties
    public $review_reviewerName;
    public $review_image;
    public $review_comment;
    public $review_productId;
    public $review_id;

    // constructor with $db as database connection
    public function __construct($db)
    {
        $this->conn = $db;
    }

    //insert review data into databse 
    function addReview()
    {
        $success = false;
        $message = '';
  
        $this->review_reviewerName = $_POST["name"];
       // $this->review_image = $_FILES['image']['name'];

       if (($_FILES['image']['name']!="")){
        // Where the file is going to be stored
            $target_dir = "data/";
            $file = $_FILES['image']['name'];
            $path = pathinfo($file);
            $filename = $path['filename'];
            $ext = $path['extension'];
            $temp_name = $_FILES['image']['tmp_name'];
            $path_filename_ext = $target_dir.$filename.".".$ext;
         
        // Check if file already exists
        if (file_exists($path_filename_ext)) {
            $message = "Sorry, file already exists.";
         }
         else {
            move_uploaded_file($temp_name, $path_filename_ext);
            $message = "Congratulations! File Uploaded Successfully.";
            $success = true;
         }
        }
  $resp = new stdClass();
  $resp->success = $success;
  $resp->message = $message;
  $resp->path = $path;
  $resp->temp_name = $temp_name;
  $resp->path_filename_ext = $path_filename_ext;
  
  // Insert this  'path_filename_ext' in the database 
  //echo json_encode($resp);

        //$imgContent = addslashes(file_get_contents($this->review_image));
        $this->review_comment = $_POST["comment"];
        $this->review_productId = $_POST["productId"];
        $this->review_reviewerName=$_POST["name"];
        
        $query = "INSERT INTO product_review (review_reviewer_name,review_image,review_comment,review_productId)
        VALUES( :name, :image, :comment, :productId)";
         echo($this->review_comment);
         echo($this->review_productId);
         echo($this->review_reviewerName);
         echo($path_filename_ext);
        echo($query);
       
        // prepare query
        $stmt = $this->conn->prepare($query);
        // bind values
        $stmt->bindParam(":name", $this->review_reviewerName);
        $stmt->bindParam(":image", $path_filename_ext);
        $stmt->bindParam(":comment", $this->review_comment);
        $stmt->bindParam(":productId", $this->review_productId);
        // execute query
        if ($stmt->execute())
        {
            echo ("Query executed");
            return true;
        }
        return false;
    }
    //get list of review of a product
    function getReviewListbyId()
    {
        $this->review_productId = $_POST["productId"];
        $query = "SELECT * FROM product_review WHERE
                review_productId = '$this->review_productId'";
        // prepare query statement
        $stmt = $this->conn->prepare($query);
        // bind id of product to be updated
        $stmt->bindParam(":productId", $this->review_productId);
        // execute query
        $stmt->execute(); 
        return $stmt;
    }
}
?>