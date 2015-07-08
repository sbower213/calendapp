<?php
    require_once("uploadimage.php");
	require_once("dbLogin.php");
	require_once("sqlconnector.php");
    
    session_start();
    
	if (isset($_SESSION['username'])) {
		$CurrentUserName = $_SESSION['username'];
	} else {
		$CurrentUserName = "NO_USER";
	}
	
	$host = "localhost";
	$dbuser = "user";
	$dbpassword = "user";
	$database = "calendapp";
	$table = "users";
	$connector = new SQLConnector(new Credentials($host, $dbuser, $dbpassword, $database));
	$connector->connect();
    $CurrentEmail ="";
    $DateJoined = $connector->retrieve("select joined from users where name='{$_SESSION['username']}'")['joined'];
	
	if (isset($_POST['submit'])) {
		$w = new ImageWorker(null); //no sql here
		$id = $w->uploadToDir("/profilepics", "filename");
		
		$connector->insert("update users set profilepic='$id' where name='{$_SESSION['username']}'");
	}
	
	$ProPic = "profilepics/".$connector->retrieve("select profilepic from users where email='{$_SESSION['email']}'")['profilepic'];
	
    echo "
       <html>
           <head>
              <title>Profile</title>
              <link rel='stylesheet' href='profile.css' type='text/css' />
           </head>
           <body>
             <a href='main.php'> <img src='img/CalendAppLogo.png' width='256' height='73' alt='CalendApp' id='logo'> </a>
             <div id='subtitle'>
                <img src='img/Pro.png' alt='Profile' id='subtitle'>
             </div>
             
             <form action='profile.php' enctype='multipart/form-data' method='post' id='form'>
			 <h1>$CurrentUserName</h1>
               <img src='$ProPic' alt = 'Profile Picture' id='propic'/>
			   <p>
                    Date Joined: $DateJoined
                </p>
                  <p id='upload'>
                     Upload New Profile Picture
                     <input type='file' name='filename'/><br /><input type='submit' name='submit' value='Upload'>
                  </p>
               
                  
             </form> 
           </body>
        </html>";
?>
