<?php
  session_start();
  
  require_once("dbLogin.php");
  require_once("sqlconnector.php");
  
  if (isset($_POST["Login"])) {
	 $host = "localhost";
	 $dbuser = "user";
	 $dbpassword = "user";
	 $database = "calendapp";
	 $table = "users";
	 $connector = new SQLConnector(new Credentials($host, $dbuser, $dbpassword, $database));
	 $connector->connect();
	 $warning = "";
	 
	 $username = trim($_POST["username"]);
	 $sqlQuery = sprintf("select name, password from %s where name='%s'", $table, $username);
	 
	 if (!($result = $connector->retrieve($sqlQuery))) {
		$warning = "Whoops! Seems like you haven't signed up yet! Click below to sign up! (username not found)";
	 } else {
		if (password_verify($_POST['password'], $result['password'])) {
		  $warning = "Logged in!";
		  $_SESSION['loggedIn'] = true; //Stay logged in
		  $_SESSION['username'] = $username;
		  
		  header("Location: main.php");
		} else {
		  $warning = "Wrong password!";
		}
	 }
  }
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
        <img id = logo src="img/CalendAppLogo.png" alt="CalendApp Logo" /></br>
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
                <input type='text' placeholder='Username' required='required' name='username' value ='$username'/>
                <input type='password' placeholder='Password' required='required' name='password' value ='$password'/>
				";
				if (isset($warning)) { //Print warning
				  echo "<br />".$warning;
				}
                echo "</br>
                </br>
			
                <input id = 'login' type='submit' name = 'Login' value = 'Login'/>
                </br>
                </br>
				<p>New to CalendApp? Sign Up today!</p>
				</form>
				<form action='signup2.php' method='post'>
				<input id= 'sign' type='submit' name='signup' value='Sign Up' />
				</form>
			</p></br>
		";
        ?>
        </div>
   </body>
</html>