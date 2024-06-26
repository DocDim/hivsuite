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
								{mysql_query("INSERT INTO pbk (`GroupID`, `Name`, `Number`)
								VALUES ('$post[groupID]','$post[name]','$post[number]')") or die(mysql_error()); 
								}	
							header("Location: contact_list.php");
							
							}
						  ?>
						  
						  <h3 class="titlehdr">Upload New Contacts</h3>
						  <?php	
								if (isset($_GET['msg'])) {
								echo "<div class=\"error\">$_GET[msg]</div>";
								}	  	  
							?>
						  
						  <?php



							if (isset($_POST['submit'])) {
								if (is_uploaded_file($_FILES['filename']['tmp_name'])) {
									
									echo "<br/>";
									echo "<h2>" . "File ". $_FILES['filename']['name'] ." uploaded successfully." . "</h2>";
									
								}

								//Import uploaded file to Database
								$handle = fopen($_FILES['filename']['tmp_name'], "r");

								while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
									$import="INSERT INTO pbk (`GroupID`, `Name`, `Number`)
															VALUES ('$data[0]','$data[1]','$data[2]')"; 

									mysql_query($import) or die(mysql_error());
								}

								fclose($handle);
								echo "<div class=\"msg-succes\">";
								echo "Import done";
								echo "</div>";

								//view upload form
							}else {

								echo "Upload new csv by browsing to file and clicking on Upload<br />\n";

								echo "<form enctype='multipart/form-data' action='upload_contact.php' method='post'>";

								echo "File name to import:<br />\n";

								echo "<input size='50' type='file' name='filename'><br />\n";

								echo "<input type='submit' name='submit' value='Upload'></form>";

							}

							?>
						  
						  
				
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






