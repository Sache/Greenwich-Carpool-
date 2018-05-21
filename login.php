<?php
   include("config.php");
   session_start();
    $error = "";
   if($_SERVER["REQUEST_METHOD"] == "POST") {
      // username and password sent from form 
      
      $myusername = mysqli_real_escape_string($db,$_POST['username']);
      $mypassword = mysqli_real_escape_string($db,md5($_POST['password'])); 
      
      $sql = "SELECT username, verified FROM carpool_ WHERE username = '$myusername' and password = '$mypassword'";
      $result = mysqli_query($db,$sql);
      
      $count = mysqli_num_rows($result);
       
       $firstrow = mysqli_fetch_assoc($result);
      // If result matched $myusername and $mypassword, $count must me 1 and typed username should match on database.
      if($count == 1 && $firstrow['verified'] == 1) {
         $_SESSION['login_user'] = $myusername;
         
         header("location: dashboard.php");
          exit();
      }elseif ($firstrow['verified'] == "0")  {
          $error = "Please verify your account to use our services.";
      } else { $error = "Your Login Name or Password is invalid";}
   }
?>
<!DOCTYPE html>
<html>
   
 <head>
      <title>Login Page</title>
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
     <script type= "text/javascript" src="loginForm.js"></script>
   </head>
    
    <header>
    </header>
    <nav>
        <div class="topnav">
        <a href="#home">Home</a>
        <a href="test/index.html">Login</a>
        <a href="#register">Register</a>
        <a href="#contact">Contact</a>
        <a href="#reviews">Reviews</a>
        <a href="#about">About</a>
        </div>
    </nav>
   <body>
	
      <div align = "center">
         <div style = "width:auto; border: solid 1px #333333; background-color:#FFFFFF; " align = "center">
            <div style = "background-color:#333333; color:#FFFFFF; padding:3px;"><b>Login</b></div>
				
            <div style = "margin:30px">
               
               <form name ="loginform" action = "" onsubmit="validateform()" method = "post">
                  <label>UserName  :</label><input type = "text" name = "username" class = "box"/><br /><br />
                  <label>Password  :</label><input type = "password" name = "password" class = "box"/><br> <?php echo $error; ?> <br><br>
                  <input type = "submit" value = " Submit "/><br>
               </form>
                
               <div style = "font-size:11px; color:#cc0000; margin-top:10px"></div>
					
            </div>
				
         </div>
			
      </div>

   </body>
    <footer>Copyright &copy;Sandesh Koirala</footer>
</html>