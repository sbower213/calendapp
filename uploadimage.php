<?php
    require_once("support.php");
    require_once("sqlconnector.php");
    
    class ImageWorker {
        private $connector;
        private $directory = "/images";
        private $tmpFileName;
        private $serverFileName;
        
        function __construct($loginInfo) {
            if (isset($loginInfo)) { //null check
                $this->connector = new SQLConnector($loginInfo);
                $this->connector->connect();
            }
        }
        
        function uploadImage($user, $tags, $caption) {
            define ('SITE_ROOT', realpath(dirname(__FILE__)));
            $tmpFileName = $_FILES['filename']['tmp_name'];
            $date = date(DATE_ISO8601);
            $id = hash("md5", $tmpFileName.$date);
            $ext = pathinfo($_FILES['filename']['name'], PATHINFO_EXTENSION);
            $serverFileName = $this->directory."/".$id.".".$ext;
            
            if (!is_uploaded_file($tmpFileName)) {
                return false;
            } else {
                if (!move_uploaded_file($tmpFileName, SITE_ROOT.$serverFileName))
                    return false;
                else { //Successful upload, add to db
                    $query = "insert into photos (user, date, tags, caption, id) values('$user', '$date', '$tags', '$caption', '$id')";
                    $this->connector->insert($query);
                    return $id;
                }
            }
        }
    }
?>