<?php 
/*************** PHP LOGIN SCRIPT V 2.3*********************
(c) Balakrishnan 2009. All Rights Reserved

Usage: This script can be used FREE of charge for any commercial or personal projects. Enjoy!

Limitations:
- This script cannot be sold.
- This script should have copyright notice intact. Dont remove it please...
- This script may not be provided for download except from its original site.

For further usage, please contact me.

***********************************************************/
include "dbc.php";

$err = array();

foreach($_GET as $key => $value) {
	$get[$key] = $value; //filter($value); //get variables are filtered.
}


if (@$_POST["doLogin"]=="Login")
{

foreach($_POST as $key => $value) {
	$data[$key] = $value; //filter($value); // post variables are filtered
}


$user_email = $data['usr_email'];
$pass = $data["pwd"];


if (strpos($user_email,'@') === false) {
    $user_cond = "user_name='$user_email'";
} else {
      $user_cond = "user_email='$user_email'";
    
}

	
$result = mysqli_query($link, "SELECT `id`,`pwd`,`full_name`,`approved`,`user_level` FROM users WHERE 
           $user_cond
			AND `banned` = '0'
			");

if (!mysqli_query($con,"SELECT `id`,`pwd`,`full_name`,`approved`,`user_level` FROM users WHERE 
           $user_cond
			AND `banned` = '0'
			"))
  {
  echo("Error description: " . mysqli_error($link));
  }
 


$num = mysqli_num_rows($result);

  // Match row found with more than 1 results  - the user is authenticated. 
    if ( $num > 0 ) { 
	
	list($id,$pwd,$full_name,$approved,$user_level) = mysqli_fetch_row($result);
	
	if(!$approved) {
	//$msg = urlencode("Account not activated. Please check your email for activation code");
	$err[] = "Account not activated. Please check your email for activation code";
	
	//header("Location: login.php?msg=$msg");
	 //exit();
	 }
	 
		//check against salt
	if ($pwd === PwdHash($pass,substr($pwd,0,9))) { 
	if(empty($err)){			

     // this sets session and logs user in  
       session_start();
	   session_regenerate_id (true); //prevent against session fixation attacks.

	   // this sets variables in the session 
		$_SESSION['user_id']= $id;  
		$_SESSION['user_name'] = $full_name;
		$_SESSION['user_level'] = $user_level;
		$_SESSION['HTTP_USER_AGENT'] = md5($_SERVER['HTTP_USER_AGENT']);
		
		//update the timestamp and key for cookie
		$stamp = time();
		$ckey = GenKey();
		$result1= mysqli_query($link, "update users set `ctime`='$stamp', `ckey` = '$ckey' where id='$id'");

		
		//set a cookie 
		
	   if(isset($_POST['remember'])){
				  setcookie("user_id", $_SESSION['user_id'], time()+60*60*24*COOKIE_TIME_OUT, "/");
				  setcookie("user_key", sha1($ckey), time()+60*60*24*COOKIE_TIME_OUT, "/");
				  setcookie("user_name",$_SESSION['user_name'], time()+60*60*24*COOKIE_TIME_OUT, "/");
				   }
		  header("Location: myaccount.php");
		 }
		}
		else
		{
		//$msg = urlencode("Invalid Login. Please try again with correct user email and password. ");
		$err[] = "Invalid Login. Please try again with correct user email and password.";
		//header("Location: login.php?msg=$msg");
		}
	} else {
		$err[] = "Error - Invalid login. No such user exists";
	  }		
	  
}



?>
<!------------------Header Block----------------------------------------------------------------->
	
<?php	
include 'block_header.php';
	
?>	
<!------------------- #end Header --------------------------------------------------------------->   
 

   
	<div id="main-wrapper" class="clearfix">
		<div id="main" class="row-fluid">
		<div  id="second_sidebar" class="column sidebar span3">
				<h2 id="block_entete" >Connexion </h2>  
				<form action="login.php" method="post" name="logForm" id="logForm" >
				<table width="100%" border="0" cellpadding="4" cellspacing="4" class="loginform">
				  <tr> 
					<td colspan="2">&nbsp;</td>
				  </tr>
				  <tr> 
					<td width="28%">Nom d'utilisateur</td>
					<td width="72%"><input name="usr_email" type="text" class="required" id="txtbox" size="15"></td>
				  </tr>
				  <tr> 
					<td>Mot de passe</td>
					<td><input name="pwd" type="password" class="required password" id="txtbox" size="15"></td>
				  </tr>
				  <tr> 
					<td colspan="2"><div align="center">
						<input name="remember" type="checkbox" id="remember" value="1">
						Se rappeler de moi</div></td>
				  </tr>
				  <tr> 
					<td colspan="2"> <div align="center"> 
						<p> 
						  <input name="doLogin" type="submit" id="doLogin3" value="Login">
						</p>
						<p>
						 </font> <a href="forgot.php">Mot de passe oublié</a> <font color="#FF6600"></font>
						</p>
						
					  </div></td>
				  </tr>
				</table>
				<div align="center"></div>
				<p align="center">&nbsp; </p>
			  </form>
			</div>
			<div id="content" class="column span9">
						
						  <?php
						  /******************** ERROR MESSAGES*************************************************
						  This code is to show error messages 
						  **************************************************************************/
						  if(!empty($err))  {
						   echo "<div class=\"msg\">";
						  foreach ($err as $e) {
							echo "$e <br>";
							}
						  echo "</div>";	
						   }
						  /******************************* END ********************************/	  
						  ?>
						
						<?php
						include'block_map.php';
						?>
						
			</div>
			
		
		</div>
	</div>
     

   
   
<!---------------------------------footer --------------------------------------------->
<?php	
include 'block_footer.php';
	
?>	
<!---------------------------------# end footer ------------------------------------->
