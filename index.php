<?php

error_reporting(0);

require_once 'db_con.php';
require_once 'message.php';
require_once 'functions.php';

try
{

 if(isset($_POST['login']))  
   {   
 
      $user_email=$_POST['email'];
      $password=$_POST['pass']; 
       
        $sql = 'CALL GetAccounts()';  //calling stored procedure for accounts
            
        $q = $conn->query($sql);
        $q->setFetchMode(PDO::FETCH_ASSOC);
            
        while($user = $q->fetch())
        {
        if ($user['email']==$user_email && $user['password']==sha1($password) && $user['status']=="active") 
        {
           session_start();
           $_SESSION['id']=$user['id'];
           $_SESSION['email']=$user['email'];
           $_SESSION['title']=$user['title'];
           $_SESSION['first_name']=$user['first_name'];
           $_SESSION['last_name']=$user['last_name'];
           $_SESSION['role_id']=$user['role_id'];
           $_SESSION['telephone']=$user['telephone'];
           $_SESSION['address']=$user['address'];
         
		     
	       direct("home.php");
            
         } 
         else 
         {
             toast("User Credentials incorrect.Please try again");
         }
       }
   }

  }
  catch(Exception $e) 
  {
      toast("Sorry.An issue occured.Please try again");
  }

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Login</title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/mdb.min.css" rel="stylesheet">
    <link href="css/style.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>
    
<body>

 <!-- Material form login -->
<div class="card card-body-custom">
<!-- Default form login -->
<form class="text-center border border-light p-5 custom-form" method="post" action="index.php">

          <div class="d-flex justify-content-center">
              <div class="view overlay d-inline-block">
               <img src="images/timesheet-logo.png" class="img-fluid logo" style="margin: 0 auto" alt="">
               <div class="mask waves-effect waves-light" onclick="toggleSample(0)"></div>
              </div>
          </div><br>

    <p class="h4 mb-4">LOGIN</p>

    <input type="email" name="email" class="form-control mb-4" placeholder="E-mail">

    <input type="password" name="pass" class="form-control mb-4" placeholder="Password">

    <button class="btn custom-button" type="submit" name="login">Sign in</button>

</form>
  
  </div>
  <!-- Material form login -->
  
    <!-- SCRIPTS -->
    <!-- JQuery -->
    <script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>
    <!-- Bootstrap tooltips -->
    <script type="text/javascript" src="js/popper.min.js"></script>
    <!-- Bootstrap core JavaScript -->
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <!-- MDB core JavaScript -->
    <script type="text/javascript" src="js/mdb.min.js"></script>

<!--  <div class="hiddendiv common"></div> -->

</body>
</html>

