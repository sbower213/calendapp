<?php
    require_once("support.php");
    require_once("uploadimage.php");
	require_once("dbLogin.php");
    
	session_start();
	
	if (isset($_SESSION['username'])) {
		$user = $_SESSION['username'];
	} else {
		$user = "NO_USER";
	}
	
    $body =<<<BODY
	 <html>
	   <head>
	     <title>Upload</title>
		 <link rel='stylesheet' href='upload.css' type='text/css' />
	   </head>
       <body>
	        <a href="main.php"> <img src="img/CalendAppLogo.png" width="256" height="73" alt="CalendApp" id="logo"> </a>
	        <div id='subtitle'>
                <img src='img/upload.png' alt='Upload' id='subtitle'>
            </div>
			<form action="upload.php" enctype="multipart/form-data" method="post" id='form'>
			<h3> Select an image that you would lke to upload. Include a caption and at least two tags.</h3>
				 <p>
					Enter image to upload (as user $user): &nbsp;
					<input type="file" name="filename" required="required" /><br />
					Caption: &nbsp; <input type="text" required="required" name="caption" /><br />
					Tags (comma separated): &nbsp; <input type="text" id='tags' name="tags" required="required" /><br />
					<br>
					<input type="submit" name='submit' value="Post" id='post'/>
				</p>   
		   </form>
	   </body>
	  </html>

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
			//echo "Successful upload with id $id"; //Placeholder
			echo "<script> alert('Successfully uploaded image!')</script>";
			
			header("Location: main.php");
		} else {
			echo "<script> alert('Upload failed.')</script>";
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