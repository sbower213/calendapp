<?php

    include_once("support.php");
    include_once("dbLogin.php");
    include_once("sqlconnector.php");

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
    
    //$user = $_COOKIE['username'];
    $user = "test";
    $query = "select profilepic from users where name=\"$user\""; //this kind of assumes user is the primary key, could rework with email
    $profpic = $connection->retrieve($query);
    
    //insert logo here, float left the month/year? float right the profile info so it's in the upper right corner
    //could make icon graphics for edit and upload
    //should probably include a logout button somewhere
    $body =<<<HEREDOC
        
        <a href="main.php"> <img src="img/CalendAppLogo.png" width="256" height="73" alt="CalendApp"> </a>
        <span id="calendarTitle">
            <h1>$month $year</h1>
        </span>
        <div id="profile">
            <img src=$profpic alt=$user>
            Hello, $user!
            <br />
            <a href='profile.php'>Edit Profile</a> 
            <a href='upload.php'>Upload Photo</a>
        </div>
        <span id="sidebar">
            <form action="main.php" method="post">
                <select name="month">
                    <option value="January">January
                    <option value="February">February
                    <option value="March">March
                    <option value="April">April
                    <option value="May">May
                    <option value="June">June
                    <option value="July">July
                    <option value="August">August
                    <option value="September">September
                    <option value="October">October
                    <option value="November">November
                    <option value="December">December
                </select>
                <select name="year">
HEREDOC;
                
                for($i=2012; $i<=date("Y"); $i++){
                    $body.='<option value='.$i.'>'.$i;
                }
                
                $week = array('Sunday'=>0, 'Monday'=>1, 'Tuesday'=>2, 'Wednesday'=>3, 'Thursday'=>4, 'Friday'=>5, 'Saturday'=>6);
                
    $body.=<<<HEREDOC
                </select>
                <input type='submit' name='submitButton' value='Go!'>
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
                   $body.="<td id=$i>".$i."</td>";
                   
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

    echo generatePage($body);
?>
