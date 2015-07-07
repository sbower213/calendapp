<?php
    
    echo "<link rel='stylesheet' href='signUp.css' type='text/css' />";
   
    session_start();
    error_reporting(0);
	
    if (isset($_POST["Submit"])) {
        if ( $_POST['password'] !== $_POST['vpassword']) {
            echo "Whoops! Seems like your passwords don't match.";
        } else {
		$_SESSION['name'] = trim($_POST['name']);
		$_SESSION['email'] = trim($_POST['email']);
		$_SESSION['password'] = $_POST['password'];
        
        $file_name = $_FILES['photo']['name'];
        move_uploaded_file($file_tmp,"img/".$file_name);
        
        header('Location: signUpComplete.php');
        }
        
    } else {
		$name = "";
		$email = "";
        $password = "";
        $vpassword = ""; 
        $photo = 'default.jpg';
		
    }
     $photo = 'default.jpg';
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
            Password: <br><input type='password' name='password' value='$password' required/>
		  </p>
          <p>
            Verify Password: <br><input type='password' name='vpassword' value='$vpassword' required/>
		  </p>       
		  <p>
            <input type='submit' name='Submit' value = 'Join!' id='join'/>
            </br>
		  </p>
	      </form>
	</body>

    </html>";

?>