<?php

require('functions.php');

error_reporting(0);  
try 
{ 
    session_start();
    session_destroy();
    direct("index.php");
}
catch(Exception $e) 
{
    toast("Sorry.An issue occurred.Please try again");
}

?>