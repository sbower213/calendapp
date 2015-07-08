<?php
    
    include_once("support.php");
    include_once("dbLogin.php");
    include_once("sqlconnector.php");
    
    session_start();
    echo "<link rel='stylesheet' href='main.css' type='text/css' />";
    echo "<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic,800,800italic' rel='stylesheet' type='text/css'>";
    echo "<link href='http://fonts.googleapis.com/css?family=Lobster' rel='stylesheet' type='text/css'>";
    
    if(isset($_POST['submitButton'])){
        
        $month = $_POST['month'];
        $year = $_POST['year'];
        
    } else {
        
        $month = date("F");
        $year = date("Y");
        
    }
    
    $cred = new Credentials("localhost", "user", "user", "calendapp"); //update these to real values once we make the db
    $connection = new SQLConnector($cred);
    $connection->connect();
    
    if (isset($_SESSION['username'])) {
        $user = $_SESSION['username'];
    } else {
        $user = "NO_USER";
    }
    
    $query = "select profilepic from users where name=\"$user\""; //this kind of assumes user is the primary key, could rework with email
    $profpic = "profilepics/".$connection->retrieve($query)['profilepic'];
    
    $numMonth = date('m', strtotime("$month"));
    $pics = $connection->retrieve("select * from photos where year(date) = '$year' and month(date) = '$numMonth'"); //Gets relevant pictures
    //print_r($pics); debugging
    $body =<<<HEREDOC
        
        <a href="main.php"> <img src="img/CalendAppLogo.png" width="256" height="73" alt="CalendApp" id="logo"> </a>
        <span id="calendarTitle">
            <h1>$month $year</h1>
        </span>
        <div id="profile">
            <img src='$profpic' alt=$user width='50' height='50'>
            Hello, $user!
            <br />
            <a href='profile.php'>Edit Profile</a> 
            <a href='upload.php'>Upload Photo</a>
            <a href='logout.php'>Logout</a>
        </div>
        <span id="sidebar">
            <form action="main.php" method="post" id="side">
                <select name="month">
HEREDOC;
    $months = array("January", "February", "March", "April", "May", "June", "July",
                "August", "September", "October", "November", "December");
    
    //Keeps current month selected
    foreach ($months as $x) {
        if ($x === $month) {
            $body .= "<option value='$x' selected='selected'>$x";
        } else {
            $body .= "<option value='$x'>$x";
        }
    }
                
    $body .= "</select>
                <select name='year'>";
                
                for($i=2012; $i<=date("Y"); $i++){
                    $body.='<option value='.$i;
                    
                    if ($i == $year) { //Keeps current year selected
                        $body .= " selected='selected'>";
                    } else {
                        $body .= ">";
                    }
                    $body .= $i;
                }
                
                $week = array('Sunday'=>0, 'Monday'=>1, 'Tuesday'=>2, 'Wednesday'=>3, 'Thursday'=>4, 'Friday'=>5, 'Saturday'=>6);
                
    $body.=<<<HEREDOC
                </select>
                <input type='submit' name='submitButton' value='Go!'>
                <input type='submit' name='thismonth' value='This Month'>
            </form>
        </span>
        <table id="calendar">
HEREDOC;
                
                foreach($week as $day=>$offset){
                    $body.="<th>".$day."</th>";
                }
                
                $body.='<tr>';
                $counter = 0;
                
                $dayOffset = $week[date('l', strtotime($month.' 1 '.$year))];
                
                for($i=0; $i<$dayOffset; $i++){
                    $body.="<td class='offset'></td>";
                    $counter++;
                }
                
                
                $days = cal_days_in_month(CAL_GREGORIAN, date('n', strtotime($month)), $year);
                
                for($i=1; $i <= $days; $i++){
                   
                   if($counter % 7 == 0) {
                        $body.="</tr><tr>";
                   }
                   
                   $counter++;
                   $body.="<td id=$i>".$i." ".getPics($pics, $i)."</td>"; //Day added here
                   
                }
                
                //finish rendering calendar
                while($counter % 7 != 0) {
                    $body.="<td class='offset'></td>";
                    $counter++;
                }
                
                $body.="</tr></table>";
                
    $body.=<<<HEREDOC
        <script>
            $(document).ready(main);
            
            function main(){
                $(td).hover(showPhotos);
            }
            
            function showPhotos(){
                $(this).css("width", "200%"); //this isn't done yet
            }
        </script>
HEREDOC;

    echo generatePage($body, "Calendapp");
    
    function getPics($arr, $dayOfMonth) {
        if (empty($arr)) {//No pictures for this month
            return "";
        }
        
        $toReturn = "";
        
        if (!isset($arr['user'])) {
            foreach ($arr as $entry) {
                if (date('j', strtotime($entry['date'])) == $dayOfMonth) {
                    $toReturn .= "<img src='images/{$entry['id']}' alt='{$entry['id']}' width='40' height='40'>
                        <span class='imgtext'>by {$entry['user']}<span id='hidden$dayOfMonth' hidden='true'><br />
                        Caption: {$entry['caption']}<br />
                        Tags: {$entry['tags']}</span></span>"."<br />";
                }
            }
        } else {
            if (date('j', strtotime($arr['date'])) == $dayOfMonth) {
                    $toReturn .= "<img src='images/{$arr['id']}' alt='{$arr['id']}' width='40' height='40'>
                        <span class='imgtext'>by {$arr['user']}<span id='hidden$dayOfMonth' hidden='true'><br />
                        Caption: {$arr['caption']}<br />
                        Tags: {$arr['tags']}</span></span>"."<br />";
                }
        }
        
        return $toReturn;
    }
?>
