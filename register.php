<?php
   include('config.php');
    session_start();
    $info = " ";

if($_SERVER["REQUEST_METHOD"]== "POST"){
    $myusername = mysqli_real_escape_string($db,$_POST['username']);
    $mypassword = mysqli_real_escape_string($db,md5($_POST['password']));
    $myemail = mysqli_real_escape_string($db,$_POST['email']);
    $captchastr = ($_POST['captcha']);
    $codestr =  $_SESSION['codestr'];
    
    if ($captchastr == $codestr ){
    $validation = "SELECT username FROM carpool_ WHERE username = '$myusername'";
    $validResult = mysqli_query($db,$validation);
    $validCount = mysqli_num_rows($validResult);
        
            if ($validCount != 1){
                $sql = "INSERT INTO carpool_ (username, password, email) VALUES ('$myusername', '$mypassword' , '$myemail' )";
                $result = mysqli_query($db,$sql);
                $info = " Registration Successful! Please check your email to activiate your account.";
///////////////////EMAIL//////////////////////////////////
                $verify = rand(12345,999999);
                $to      = $myemail;
                $subject = 'Greenwich Car Pool | Verifcation Code';
                $message = 'Thanks For Registering With Greenwich Car Pool ' . "\r\n" . ' Verification Code: '. "$verify";
                $headers = 'From: noreply@greenwich.ac.uk' . "\r\n" .
                'Reply-To: '."$myemail". "\r\n" .
                'X-Mailer: PHP/' . phpversion();
                mail($to, $subject, $message, $headers);
/////////////////////////////////////////////////////////////
                $query = "INSERT INTO verify_ (username, vericode) VALUES ('$myusername','$verify')";
                $run =  mysqli_query($db,$query);
                $_SESSION['login_user'] = $myusername;
                header("Location: verify.php");
                } else {
                $info =  "This username is already installed!";
            }
    } else {$info = "Wrong Captcha!";}
}
?>
<!DOCTYPE html>
<html>
    <head>
      <title>Register</title>
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

    </header>
    <nav>
        <div class="topnav">
        <a href="#home">Home</a>
        <a href="login.php">Login</a>
        <a href="#register">Register</a>
        <a href="#contact">Contact</a>
        <a href="#reviews">Reviews</a>
        <a href="#about">About</a>
    </div>
    </nav>
    <body>
	
      <div align = "center">
         <div style = "width:auto; border: solid 1px #333333; background-color:#FFFFFF" align = "center">
            <div style = "background-color:#333333; color:#FFFFFF;  padding:3px background-color:#FFFFFF;"><b>Register</b></div>
				
            <div style = "margin:30px">
               
               <form action = "" method = "post">
                  <label>Username  :</label><br /><input type = "text" name = "username" class = "box" required/><br /><br />
                  <label>Password  :</label><br /><input type = "password" name = "password" class = "box" pattern=".{8,16}" required title="8 to 16 characters"/><br/><br />
                   <label>Email  :</label><br /><input type = "email" name = "email" class = "box" required/><br/><br />
                   <label>Captcha  :</label><img src="captcha.php" /><br>
                    <input type = "text" name = "captcha" class ="box" required> <br/><br/>
                  <input type = "submit" value = " Register   "/><br />
                   
               </form>
                <?php echo $info; ?>
               <div style = "font-size:11px; color:#cc0000; margin-top:10px"></div>
					
            </div>
				
         </div>
			
      </div>

   </body>
   <footer>Copyright &copy;Sandesh Koirala</footer>
</html>