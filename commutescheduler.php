<?php
    include("config.php");
    session_start();
    if(isset($_SESSION['login_user']) == null){
        header("location: login.php");
    }
if(isset($_POST['start']) != null && isset($_POST['destination']) != null) {
    $myusername = mysqli_real_escape_string($db,$_SESSION['login_user']);
    $start = mysqli_real_escape_string($db,$_POST['start']);
    $destination = mysqli_real_escape_string($db,$_POST['destination']);
    $traveltime = mysqli_real_escape_string($db,$_POST['traveltime']);
    $day = mysqli_real_escape_string($db,$_POST['day']); 
    $lift = mysqli_real_escape_string($db,$_POST['lift']);
    $furtherinfo = mysqli_real_escape_string($db,$_POST['furtherinfo']); 
    
    $query = "INSERT INTO commute_ (username, start, destination, traveltime, day, lift, furtherinfo) VALUES ('$myusername', '$start', '$destination', '$traveltime','$day', '$lift', '$furtherinfo')";
    $insert = mysqli_query($db,$query);
}

if (isset($_POST['EditUpdate']) != null){
    $userid = $_GET['id'];
    $updatestart = mysqli_real_escape_string($db,$_POST['startSelected']);
    $updatedest = mysqli_real_escape_string($db,$_POST['destinationSelected']);
    $updateday = mysqli_real_escape_string($db,$_POST['daySelected']);
    $updatelift = mysqli_real_escape_string($db,$_POST['liftSelected']);
    $updatetime = mysqli_real_escape_string($db,$_POST['selectedTime']);
    $updatecomment = mysqli_real_escape_string($db,$_POST['furtherinfoedit']);
    
    $tryupdate = "UPDATE commute_ SET start = '$updatestart', destination = '$updatedest', traveltime = '$updatetime', day = '$updateday', lift = '$updatelift', furtherinfo = '$updatecomment' WHERE infoid = '$userid'";
    $updatedatebase = mysqli_query($db,$tryupdate);
}

if(isset($_GET['delete']) != null){
    $getid = $_GET['id'];
    $trydelete  =  "DELETE FROM commute_ WHERE infoid = '$getid'";
    $deletedb = mysqli_query($db,$trydelete);
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
   
   <body>
    <div align = "center">
        <div style = "width:auto; border: solid 1px #333333; background-color:#FFFFFF; " align = "center">
            <div style = "background-color:#333333; color:#FFFFFF; padding:3px;"><b>Commute Scheduler</b></div>
				<div style = "margin:30px">
       <form name ="scheduler" action = "" method = "post">
           <br><br><br>
           <label>Starting Point  :</label>
                <select name="start">
                    <?php
                        $sql = "SELECT location FROM location_";
                        $result = mysqli_query($db,$sql);
                        while($column = mysqli_fetch_assoc($result)){
                        ?>
                    <option value="<?php echo $column['location'];?>"><?php echo $column['location'];?></option>
                    <?php  
                        }
                    ?>
                </select>&nbsp;&nbsp;&nbsp;
           <label>Destination :</label>
                <select name="destination">
                    <?php
                        $sql = "SELECT location FROM location_";
                        $result = mysqli_query($db,$sql);
                        while($column = mysqli_fetch_assoc($result)){
                        ?>
                    <option value="<?php echo $column['location'];?>"><?php echo $column['location'];?></option>
                    <?php  
                        }
                    ?>
                </select>&nbsp;&nbsp;&nbsp;
           <label>Day   :</label>
                <select name="day">
                    <option value="Monday">Monday</option>
                    <option value="Tuesday">Tuesday</option>
                    <option value="Wednesday">Wednesday</option>
                    <option value="Thursday">Thursday</option>
                    <option value="Friday">Friday</option>
                    <option value="Saturday">Saturday</option>
                    <option value="Sunday">Sunday</option>
                </select>&nbsp;&nbsp;&nbsp;
           <label>Lift  :</label>
                <select name="lift">
                    <option value="Need">Need</option>
                    <option value="Providing">Providing</option>
                </select>&nbsp;&nbsp;&nbsp;
            <label>Time :</label>
                <input type= "text" name ="traveltime"><br>
          <br><textarea  style="resize:none; width:50% " name="furtherinfo" type="text" cols="30" rows="5" maxlength="200" placeholder="Leave further infomation here!"></textarea><br>
           <input type = "submit" value = " Submit "/><br>
       </form>
            
            </div>	
         </div>
        
        <div style = "width:auto; border: solid 1px #333333; background-color:#FFFFFF; " align = "center">
            <div style = "background-color:#333333; color:#FFFFFF; padding:3px;"><b>Your Journey Listings</b></div>
				<div style = "margin:30px">
                    <table class= "commute" style="width:99%;">
                        <tr>
                            <th>ID</th>
                            <th>Starting Point</th>
                            <th>Destination</th>
                            <th>Travel Times</th>
                            <th>Days</th>
                            <th>Lift (GIVE/TAKE)</th>
                            <th>Further Info</th>
                            <th></th>
                            <th></th>
                        </tr>
                        <tr>
                           <?php
                            $logged = $_SESSION['login_user'];
                            $smt = "SELECT * FROM commute_ WHERE username = '$logged'";
                            $exesmt = mysqli_query($db,$smt);
                            $row = mysqli_num_rows($exesmt);
                            while($info =  mysqli_fetch_assoc($exesmt)){
                                echo "<tr><td>".$info['infoid']."</td>";
                                echo "<td>".$info['start']."</td>";
                                echo "<td>".$info['destination']."</td>";
                                echo "<td>".$info['traveltime']."</td>";
                                echo "<td>".$info['day']."</td>";
                                echo "<td>".$info['lift']."</td>";
                                echo "<td>".$info['furtherinfo']."</td>";
                                
                            ?>
                                <form action="" method= 'get'>
                                <input type='hidden' name='id' value="<?php echo $info['infoid']; ?>">
                                <td><input type='submit' name='edit' value='Edit'></td>
                                <td><input type='submit' name='delete' value='Delete'></td>
                                </form>
                            <?php 
                                echo "</tr>" ;
                            }
                            ?>     
                        </tr>
                    </table>
                    
<!-- #################################################################################################################### -->                 
                    <?php
                    if(isset($_GET['edit']) == "Edit"){
                        $getid = $_GET['id'];
                        $get = "SELECT * FROM commute_ where infoid = '$getid'";
                        $getSelected = mysqli_query($db,$get);
                        $selected= mysqli_fetch_assoc($getSelected);
                        

                    ?>
                    <form style="border:1px;" action="" method="post"> 
                    <fieldset>
                    <legend>Edit</legend>
                    <br><br><label>ID  :</label><?php echo $getid ?>
                    <?php
                        $sql = "SELECT * FROM location_";
                        $result = mysqli_query($db,$sql);
                        echo "<label>Starting Point   :</label><select name='startSelected'>";
                        echo "<option value=".$selected['start']." selected>".$selected['start']."</option>";
                        while($column = mysqli_fetch_assoc($result)) {
                        echo "<option value=".$column['location'].">".$column['location']."</option>";
                        } 
                        echo "</select>&nbsp;";  
                    ?>
                    <?php
                        $sql = "SELECT * FROM location_";
                        $result = mysqli_query($db,$sql);
                        echo "<label>Destination   :</label><select name='destinationSelected'>";
                        echo "<option value=".$selected['destination']." selected>".$selected['destination']."</option>";
                        while($column = mysqli_fetch_assoc($result)) {
                        echo "<option value=".$column['location'].">".$column['location']."</option>";
                        } 
                        echo "</select>&nbsp;";  
                    ?>
                    <?php
                        $sql = "SELECT * FROM location_";
                        $result = mysqli_query($db,$sql);
                        echo "<label>Day   :</label><select name='daySelected'>";
                        echo "<option value=".$selected['day']." selected>".$selected['day']."</option>";
                        while($column = mysqli_fetch_assoc($result)) {
                        echo "<option value=".$column['days'].">".$column['days']."</option>";
                        } 
                        echo "</select>&nbsp;";  
                    ?>
                        <label>Lift  :</label><select name='liftSelected'>
                        <option value="<?php echo $selected['lift'] ?>" selected><?php echo $selected['lift'] ?></option>
                        <option value="Need">Need</option>
                        <option value="Providing">Providing</option>
                        </select>&nbsp;  
                        
                        
                        <label>Time :</label> <input name="selectedTime" value="<?php echo $selected['traveltime']?>">
                        <br><label>Further info :</label><br>
                            <textarea  style="resize:none; width:30% " name="furtherinfoedit" type="text" cols="30" rows="5" maxlength="200"><?php echo $selected['furtherinfo']?> </textarea>
                            <input type = "submit" name= "EditUpdate" value = "Update"/><br>
                    </fieldset>
                    </form>
                     <?php
                        }
                    ?>
                </div>
            </div>
       </div>
   </body>
    <footer>Copyright &copy;Sandesh Koirala</footer>
</html>