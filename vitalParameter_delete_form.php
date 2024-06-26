

<?php 
include 'dbc.php';
page_protect();

if(!checkAdmin() and !clinicien() and !pharmacien() and !nurse()) {
header("Location: login.php");
exit();
}

function redir($url){
	echo '<script language="javascript">';
	echo 'window.location="',$url,'";';
	echo '</script>';
} 

$host  = $_SERVER['HTTP_HOST'];
$host_upper = strtoupper($host);
$login_path = @preg_replace("admin",'',dirname($_SERVER['PHP_SELF']));
$path   = rtrim($login_path, '/\\');

// filter GET values
foreach($_GET as $key => $value) {
	$get[$key] = filter($value);
}

foreach($_POST as $key => $value) {
	$post[$key] = filter($value);
}

if (!empty($_GET['id'])){
$Code = $_GET['id'];
 
$sql = "SELECT * FROM `dhappdatabase`.`vitalParameter`  WHERE `id`= '$Code' ";
$result = mysqli_query($link, $sql);


if(mysqli_num_rows($result)== 0){
	echo '<script>alert("Ce code n\'existe pas");</script>';	
	redir("patient_list.php");
	exit();
}
else{

while ($rrows = mysqli_fetch_array($result)) {

$id = $rrows['id'];	 
$serialNumber = $rrows['serialNumber'];	 
$dateOfRecord = $rrows['dateOfRecord'];
$height = $rrows['height'];
$weight = $rrows['weight']; 
$bmi = $rrows['bmi']; 
$temperature = $rrows['temperature']; 
$bloodPressure = $rrows['bloodPressure']; 
$pulseRate = $rrows['pulseRate']; 
$respirationRate = $rrows['respirationRate']; 	
	
 }
 }
 
$sqlX = "SELECT * FROM `dhappdatabase`.`patient`  WHERE `serialNumber`= '$serialNumber' ";
$resultX = mysqli_query($link, $sqlX);
while ($rrows = mysqli_fetch_array($resultX)) {

	$patientARTCode = $rrows['patientARTCode'];	 	
 
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
				<h2 id="block_entete" >Mon compte </h2>  
		
				<?php 
				/*********************** MYACCOUNT MENU ****************************
				This code shows my account menu only to logged in users. 
				Copy this code till END and place it in a new html or php where
				you want to show myaccount options. This is only visible to logged in users
				*******************************************************************/
				if (isset($_SESSION['user_id'])) {
				include'block_myaccount.php';}
				if(checkAdmin() || clinicien() || pharmacien() || nurse()) {
				/*******************************END**************************/
				?>
				<h2 id="block_entete" >Suivi des patients </h2>
				<table>
					<tr>
						<td>
						<p align="center"> 
							<a href="patient_list.php"><img src="images/Patient_Center_Icon.png" width="65px"/></a><br>
							<a href="patient_list.php">Liste des patients </a>
						</p align="center">
						<td>
						<td>
						<p align="center"> 
							<a href="patient_form.php"><img src="images/add_patient_Center_Icon.png" width="60px"/></a><br>
							<a href="patient_form.php">Enregistrer un patient</a>
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
						 
							
						
						<?php if(checkAdmin() || clinicien() || pharmacien() || nurse()) {
				
											
							
							if(isset($_POST['doSubmit']) and($_POST['doSubmit'] == 'Supprimer'))
							{					
							
							mysqli_query($link, "DELETE FROM `dhappdatabase`.`vitalParameter` WHERE id='$post[id]'");
										
								$linkU="patient_followup_sheet.php?Code=".$post[serialNumber];
								redir($linkU);
							
							} 
							
							 if(isset($_POST['doSubmit']) and($_POST['doSubmit'] == 'Annuler'))
							{
								$linkU="patient_followup_sheet.php?Code=".$post[serialNumber];
								redir($linkU);
							
							}	
							?>
								  
								  <h3 class="titlehdr">Enregistrer les paramètres</h3>
								  <table width="80%" border="0" cellpadding="5" cellspacing="2" class="myaccount">
									<tr>
									  <td>
										<form name="vitalParameter_delete_form" method="post" action="vitalParameter_delete_form.php">
										
												
												
												<table style="width:100%;"  border=0>																									
													<tr>																							
														<td width=30%>
														<!-- id -->
														<input name="id" type="hidden" id="id" value="<?php echo $id;?>">
														<!-- id -->
														<!-- serialNumber -->
														<input name="serialNumber" type="hidden" id="serialNumber" value="<?php echo $serialNumber;?>">
														<span style="font-size: 4em; color: #057405;"><strong>
														<?php echo $serialNumber;?>
														</strong></span>
														<!-- serialNumber -->	
														</td>
														<td width=70%>
														<!-- serialNumber -->
														<span style="font-size: 4em; color: #f62b14;">
														<strong>
														<?php echo $patientARTCode;?>
														</strong></span>
														<!-- serialNumber -->	
														</td>
													</tr>																							
												</table>
												<table style="width:100%;"  border=0>
													<tr>																							
														<td width=100%>
															<fieldset>
																<legend></legend>
																<table style="width:100%;"  border=0>			
																	<tr>
																																			
																		<td width=30%>
																			<!-- weight -->																
																				Poids du patient (en Kg)
																				<input name="weight" type="number" id="weight" value="<?php echo $weight;?>">  
																			<!-- weight -->
																		</td>
																		
																		<!-- temperature -->																		
																		<td width=30%>																		
																			Temperature	(en °C)									
																			<input name="temperature" type="float" id="temperature" value="<?php echo $temperature;?>">																		
																		</td>
																		<!-- temperature -->
																																			
																		<!-- pulseRate -->																		
																		<td width=30%>													
																			Rythme Cardiaque
																			<input name="pulseRate" type="text" id="pulseRate" value="<?php echo $pulseRate;?>"> 
																		</td>
																		<!-- pulseRate -->
																		
																	</tr>
																	
																	<tr>
																		
																		<td width=30%>
																			<!-- height -->																
																				Taille du patient (en Cm)
																				<input name="height" type="number" id="height" value="<?php echo $height;?>">  
																			<!-- height -->
																		</td>
																		<!-- bloodPressure -->	
																		<td width=30%>													
																			Tension Atérielle
																			<input name="bloodPressure" type="text" id="bloodPressure" value="<?php echo $bloodPressure;?>"> 
																		</td>
																		<!-- bloodPressure -->
																		
																		
																		<!-- respirationRate -->																		
																		<td width=30%>													
																			Rythme Respiratoire
																			<input name="respirationRate" type="text" id="respirationRate" value="<?php echo $respirationRate;?>"> 
																		</td>
																		<!-- respirationRate -->
																	</tr>
																</table>
															</fieldset>	
														</td>
													</tr>											
												</table>
										<?php echo '<script>alert("Êtes-vous sure de vouloir supprimer cette information? si oui cliquez sur le bouton <OK> puis sur <Supprimer> pour confimer la supression");</script>';?>
										<table>
											<tr>
												
												<td><input name="doSubmit" type="submit" id="doSubmit" value="Supprimer"></td>
												<td><input name="doSubmit" type="submit" id="doSubmit" value="Annuler"></td>
											</tr>
										</table>
									</form>
								</td>
							</tr>
						 </table>
				<?php }
                else
					{
					header("Location: login.php");
					exit();
					}
				?>
						
			</div>
			
		</div>
	</div>
  
<!---------------------------------footer --------------------------------------------->
<?php	
include 'block_footer.php';	
?>	
<!---------------------------------# end footer ------------------------------------->





