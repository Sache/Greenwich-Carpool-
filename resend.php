<?php
    include("config.php");
    session_start();
    $info = "";
    
    if($_SERVER["REQUEST_METHOD"]== "POST"){
        $myemail = mysqli_real_escape_string($db,$_POST['email']);
        $emailQuery = "SELECT username FROM carpool_ WHERE email = '$myemail' AND verified = 0";
        $emailResult = mysqli_query($db,$emailQuery);
        $userStr = mysqli_fetch_array($emailResult);
        $validCount = mysqli_num_rows($emailResult);
        $myusername = $userStr['username'];
        if ($validCount == 1 ){
            $verify = rand(12345,999999);
            $to      = $myemail;
            $subject = 'Greenwich Car Pool | Verifcation Code';
            $message = 'Your request for new verification email has been approved.' . "\r\n" . ' New Verification Code: '. "$verify";
            $headers = 'From: noreply@greenwich.ac.uk' . "\r\n" .
            'Reply-To: '."$myemail". "\r\n" .
            'X-Mailer: PHP/' . phpversion();
            mail($to, $subject, $message, $headers);
            
            $del = mysqli_query($db, "DELETE FROM  verify_ WHERE username ='$myusername'");
            
            $query = "INSERT INTO verify_ (username, vericode) VALUES ('$myusername','$verify')";
            $run =  mysqli_query($db,$query);
        }else {
            $info =  "Your account is already activated.  You can use your account straightup.";
        }
        
    }
?>
<!DOCTYPE html>
<html>
   
   <head>
      <title>Resend Verification Code</title>
      
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
                <?php
                // THis script is allows user to resend verification code if already not sent.
                if ( isset($_GET["user"]) == null) {
                ?> 
                <form action = "" method = "POST">
                  <label>Email  :</label><input type = "text" name = "email" class = "box" data-required><br><br>
                  <input type = "submit" value = " Resend Verification Code "><br>
               </form>
                <?php
                }
                ?>
               <?php echo $info; ?>
               <div style = "font-size:11px; color:#cc0000; margin-top:10px"></div>
					
            </div>
				
         </div>
			
      </div>

   </body>
</html>