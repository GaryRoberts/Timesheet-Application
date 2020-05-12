<?php

error_reporting(0);

 function message($data)
    {
        echo'<style>
                #overlay {
                    position: fixed;
                    display: none;
                    width: 100%;
                    height: 100%;
                    top: 0;
                    left: 0;
                    right: 0;
                    bottom: 0;
                    background-color:#000000f2;
                    z-index: 2;
                    cursor: pointer;
                }

                #text{
                    position: absolute;
                    top: 50%;
                    left: 50%;
                    font-size: 30px;
                    color: white;
                    transform: translate(-50%,-50%);
                    -ms-transform: translate(-50%,-50%);
                }
                </style>
                
                <div id="overlay" onclick="off()">
                <div id="text">'.$data.'</div>
            </div>
                
                
                <script>
                    function on() {
                        document.getElementById("overlay").style.display = "block";
                    }

                    function off() {
                        document.getElementById("overlay").style.display = "none";
                    }
                    on();
                </script>
     
                ';
 }


function toast($message)
{
  echo '
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <style>
  #snackbar {
    visibility: hidden;
    min-width: 250px;
    margin-left: -125px;
    background-color: #333;
    color: #fff;
    text-align: center;
    border-radius: 2px;
    padding: 16px;
    position: fixed;
    z-index: 1;
    left: 50%;
    bottom: 30px;
    font-size: 17px;
    font-weight:bold;
  }
  
  #snackbar.show {
    visibility: visible;
    -webkit-animation: fadein 0.5s, fadeout 0.5s 2.5s;
    animation: fadein 0.5s, fadeout 0.5s 2.5s;
  }
  
  @-webkit-keyframes fadein {
    from {bottom: 0; opacity: 0;} 
    to {bottom: 30px; opacity: 1;}
  }
  
  @keyframes fadein {
    from {bottom: 0; opacity: 0;}
    to {bottom: 30px; opacity: 1;}
  }
  
  @-webkit-keyframes fadeout {
    from {bottom: 30px; opacity: 1;} 
    to {bottom: 0; opacity: 0;}
  }
  
  @keyframes fadeout {
    from {bottom: 30px; opacity: 1;}
    to {bottom: 0; opacity: 0;}
  }
  </style>
  
  <div id="snackbar">'.$message.'</div>

<script>
function myFunction() {
  var x = document.getElementById("snackbar");
  x.className = "show";
  setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
}

myFunction();
</script>'
  ;
}


function sendEmail($sender,$receiver,$subject,$message)
{
  ini_set("SMTP","mail.zend.com");
  ini_set("sendmail_from",$sender);
  
  // Send
  $headers = "From: ".$sender;
  
  mail($receiver,$subject, $message, $headers);
  
  toast("Message was sent successfully !!!");
}



?>