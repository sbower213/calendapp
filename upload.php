<?php
    require_once("support.php");
    require_once("uploadimage.php");
	require_once("dbLogin.php");
    
	session_start();
	
    $body =<<<BODY
     <form action="upload.php" enctype="multipart/form-data" method="post">
      <p>
   	     <b>Enter image to upload: </b>
   	     <input type="file" name="filename" required="required" /><br />
		 <strong>Caption: </strong><input type="text" required="required" name="caption" /><br />
		 <strong>Tags (comma separated): </strong><input type="text" id='tags' name="tags" required="required" /><br />
   	     <input type="submit" name='submit' value="Post" />
      </p>
      
      </form>
BODY;

    echo generatePage($body);
	$iw = new ImageWorker(new Credentials("localhost", "user", "user", "calendapp"));
	
	if (isset($_POST['submit'])) {
		if (isset($_SESSION['username'])) {
			$username = $_SESSION['username'];
		} else {
			$username = "test";
		}
		$tags = $_POST['tags'];
		$caption = $_POST['caption'];
		
		if ($id = $iw->uploadImage($username, $tags, $caption)) {
			echo "Successful upload with id $id"; //Placeholder
		} else {
			echo "Unsuccessful upload";
		}
	}
?>

<script>
	window.onsubmit = validateForm;
	
	function validateForm() {
		var tags = document.getElementById("tags").value;
		var re = /,\s\w|,\w/;
		
		if (!re.test(tags)) {
			alert("Please enter at least two tags.");
			return false;
		} else {
			return true;
		}
	}
</script>