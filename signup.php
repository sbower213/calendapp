<?php
    require_once("support.php");
    require_once("dbLogin.php");
    require_once("sqlconnector.php");
    
    session_start();
    echo "Sign up (placeholder)<br />";
    
    if (isset($_POST['submit'])) {
        $host = "localhost";
        $dbuser = "user";
        $dbpassword = "user";
        $database = "calendapp";
        $table = "users";
        $connector = new SQLConnector(new Credentials($host, $dbuser, $dbpassword, $database));
        $connector->connect();
        
        
        $username = trim($_POST["username"]);
        $email = trim($_POST['email']);
        $cryptpw = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $date = date(DATE_ISO8601);
        $sqlQuery = "insert into users values('$username', '$cryptpw', 'temp', '$date', '$email')";
        echo $sqlQuery."<br />";
        
        if ($connector->insert($sqlQuery)) {
            $_SESSION['loggedIn'] = true; //Stay logged in
            $_SESSION['username'] = $username;
            
            header("Location: main.php");
        }
    }
    $body =<<<BODY
    <form action="signup.php" method="post">
    Username: <input type="text" name="username" required="required"><br />
    Password: <input type="password" name="password" required="required"><br />
    Email: <input type="email" name="email" required="required"><br />
    <input type="submit" name="submit" value="Sign Up"><br />
    <input type="reset" name="reset" value="Reset">
</form>
BODY;

    echo generatePage($body, "Sign Up");
?>
