<?php
    /*************************************************************************/
    include_once("dbLogin.php");
    include_once("sqlconnector.php");
	echo "<link rel='stylesheet' href='signUpComplete.css' type='text/css' />";
	session_start();
    //error_reporting(0);
	
    $body = "";
    $host = "localhost";
	$dbuser = "user";
	$dbpassword = "user";
	$database = "calendapp";
	$table = "users";
	$connector = new SQLConnector(new Credentials($host, $dbuser, $dbpassword, $database));
	$connector->connect();
	
    $UserName = $_SESSION['username'];
	$UserEmail = $_SESSION['email'];
	
	$UserProPic = $connector->retrieve("select profilepic from users where email='$UserEmail'")['profilepic'];

	if ($UserProPic == null) {
		$UserProPic = 'default.jpg';
	} else {
		$UserProPic = "profilepics/".$UserProPic;
	}
	
    if (isset($_POST["Return"])) {
        header('Location: main.php');
    
    }
	//$cred = new Credentials("localhost", "user", "user", "calendapp"); //update these to real values once we make the db
    //$connection = new SQLConnector($cred);
    //$connection->connect();
   
    //$query = "insert into users (name, email, propic, password) values ('$UserName', '$UserEmail','$UserProPic', '$UserPassword')");				
	//$this->connector->insert($query);
	
   /*************************************************************************/
    $scriptName = $_SERVER["PHP_SELF"];
    

	echo "
	     <html>
            <head> 
               <meta http-equiv='Content-Type' content='text/html; charset=UTF-8' /> 
		       <title>Sign Up Complete</title>
               <link rel='stylesheet' href='signUpComplete.css' type='text/css' />
	       </head>
		   <body>
		        <div id='subtitle'>
                   <img src='img/welcome.png' alt='Sign Up' id='signt'>
                </div>
             
				<form action='$scriptName' method='post' id='form'>
				    <h2>You can now start posting and uploading pictures of the events around campus!</h2>
					<h3> To begin just go to the home page and click on the 'Post' button.<br /> If
					you feel like browsing, just look thorugh the calendar.</h3>
					<p>
						Username: $UserName</br><br>
						Email: $UserEmail</br><br>
						Profile Picture: <br><img src='$UserProPic' alt='photo' width='200' height='200'/></br>
					</p>
					</br>
					<p>
					<input type='submit' name='Return' value = 'Go to home page! 'id='join' />
					</p>
				</form>
				 <div id='sub'>
                   <img src='img/welcomeextra.png' alt='Sign Up' id='extra'>
                </div>
			</body>
		</html>";
	

?>
