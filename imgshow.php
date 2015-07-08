<?php
    require_once("support.php");
    
    $imgname = $_GET['img'];
    $caption = $_GET['caption'];
    $tags = $_GET['tags'];
    $user = $_GET['user'];
    
    $body = "<img src='$imgname' alt='$imgname' style='max-height:600px' class='image'><br />
            by $user<br />
            Caption: $caption<br />
            Tags: $tags<br />
            
            <form action='main.php' method='post'><input type='submit' value='Return to main page'></form>";
            
    $body.=<<<HEREDOC
        <script>
            $(document).ready(main);
            
            function main(){
                $("img").click(function(){
                    if ($(this).css("max-height") !== "900px") {
                        $(this).css("max-height", "900px");
                    } else {
                        $(this).css("max-height", "600px");    
                    }
                });
            }
        </script>
HEREDOC;

    echo generatePage($body, "View Image", "<link rel='stylesheet' href='imgshow.css' type='text/css' />");
?>