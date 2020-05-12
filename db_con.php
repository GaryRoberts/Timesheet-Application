<?php

$status="offline";

if($status=="online")
{
    
    $DB_host = "";
    $DB_user = "";
    $DB_pass = "";
    $DB_name = "i";
   
}
else if($status=="offline")
{
    $DB_host = "localhost";
    $DB_user = "root";
    $DB_pass = "";
    $DB_name = "timesheet";   
}



try 
{ 
    $conn = new PDO("mysql:host={$DB_host};dbname={$DB_name}",$DB_user,$DB_pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e)
{
    toast("Sorry.An error occured while trying to connect to the system");
}


?>

