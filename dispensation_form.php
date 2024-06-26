<?php 
include 'dbc.php';
page_protect();

if(!checkAdmin() and !clinicien() and !pharmacien()) {
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
$login_path = @preg_replace('admin','',dirname($_SERVER['PHP_SELF']));
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
	redir("patient_list.php");
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
				if(checkAdmin() || clinicien() || pharmacien() ) {
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
				<fieldset>
					<legend>Dispensation et Suivi</legend>	
					<form name="diepensation_route" method="post" action="dispensation_routing.php">
					<table>						
						<tr>
							<td >
							<!-- Code -->									
								<input name="Code" type="text" id="Code" placeholder="Entrez le Code du patient">			
							<!-- Code -->				
								
							</td>														
							
						</tr>						
					</table>
					<table>						
						<tr>							
							<td style="float:left;">
								<?php if(checkAdmin() || clinicien() || pharmacien()) { ?>
								<input name="doSubmit" type="submit" id="doSubmit" value="Dispenser" style="width: 95px;">	
								<?php } ?>
							</td>	
							<td style="float:left;">							
								<input name="doSubmit" type="submit" id="doSubmit" value="Afficher" style="width: 95px;" >							
							</td>						
							
						</tr>						
					</table>
					</form>
				</fieldset>			
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
						 
							
						
						<?php if(checkAdmin() || clinicien() || pharmacien() ) {
				
						if(isset($_POST['doSubmit']) and($_POST['doSubmit'] == 'Enregistrer'))
							{
							
							
							$req=mysqli_query($link, "INSERT INTO `dhappdatabase`.`dispensation` (`id`, `serialNumber`, `dataOfPickup`, `nextPickupDate`, `regimen`, `nbBox`) 
							
							VALUES ('','$post[serialNumber]','$post[dataOfPickup]','$post[nextPickupDate]','$post[regimen]','$post[nbBox]')"); 
							if (!$req) {
								echo $serialNumber;
								die(mysqli_error($req));
							}

							$req1=mysqli_query($link,"UPDATE `dhappdatabase`.`patient` 
										SET `lastVisit`='$post[dataOfPickup]', `nextVisit`='$post[nextPickupDate]' WHERE serialNumber='$post[serialNumber]'");
							
							if (!$req1) {
								echo $serialNumber;
								die(mysqli_error($req1));
							}
							
							$linkU="patient_followup_sheet.php?Code=".$post[serialNumber];
							redir($linkU);
							} ?>
								  
								  <h3 class="titlehdr">Dispensation</h3>
								  <table width="80%" border="0" cellpadding="5" cellspacing="2" class="myaccount">
									<tr>
									  <td><form name="dispensation_form" method="post" action="dispensation_form.php">
											
											
											<fieldset  >
												<legend></legend>
												<table style="width:100%;"  border=0>
																									
													<tr>																							
														<td width=30%>
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
														<td width=50%>
												
														<fieldset  >
														<legend>Rendez-vous</legend>
															<table style="width:100%;"  border=0>
																											
																<tr>										
																	<!-- dataOfPickup -->
																	<td width=50%>
																	
																		Date de visite													
																	
																	</td>
																	<td width=50%>
																	
																		<input name="dataOfPickup" type="date" id="dataOfPickup" >
																	
																	</td>
																	<!-- dataOfPickup -->
																	
																</tr>
																<tr>
																	<!-- nextPickupDate -->													
																	<td width=50%>
																	
																		Date du prochain rendez-vous															
																	</td>
																	<td width=50%>								
																		
																		<input name="nextPickupDate" type="date" id="nextPickupDate" >
																	
																	</td>
																	<!-- nextPickupDate -->
																</tr>
															</table>
														</fieldset>
														</td>
														
														<td width=50%>
														<fieldset  >
														<legend>Médicament</legend>
														<table style="width:100%;"  border=0>
																											
															<tr>										
																<!-- dataOfPickup -->
																<td width=50%>
																
																	Protocole servi													
																
																</td>
																<td width=50%>
																	<select  name="regimen"  id="regimen">
																		<option></option>											  
																		<option value="1A">TDF/FTC+EFV</option>
																		<option value="2A">TDF/3TC/EFV</option>
																		<option value="3A">AZT/3TC+EFV</option>
																		<option value="4A">AZT/3TC/NVP</option>
																		<option value="5A">TDF/3TC/NVP</option>
																		<option value="6A">ABC+3TC+EFV</option>
																		<option value="7A">ABC+3TC+NVP</option>
																		<option value="8A">AZT+3TC+LPV/r ou ATZ/r</option>
																		<option value="9A">ABC+3TC+LPV/r ou ATZ/r</option>
																		<option value="12A">TDF+3TC+ATV/r</option>
																		<option value="1E">ABC+3TC+LPV/r</option>
																		<option value="2E">AZT+3TC+LPV/r</option>
																		<option value="3E">ABC+3TC+EFV</option>
																		<option value="4E">AZT+3TC+EFV</option>
																		<option value="5E">TDF+3TC(FTC)+EFV</option>
																		<option value="6E">ABC+3TC+NVP</option>
																		<option value="7E">AZT+3TC+NVP</option>
																		<option value="8E">TDF+3TC(FTC)+NVP</option>
																		<option value="9E">ABC+3TC+LPV/r</option>
																		<option value="10E">AZT+3TC+LPV/r</option>
																		<option value="11E">ABC(AZT)+3TC+EFV</option>
																		<option value="12E">ABC(AZT)+3TC+ATV/r</option>
																		<option value="13E">TDF+3TC+EFV</option>
																		<option value="1C">DRV/r+RAL+ETV</option>				 
																	</select>
																</td>
																<!-- dataOfPickup -->
																
															</tr>
															<tr>
																<!-- nextPickupDate -->													
																<td width=50%>
																
																	Nombre de boîte															
																</td>
																<td width=50%>								
																	
																	<input name="nbBox" type="number" id="nbBox" >
																
																</td>
																<!-- nextPickupDate -->
															</tr>
														</table>
															
														</fieldset>														
														</td>
																
														</tr>
													</table>	
												</fieldset>											
											
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





