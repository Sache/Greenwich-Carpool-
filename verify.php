<?php
    include("config.php");
    session_start();
    $info = "";
   
   if($_SERVER["REQUEST_METHOD"]== "POST") {
    $authorise = mysqli_real_escape_string($db,$_POST['authcode']);
    $user = mysqli_real_escape_string($db,$_SESSION['login_user']);
    $validation = "SELECT vericode FROM verify_ WHERE username = '$user'";
    $validResult = mysqli_query($db,$validation);
    $returnStr = mysqli_fetch_array($validResult);
       
       if((int)$returnStr['vericode'] == (int)$authorise ){
           $query = "UPDATE carpool_ SET verified = 1 WHERE username='$user'";
           $run =  mysqli_query($db,$query);
           $info = "Your account has been verified.";
       }
   }
?>
<!DOCTYPE html>
<html>
   
   <head>
      <title>Verify</title>
      
      <style type = "text/css">
         body {
            font-family:Arial, Helvetica, sans-serif;
            font-size:14px;
         }
         
         label {
            font-weight:bold;
            width:100px;
            font-size:14px;
         }
         
         .box {
            border:#666666 solid 1px;
         }
      </style>
      
   </head>
   
   <body bgcolor = "#FFFFFF">
	
      <div align = "center">
         <div style = "width:300px; border: solid 1px #333333; " align = "left">
            <div style = "background-color:#333333; color:#FFFFFF; padding:3px;"><b>EMAIL VERIFICATION</b></div>
				
            <div style = "margin:30px">
                    <form action = "" method = "POST">
                    <label>Username:</label> <?php echo $_SESSION['login_user']; ?> <br>
                    <label> Verification Code:</label> <input type = "text" name="authcode" class = "box" data-required><br><br>
                    <input type = "submit" value = " Verify "><br>
                    </form> 

               <?php echo $info; ?>
               <div style = "font-size:11px; color:#cc0000; margin-top:10px"></div>
					
            </div>
				
         </div>
			
      </div>

   </body>
</html>