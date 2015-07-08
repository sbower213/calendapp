<?php
    require_once("uploadimage.php");
	require_once("dbLogin.php");
    
    session_start();
    
    $CurrentUserName = "TestName";
    $CurrentEmail ="";
    $DateJoined ="3/4/14";
    $ProPic="default.jpg";
    $NewImage ="";
    
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
             
             <form action='upload.php' enctype='multipart/form-data' method='post' id='form'>
               <img src='$ProPic' alt = 'Profile Picture' height='400' width='400' id='propic'/>
                  <p id='upload'>
                     Upload New Profile Picture
                     <input type='file' name='filename'/><br />
                  </p>
               <h1>'$CurrentUserName'</h1>
                  <p>
                    Date Joined: '$DateJoined'
                  </p>
             </form> 
           </body>
        </html>";
?>