<?php
    require_once("dbLogin.php");
	require_once("sqlconnector.php");
	require_once("uploadimage.php");
    echo "<link rel='stylesheet' href='signUp.css' type='text/css' />";
   
    session_start();
    //error_reporting(0);
	
    if (isset($_POST["Submit"])) {
        if ( $_POST['password'] !== $_POST['vpassword']) {
            echo "<script> alert('Whoops! Seems like your passwords don't match.')</script>";
			$name = $_POST['name'];
			$email = $_POST['email'];
        } else {
			$host = "localhost";
			$dbuser = "user";
			$dbpassword = "user";
			$database = "calendapp";
			$table = "users";
			$connector = new SQLConnector(new Credentials($host, $dbuser, $dbpassword, $database));
			$connector->connect();

			$w = new ImageWorker(null); //no sql here
			$id = $w->uploadToDir("/profilepics", "photo"); //Upload profile picture

			$username = trim($_POST["name"]);
			$email = trim($_POST['email']);
			$cryptpw = password_hash($_POST['password'], PASSWORD_DEFAULT);
			$date = date(DATE_ISO8601);
			$sqlQuery = "insert into users values('$username', '$cryptpw', '$id', '$date', '$email')";
			
			if ($connector->insert($sqlQuery)) {
				$_SESSION['loggedIn'] = true; //Stay logged in
				$_SESSION['username'] = $username;
				$_SESSION['email'] = $email;
			}

			header('Location: signUpComplete.php');
        }
        
    } else {
		$name = "";
		$email = "";
        $photo = 'img/default.jpg';
		
    }
     $photo = 'img/default.jpg';
   /*************************************************************************/
    $scriptName = $_SERVER["PHP_SELF"];
    
  echo "<html>
            <head> 
               <meta http-equiv='Content-Type' content='text/html; charset=UTF-8' /> 
		       <title>Sign Up</title>
               <link rel='stylesheet' href='signUp.css' type='text/css' />
	       </head>
      
      <body>
           <div id='title'>
           <img src='img/CalendAppLogo.png' alt='Sign Up' id='sign'>
           </div>
	      
          <div id='subtitle'>
           <img src='img/signup.png' alt='Sign Up' id='signt'>
           </div>
           
           <form action='$scriptName'method='post' enctype='multipart/form-data' id='form'>
		  <p>
			Username: <br>
            <input type='text' name='name' value='$name' required/>
		  </p>			
		  <p>
            Email: <br>
            <input type='email' name='email' value='$email' required/>
		  </p>
          <p>
            Profile Picture: <br> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <input type='file' name='photo' value='$photo' placeholder='$photo'/><br>
            <img src= '$photo' alt='photo' width='200' height='200'/></br>
          </p>
          <p>
            Password: <br><input type='password' name='password' required/>
		  </p>
          <p>
            Verify Password: <br><input type='password' name='vpassword' required/>
		  </p>       
		  <p>
            <input type='submit' name='Submit' value = 'Join!' id='join'/>
            </br>
		  </p>
	      </form>
	</body>

    </html>";
?>
