

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


$Code = $_GET['Code'];


 if (!empty($_GET['Code'])){
 
$sql = "SELECT * FROM `dhappdatabase`.`patient`  WHERE `serialNumber`= '$Code' ";
$result = mysqli_query($link, $sql);


if(mysqli_num_rows($result)== 0){
	echo '<script>alert("Ce code n\'existe pas");</script>';	
	redir("htc_list.php");
	exit();
}
else{

while ($rrows = mysqli_fetch_array($result)) {

$serialNumber = $rrows['serialNumber'];	
$patientARTCode = $rrows['patientARTCode'];	

$artSartDate = $rrows['artSartDate'];	
$city = $rrows['city'];	
$areaVillage = $rrows['areaVillage'];	
$profession = $rrows['profession'];	
	
$Statut_matrimonial = $rrows['Statut_matrimonial'];	
$nbr_enfant = $rrows['nbr_enfant'];	
$patientFirstContact = $rrows['patientFirstContact'];	
$patientSecondContact = $rrows['patientSecondContact'];	
$nameOfcontactPerson = $rrows['nameOfcontactPerson'];	
$contactPhoneNum = $rrows['contactStelephoneNum'];	

$sex = $rrows['sex'];	
$dateOfBirth = $rrows['dateOfBirth'];	
$age = $rrows['age'];	
$weight = $rrows['weight'];	
$height = $rrows['height'];	
$bmi = $rrows['bmi'];	
$whoClinicalStage = $rrows['whoClinicalStage'];	
$CD4Value = $rrows['CD4Value'];	
$dateOfCD4 = $rrows['dateOfCD4'];	
$pregnancy = $rrows['pregnancy'];	
$breatfeeding = $rrows['breatfeeding'];	
$tbScreening = $rrows['tbScreening'];	
$arvregimen = $rrows['arvregimen'];	
$patientExitMode = $rrows['patientExitMode'];	
	
 }
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
				
						if(isset($_POST['doSubmit']) and($_POST['doSubmit'] == 'Enregistrer'))
							{								
								
							$post[bmi]=	$post[weight]*10000/($post[height]*$post[height]);	
							
							mysqli_query($link,"INSERT INTO `dhappdatabase`.`vitalParameter` (`id`, `serialNumber`, `dateOfRecord`, `height`, `weight`, `bmi`, `temperature`, `bloodPressure`, `pulseRate`, `respirationRate`) 
							VALUES ('','$post[serialNumber]','$post[dateOfRecord]','$post[height]','$post[weight]','$post[bmi]','$post[temperature]','$post[bloodPressure]','$post[pulseRate]','$post[respirationRate]')");
							
							$linkU="patient_followup_sheet.php?Code=".$post[serialNumber];
							redir($linkU);
							
							} ?>
								  
								  <h3 class="titlehdr">Enregistrer les paramètres</h3>
								  <table width="80%" border="0" cellpadding="5" cellspacing="2" class="myaccount">
									<tr>
									  <td>
										<form name="vitalParameter_add_form.php" method="post" action="vitalParameter_add_form.php">
										
												
												
												<table style="width:100%;"  border=0>																									
													<tr>																							
														<td width=30%>
														<input name="dateOfRecord" type="hidden" id="dateOfRecord" value="<?php echo date("Y-m-d");?>" >
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
																				<input name="weight" type="number" id="weight" >  
																			<!-- weight -->
																		</td>
																		
																		<!-- temperature -->																		
																		<td width=30%>																		
																			Temperature	(en °C)									
																			<input name="temperature" type="float" id="temperature" >																		
																		</td>
																		<!-- temperature -->
																																			
																		<!-- pulseRate -->																		
																		<td width=30%>													
																			Rythme Cardiaque
																			<input name="pulseRate" type="text" id="pulseRate" > 
																		</td>
																		<!-- pulseRate -->
																		
																	</tr>
																	
																	<tr>
																		
																		<td width=30%>
																			<!-- height -->																
																				Taille du patient (en Cm)
																				<input name="height" type="number" id="height" >  
																			<!-- height -->
																		</td>
																		<!-- bloodPressure -->	
																		<td width=30%>													
																			Tension Atérielle
																			<input name="bloodPressure" type="text" id="bloodPressure" > 
																		</td>
																		<!-- bloodPressure -->
																		
																		
																		<!-- respirationRate -->																		
																		<td width=30%>													
																			Rythme Respiratoire
																			<input name="respirationRate" type="text" id="respirationRate" > 
																		</td>
																		<!-- respirationRate -->
																	</tr>
																</table>
															</fieldset>	
														</td>
													</tr>											
												</table>
										<table>
											<tr>
												<td><input name="doSubmit" type="submit" id="doSubmit" value="Enregistrer"></td>
												<td></td>
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





