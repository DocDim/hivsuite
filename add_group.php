<?php 
include 'dbc.php';
page_protect();

if(!checkAdmin()) {
header("Location: login.php");
exit();
}
$host  = $_SERVER['HTTP_HOST'];
$host_upper = strtoupper($host);
$login_path = @ereg_replace('admin','',dirname($_SERVER['PHP_SELF']));
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
				<h2 id="block_entete" >My Account </h2>  
		
				<?php 
				/*********************** MYACCOUNT MENU ****************************
				This code shows my account menu only to logged in users. 
				Copy this code till END and place it in a new html or php where
				you want to show myaccount options. This is only visible to logged in users
				*******************************************************************/
				if (isset($_SESSION['user_id'])) {
				include'block_myaccount.php';
				}
				if (checkAdmin()) {
				/*******************************END**************************/
				?>
				<h2 id="block_entete" >PhoneBook </h2>
				<table>
					<tr>
						<td>
						<p align="center"> 
							<a href="contact_list.php"><img src="images/phonebook.png" width="60px"/></a><br>
							<a href="contact_list.php">Contact List</a>
						</p align="center">
						<td>
						<td>
						<p align="center"> 
							<a href="add_contact.php"><img src="images/add_phoneicon.png" width="60px"/></a><br>
							<a href="add_contact.php">Add Contact </a>
						</p align="center">
						</td>
						<td>&nbsp;</td>
						
					</tr>
					<tr>
						<td>
						<p align="center"> 
							<a href="add_group.php"><img src="images/group_contact.png" width="60px"/></a><br>
							<a href="add_group.php">Add contact group</a>
						</p align="center">
						<td>
						<td>
						<p align="center"> 
							<a href="upload_contact.php"><img src="images/phone_upload.png" width="60px"/></a><br>
							<a href="upload_contact.php">Upload Contact </a>
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
				
						  if(@$_POST['doSubmit'] == 'Save'){
								{mysql_query("INSERT INTO pbk_groups (`Name`)
								VALUES ('$post[name]')") or die(mysql_error()); 
								}	
							header("Location: contact_list.php");
							
							}
						  ?>
						  
						  <h3 class="titlehdr">Add New Group</h3>
						  <?php	
								if (isset($_GET['msg'])) {
								echo "<div class=\"error\">$_GET[msg]</div>";
								}	  	  
							?>
						  <table width="80%" border="0" cellpadding="5" cellspacing="2" class="myaccount">
							<tr>
							  <td><form name="form1" method="post" action="add_group.php">
								  <table>
									
									<tr>
										<td>Name</td>
										<td><input name="name" type="text" id="name" placeholder="Name"></td>
									</tr>							
									
									
									<tr>
										<td></td>
										<td><input name="doSubmit" type="submit" id="doSubmit" value="Save"></td>
									</tr>
									
								  </table>
								  
								  
								</form>
								
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






