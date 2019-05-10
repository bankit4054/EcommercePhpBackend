<?php
  /*
    let success = false;
    if (req.files) {
        let file = req.files.file;

        try {
            await file.mv('data/filename.txt');
            success = true;
        } catch (err) {
        }
    }
    res.json({ "success": success });
  */
  $success = false;
  $message = '';
  
  /*
  $targetDir = "data/";
  $targetFile = @tempnam($targetDir, '');
  unlink($targetFile);
  */
  
  if (($_FILES['file']['name']!="")){
	// Where the file is going to be stored
		$target_dir = "uploads/";
		$file = $_FILES['file']['name'];
		$path = pathinfo($file);
		$filename = $path['filename'];
		$ext = $path['extension'];
		$temp_name = $_FILES['file']['tmp_name'];
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
  
  /*
  if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFile)) {
	$success = true;
  }
  */
  
  $resp = new stdClass();
  $resp->success = $success;
  $resp->message = $message;
  $resp->path = $path;
  $resp->temp_name = $temp_name;
  $resp->path_filename_ext = $path_filename_ext;
  
  // Insert this  'path_filename_ext' in the database

  echo json_encode($resp);
?>