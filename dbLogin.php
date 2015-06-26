<?php
class Credentials {
    public $host;
	public $user;
	public $password;
	public $database;
    
    function __construct($host, $user, $password, $database) {
        $this->host = $host;
        $this->user = $user;
        $this->password = $password;
        $this->database = $database;
    }
}
?>