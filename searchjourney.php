<?php
    include("config.php");
    session_start();
    if(isset($_SESSION['login_user'])==null){
        header("location: login.php");
    }
    
    if ($_SERVER["REQUEST_METHOD"] == "POST"){
	//Check if the file is well uploaded
	if($_FILES['file']['error'] > 0) { echo 'Error during uploading, try again'; }
	
	//We won't use $_FILES['file']['type'] to check the file extension for security purpose
	
	//Set up valid image extensions
	$extsAllowed = array( 'jpg', 'jpeg', 'png', 'gif' );
	
	//Extract extention from uploaded file
		//substr return ".jpg"
		//Strrchr return "jpg"
		
	$extUpload = strtolower( substr( strrchr($_FILES['file']['name'], '.') ,1) ) ;
	//Check if the uploaded file extension is allowed
	
	if (in_array($extUpload, $extsAllowed) ) { 
	
	//Upload the file on the server
	
	$name = "img/usr/{$_FILES['file']['name']}";
	$result = move_uploaded_file($_FILES['file']['tmp_name'], $name);
	
	if($result){echo "<img src='$name'/>";}
		
	} else { echo 'File is not valid. Please try again'; }
	
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
   
   <body>
    <div align = "center">
         <div style = "width:auto; border: solid 1px #333333; background-color:#FFFFFF; " align = "center">
            <div style = "background-color:#333333; color:#FFFFFF; padding:3px;"><b>Commute Search</b></div>	
                <div style = "margin:30px">
                    <form action="" method="get">
                        <input type="text" name="search">
                        <input type ='submit' value='Search'>
                    </form>
                    <table  class= "commute" style="width:99%;">
                        <tr>
                            <th>ID</th>
                            <th>Starting Point</th>
                            <th>Destination</th>
                            <th>Travel Times</th>
                            <th>Days</th>
                            <th>Lift (GIVE/TAKE)</th>
                            <th>Further Info</th>
                        </tr>
                        <tr>
                           <?php
                            global $searchsmt;
                            $search =  @$_GET['search'];
                            if ($search != null){
                                $searchsmt = "SELECT * FROM commute_ WHERE username = '$search'";
                            } else {
                                $searchsmt = "SELECT * FROM commute_";
                            }
                            $exesearchsmt = mysqli_query($db,$searchsmt);
                            $row = mysqli_num_rows($exesearchsmt);
                            while($info =  mysqli_fetch_assoc($exesearchsmt)){
                                echo "<tr><td>".$info['infoid']."</td>";
                                echo "<td>".$info['start']."</td>";
                                echo "<td>".$info['destination']."</td>";
                                echo "<td>".$info['traveltime']."</td>";
                                echo "<td>".$info['day']."</td>";
                                echo "<td>".$info['lift']."</td>";
                                echo "<td>".$info['furtherinfo']."</td>";
                                echo "</tr>"; 
                            }
                            
                            ?>    
                        </tr>
                    </table>
                    
                    	<form method="POST" action="" enctype="multipart/form-data">
		                  <label for="file"> Pick a file :  </label>
		                  <input type="file" name ="file"> 
		                  <input type="submit" value = "Upload">
	                   </form>
                    
                </div>
            </div>
       </div>

   </body>
    <footer>Copyright &copy;Sandesh Koirala</footer>
</html>