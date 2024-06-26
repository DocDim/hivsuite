<?php 
include 'dbc.php';
page_protect();

if(!checkAdmin()) {
header("Location: login.php");
exit();
}
$host  = $_SERVER['HTTP_HOST'];
$host_upper = strtoupper($host);
$login_path = @preg_replace('admin','',dirname($_SERVER['PHP_SELF']));
$path   = rtrim($login_path, '/\\');

// filter GET values
foreach($_GET as $key => $value) {
	$get[$key] = filter($value);
}

foreach($_POST as $key => $value) {
	$post[$key] = filter($value);
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
				<h2 id="block_entete" >Mon compte </h2>  
		
				<?php 
				/*********************** MYACCOUNT MENU ****************************
				This code shows my account menu only to logged in users. 
				Copy this code till END and place it in a new html or php where
				you want to show myaccount options. This is only visible to logged in users
				*******************************************************************/
				if (isset($_SESSION['user_id'])) {
				include'block_myaccount.php';}
				if (checkAdmin()) {
				/*******************************END**************************/
				?>
				<h2 id="block_entete" >Gestion des Utilisateurs </h2>
				<table>
					<tr>
						<td>
						<p align="center"> 
							<a href="admin.php"><img src="images/edit-user-icon.png" width="60px"/></a><br>
							<a href="admin.php">Modifier un utilisateur </a>
						</p align="center">
						<td>
						<td>
						<p align="center"> 
							<a href="create_user.php"><img src="images/add-user-icon.png" width="60px"/></a><br>
							<a href="create_user.php">Ajouter un utilisateur </a>
						</p align="center">
						</td>
						<td>&nbsp;</td>
						
					</tr>
				</table>
				<?php } 
				?>
			</div>
			<div id="content" class="column span9">
						<p>
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
						</p>
						 
							
						
						<?php if (checkAdmin()) {
				
						  if(!empty($get['doSubmit']) and ($_POST['doSubmit'] == 'Enregistrer'))
							{
							$rs_dup = mysqli_query($link, "select count(*) as total from users where user_name='$post[user_name]' OR user_email='$post[user_email]'") or die(mysql_error());
							list($dups) = mysqli_fetch_row($rs_dup);

							if($dups > 0) {
								die("The user name or email already exists in the system");
								}

							if(!empty($_POST['pwd'])) {
							  $pwd = $post['pwd'];	
							  $hash = PwdHash($post['pwd']);
							 }  
							 else
							 {
							  $pwd = GenPwd();
							  $hash = PwdHash($pwd);
							  
							 }
							 
							mysqli_query($link, "INSERT INTO users (`user_name`,`user_email`,`pwd`,`approved`,`date`,`user_level`)
										 VALUES ('$post[user_name]','$post[user_email]','$hash','1',now(),'$post[user_level]')
										 ") or die(mysql_error()); 



							$message = 
							"Thank you for registering with us. Here are your login details...\n
							User name: $post[user_name] \n
							Passwd: ********* \n

							*****LOGIN LINK*****\n
							http://$host$path/login.php

							Thank You
							Administrator
							$host_upper
							______________________________________________________
							THIS IS AN AUTOMATED RESPONSE. 
							***DO NOT RESPOND TO THIS EMAIL****
							";

							if($_POST['send'] == '1') {

								mail($post['user_email'], "Login Details", $message,
								"From: \"Member Registration\" <auto-reply@$host>\r\n" .
								 "X-Mailer: PHP/" . phpversion()); 
							 }
							echo "<div class=\"msg\">User created with password ********....done.</div>"; 
							}

								  ?>
								  
								  <h3 class="titlehdr">Ajouter un utilisateur</h3>
								  <table width="80%" border="0" cellpadding="5" cellspacing="2" class="myaccount">
									<tr>
									  <td><form name="form1" method="post" action="create_user.php">
										  <table>
											<tr>
												<td></td>
												<td></td>
											</tr>
											<tr>
												<td>Nom d'utilisateur </td>
												<td><input name="user_name" type="text" id="user_name" placeholder="Saisir le nom d'utilisateur"></td>
											</tr>
											<tr>
												<td>Email</td>
												<td><input name="user_email" type="text" id="user_email" placeholder="Email"></td>
											</tr>
											<tr>
												<td>Niveau d'acces </td>
												<td>
													<select name="user_level" id="user_level">
													  <option value="5">Administrateur</option>
													  <option value="4">Superviseur</option>
													  <option value="3">Operateur de saisie</option>
													  <option value="2">Clinicien</option>
													  <option value="1">Pharmacien</option>
													  <option value="0">Infirmier</option>													  
													</select>
												</td>
											</tr>
											<tr>
												<td>Mot de passe </td>
												<td><input name="pwd" type="password" id="pwd">(Si vide, un mot de passe sera généré automatiquement)</td>
											</tr>
											<tr>
												<td></td>
												<td><input name="send" type="checkbox" id="send" value="1" checked> Envoyer un email</td>
											</tr>
											<tr>
												<td></td>
												<td><input name="doSubmit" type="submit" id="doSubmit" value="Enregistrer"></td>
											</tr>
											
										  </table>
										</form>
										<p>**All created users will be approved by default.</p></td>
									</tr>
								  </table>
				<?php } 
				?>
						
			</div>
			
		</div>
	</div>
     

   
   
<!---------------------------------footer --------------------------------------------->
<?php	
include 'block_footer.php';
	
?>	
<!---------------------------------# end footer ------------------------------------->






