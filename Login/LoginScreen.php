<?php

  session_start();
  
  if (isset($_POST["Login"])) {
	 //Change user,password,database, and table with correct ones//
	 $host = "localhost";
	 $user = "dbuser";
	 $password = "goodbyeWorld";
	 $database = "Users";
	 $table = "usernames";
	 $db = connectToDB($host, $user, $password, $database);
     
	 //Change salt after we know how the password is stored//
	 $username = trim($_POST["username"]);
	 //$password = crypt($_POST["password"], 'st');
	 
	 $sqlQuery = sprintf("select username from %s where username='%s'", $table, $username);
	 $result = mysqli_query($db, $sqlQuery);
	 
	 
	 if ($result) {
		$numberOfRows = mysqli_num_rows($result);
		  if ($numberOfRows == 0) {
				echo "Whoops! Seems like you haven't signed up yet! Click below to sign up!";
		  } else {
	         while ($recordArray = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
		     	$User = $recordArray['username'];
				    if ($User === $username) {
						$_SESSION['username'] = trim($_POST['username']);
						//header('Location: main.php');
					} else {
					   echo "Whoops! Seems like you haven't signed up yet! Click below to sign up!".mysqli_error($db);
					}
				}
		  }
	 }
	 mysqli_close($db);
  } if (isset($_POST["Sign Up"])) {
	 echo "this shows up";
     //header('Location: signUp.php');
  }
  
  /**********************************************************************/
  function connectToDB($host, $user, $password, $database) {
    $db = mysqli_connect($host, $user, $password, $database);
	  if (mysqli_connect_errno()) {
		  echo "Connect failed.\n".mysqli_connect_error();
		  exit();
	  }
	  return $db;
	}
  /**********************************************************************/
?>

<html>
    <head> 
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /> 
		<title>Login Screen</title>
        <link rel="stylesheet" href="Login.css" type="text/css" />
	</head>

	<body>    
        <header>
        <div class = "container">  
        <img id = logo src="CalendAppLogo.png" alt="CalendApp Logo" /></br>
        </header>
		</div>
        
        <div class = "form">
        <?php
		$body = ""; 
        $scriptName = $_SERVER["PHP_SELF"];
        $username = "";
        $password = "";
        
        echo "<form action='$scriptName' method='post'>
			<p>
                <input type='text' placeholder='Username' name='username' value ='$username'/>
                <input type='password' placeholder='Password' name='password' value ='$password'/>
                </br>
                </br>
			
                <input id = login type='submit' name = 'Login' value = 'Login'/>
                </br>
                </br>
				<p>New to CalendApp? Sign Up today!</p>
				<input id = sign type='submit' name = 'Sign Up' value='Sign Up' />           
			</p></br>
		</form>";
        ?>
        </div>
        
   </body>
</html>