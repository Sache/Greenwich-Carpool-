<?php
    include("config.php");
    session_start();
    if(isset($_SESSION['login_user'])==null){
        header("location: login.php");
    }

?>
<!DOCTYPE html>
<html>
   
 <head>
      <title>Welcome</title>
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="master.css">
     
      <style type = "text/css">
         body {
            font-family:Arial, Helvetica, sans-serif;
            font-size:14px;
         }
         
         label {
            font-weight:bold;
            width:100px;
            font-size:17px;
         }
         
         .box {
            border:#666666 solid 3px;
         }
      </style>
   </head>
    
    <header>
        <img src="img/logo.jpg">
    </header>
    <nav>
        <div class="topnav">
        <a href="#home">Home</a>
        <a href="test/index.html">Login</a>
        <a href="#register">Register</a>
        <a href="#contact">Contact</a>
        <a href="#reviews">Reviews</a>
        <a href="#about">About</a>
        <a><?php echo $_SESSION['login_user']; ?></a>
        <a href="logout.php">Logout</a>
    </div>
    </nav>
   
   <body  >

    <div class="dash" >
        <a href="commutescheduler.php">Commute Scheduler</a>
       </div> 
       
    <div class="dash">
        This text is the actual content of the box.
        </div>
       
    <div class="dash">
        This text is the actual content of the box.
        </div>
       

   </body>
    <footer>Copyright &copy;Sandesh Koirala</footer>
</html>