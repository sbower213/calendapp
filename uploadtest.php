<?php
    require_once("support.php");
    require_once("uploadimage.php");
	require_once("dbLogin.php");
    
    //$body =<<<BODY
	?>
     <form action="uploadtest.php" enctype="multipart/form-data" method="post">
      <p>
   	     <b>Enter image to upload: </b>
   	     <input type="file" name="filename" /><br />
   	     <input type="submit" name='submit' value="uploadImage" />
      </p>
      
      </form>

<?php
    echo generatePage($body);
	$iw = new ImageWorker(new Credentials("localhost", "user", "user", "calendapp"));
	
	if (isset($_POST['submit'])) {
		
		if ($id = $iw->uploadImage("test", "nothing", "hello world")) {
			echo "Successful upload with id $id";
		}
	}
?>