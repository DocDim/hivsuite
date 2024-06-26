

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

$Codeget = $_GET['Code'];



 if (!empty($_POST['CodePatient'])or !empty($_GET['Code'])){
 
$sql = "SELECT * FROM `dhappdatabase`.`patient` WHERE `serialNumber`= '$Codeget' ";
$result = mysqli_query($link, $sql);

if(mysqli_num_rows($result)== 0){
	echo '<script>alert("Ce code n\'existe pas");</script>';	
	redir("patient_list.php");
	exit();
}
else{
while ($rrows = mysqli_fetch_array($result)) {	
			 
$serialNumber = $rrows['serialNumber'];	
$enrolmentDate = $rrows['enrolmentDate'];

$region = $rrows['region'];	
$facility = $rrows['facility'];

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
								<input name="doSubmit" type="submit" id="doSubmit" value="Dispenser" style="width: 95px;">							
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
						 
							
						
						<?php if(checkAdmin() || clinicien() || pharmacien() || nurse()) {
				
						 if(isset($_POST['doSubmit']) and($_POST['doSubmit'] == 'Mettre à jour'))
							{								
									if (isset($_POST['weight']) and isset($_POST['height'] ))
								{							
									$post[bmi]=	$post[weight]*10000/($post[height]*$post[height]);						
								}
									
							mysqli_query($link, "UPDATE `dhappdatabase`.`patient` 
										SET `region`='$post[region]', `enrolmentDate`='$post[enrolmentDate]', `patientARTCode`='$post[patientARTCode]', `artSartDate`='$post[artSartDate]', `city`='$post[city]', `areaVillage`='$post[areaVillage]', `profession`='$post[profession]', `patientFirstContact`='$post[patientFirstContact]', `patientSecondContact`='$post[patientSecondContact]', `Statut_matrimonial`='$post[Statut_matrimonial]', `nbr_enfant`='$post[nbr_enfant]', `nameOfcontactPerson`='$post[nameOfcontactPerson]', `contactStelephoneNum`='$post[contactPhoneNum]', `sex`='$post[sex]', `dateOfBirth`='$post[dateOfBirth]', `age`='$post[age]', `weight`='$post[weight]', `height`='$post[height]', `bmi`='$post[bmi]', `whoClinicalStage`='$post[whoClinicalStage]', `CD4Value`='$post[CD4Value]', `dateOfCD4`='$post[dateOfCD4]', `pregnancy`='$post[pregnancy]', `breatfeeding`='$post[breatfeeding]', `tbScreening`='$post[tbScreening]', `arvregimen`='$post[arvregimen]', `patientExitMode`='$post[patientExitMode]'
										WHERE serialNumber='$post[serialNumber]'");
										
										$linkU="patient_followup_sheet.php?Code=".$post[serialNumber];
										redir($linkU);
							
							} ?>
								  
								  <h3 class="titlehdr">Mettre à jour les information d'un patient</h3>
								  <table width="80%" border="0" cellpadding="5" cellspacing="2" class="myaccount">
									<tr>
									  <td><form name="patient_form" method="post" action="patient_update_form.php">
									  
											<!----------------------------------------------------------------------------->

											<fieldset  >
												<legend></legend>
												<table style="width:100%;"  border=1>
																									
													<tr>
																												
														<td width=25%>
														<!-- region -->	
														Région	
															<select  name="region"  id="region" style="width:210px;"  >
																<option><?php echo $region;?></option>			  
																<option value="RSM1">RSM1</option>
																<option value="RSM2">RSM2</option>													 
															</select>
														<!-- region -->		
														</td>
																								
														<td width=25%>
														<!-- facility -->
														Formation Sanitaire
															<select  name="facility"  id="facility" style="width:210px;"  >
																<option><?php echo $facility;?></option>		  
																													 
															</select>
															
														<!-- facility -->
														</td>
														<td width=25%>
														</td>
														<td width=25%>
														</td>
													</tr>
												</table>
											</fieldset>												
											<br> 
											<fieldset>
												<legend></legend>
											
												<table border=1>
														<tr>
														<td width=25%>
														<!-- serialNumber -->
														Code clinique du patient
															<input name="serialNumber" type="text" id="serialNumber" value="<?php echo $serialNumber;?>" readonly>
														<!-- serialNumber -->	
														</td>
														
														
														<td width=25%>
														<!-- Code -->
															Code pharmacie
															<input name="patientARTCode" type="text" id="patientARTCode" value="<?php echo $patientARTCode;?>">
														<!-- Code -->
														</td>														
															<td width=25%>
															<!--enrolmentDate-->
																Date d'enrollement
																<input name="enrolmentDate" type="date" id="enrolmentDate" style="width:210px;" value="<?php echo $enrolmentDate;?>">
															<!-- enrolmentDate -->
															</td>	
															<td width=25%>		
																<!-- date_test	 -->
																Date d'initiation au traitement
																<input name="artSartDate" type="date" id="artSartDate" style="width:210px;" value="<?php echo $artSartDate;?>">  
																<!-- date_test -->	
															</td>
																								
														
														</tr>				
												</table>	
												
												
												<table border=1>
													<tr>	<td width=25%>
															<!-- dateOfBirth	 -->
															Date de naissance
															<input name="dateOfBirth" type="date" id="dateOfBirth" style="width:210px;" value="<?php echo $dateOfBirth;?>">  
															<!-- dateOfBirth -->
														</td>
														
														<td width=25%>
															<!-- Age -->	
															Age 
															<input name="age" type="number" id="age" value="<?php echo $age;?>">  
															<!-- Age -->
														</td>
																														
														
														<td width=25%>
															<!-- Sexe -->
																Sexe <br>
																
																<?php if ($sex == 'M') {?>																
																	<input type="radio" name="sex" checked  value="M">Masculin<br>
																	<input type="radio" name="sex"  value="F">Feminin<br>
																<?php  }else { if ($sex == 'F') {?>																
																	<input type="radio" name="sex"  value="M" >Masculin<br>
																	<input type="radio" name="sex"  checked  value="F">Feminin<br>
																<?php }else {?>																
																	<input type="radio" name="sex"  value="M">Masculin<br>
																	<input type="radio" name="sex"  value="F">Feminin<br>	
																<?php }}?>
															<!-- Sexe -->	
														</td>
														<td width=25%>
															<!-- Profession -->
																Profession <br>
																<?php if ($profession == 'Mil') {?>																
																	<input type="radio" name="profession" checked  value="Mil">Militaire<br>
																	<input type="radio" name="profession"  value="Civil">Civil<br>
																<?php  }else { if ($profession == 'Civil') {?>																
																	<input type="radio" name="profession"  value="Mil" >Militaire<br>
																	<input type="radio" name="profession"  checked  value="Civil">Civil<br>
																<?php }else {?>																
																	<input type="radio" name="profession"  value="Mil">Militaire<br>
																	<input type="radio" name="profession"  value="Civil">Civil<br>	
																<?php }}?>
															<!-- Profession -->																
															
														</td>
														
														
													</tr>	
													<tr>									
														<td width=25%>
															<!-- city -->		
															Ville </br>
															<input name="city" type="text" id="city" value="<?php echo $city;?>">  
															<!-- city -->
														</td>
														
														<td width=25%>
															<!-- areaVillage -->
															Quartier <br>
															<input type="text" name="areaVillage" id="areaVillage" value="<?php echo $areaVillage;?>">
															<!-- areaVillage -->	
														</td>
														
														<td width=25%>
															<!-- patientContact	 -->
															N° Téléphone #1 </br>
															<input name="patientFirstContact" type="text" id="patientContact1" value="<?php echo $patientFirstContact;?>">  
															<!-- patientContact -->
														</td>
														<td width=25%>
															<!-- patientContact	 -->
															N° Téléphone #2</br>
															<input name="patientSecondContact" type="text" id="patientContact2" value="<?php echo $patientSecondContact;?>">  
															<!-- patientContact -->							
														</td>
														
													</tr>
													
											</fieldset>	
											
											<table>	
												<tr>														
													<td width=50%>
														<fieldset style="height: 110px;">
														<legend>Situation familliale</legend>	
														
															<table >	
																<tr>														
																		<td width=25%>
																			<!-- Statut_matrimonial	 -->	
																					Statut matrimonial<br>
																					
																			<?php if ($Statut_matrimonial == 'C') {?>																
																				<input type="radio" name="Statut_matrimonial" checked  value="C">Célibataire<br>
																				<input type="radio" name="Statut_matrimonial"  value="M">Marié(e)<br>
																				<input type="radio" name="Statut_matrimonial"  value="D">Divorcé(e)<br>
																			<?php  }else { if ($Statut_matrimonial == 'M') {?>																
																				<input type="radio" name="Statut_matrimonial"  value="C">Célibataire<br>
																				<input type="radio" name="Statut_matrimonial" checked  value="M">Marié(e)<br>
																				<input type="radio" name="Statut_matrimonial"  value="D">Divorcé(e)<br>
																			<?php }else { if ($Statut_matrimonial == 'D') {?>																
																				<input type="radio" name="Statut_matrimonial" value="C">Célibataire<br>
																				<input type="radio" name="Statut_matrimonial"  value="M">Marié(e)<br>
																				<input type="radio" name="Statut_matrimonial" checked  value="D">Divorcé(e)<br>
																			<?php }else {?>																			
																				<input type="radio" name="Statut_matrimonial"  value="C">Célibataire<br>
																				<input type="radio" name="Statut_matrimonial"  value="M">Marié(e)<br>
																				<input type="radio" name="Statut_matrimonial"  value="D">Divorcé(e)<br>
																			<?php }}}?>																					
																					
																			<!-- Statut_matrimonial	 -->												
																		</td>
																		<td width=25%>
																			<!-- nbr_enfant	 -->
																					Nombre d'enfant	de moins de 10 ans 
																					<input name="nbr_enfant" type="number" id="nbr_enfant" value="<?php echo $nbr_enfant;?>"> 
																					
																			<!-- nbr_enfant -->	
																		</td>
																	</tr>																
																</table>
																<p>	 
																</p>																
															</fieldset>
														</td>
													<td width=50%>
														<fieldset style="height: 110px;">
															<legend>Personne à contacter</legend>												
															<table >
																<tr>																					
																	<td width=25%>
																		<!-- nameOfcontactPerson -->																
																			Nom de la personne à contacter
																			<input name="nameOfcontactPerson" type="text" id="nameOfcontactPerson" value="<?php echo $nameOfcontactPerson;?>">  
																		<!-- nameOfcontactPerson -->
																	</td>
																	<td width=25%>
																		<!-- contactPhoneNum -->																
																			N° Téléphone
																			<input name="contactPhoneNum" type="text" id="contactPhoneNum" value="<?php echo $contactPhoneNum;?>">  
																		<!-- contactPhoneNum -->
																	</td>														
																</tr>																
															</table>
															<br>
															
														</fieldset>	
													</td>
												</tr>																
											</table>
										</fieldset>	
										<br>								   												
										<fieldset>
										<legend>Situation initiale du patient</legend>
											<table >
												<tr>																					
													<td width=25%>
														<!-- weight -->																
															Poids du patient (en Kg)
															<input name="weight" type="text" id="weight" value="<?php echo $weight;?>">  
														<!-- weight -->
													</td>
													<td width=25%>
														<!-- height -->																
															Taille du patient (en Cm)
															<input name="height" type="number" id="height" value="<?php echo $height;?>">  
														<!-- height -->
													</td>
													<td width=25%>
														<!-- bmi -->														
															Indice de masse corporelle (IMC)
															<input name="bmi" type="text" id="bmi" value="<?php echo $bmi;?>" readonly>  
														<!-- bmi -->
													</td>
													<td width=25%>
														<!-- whoClinicalStage -->																
															Stdae clinique OMS
															<input name="whoClinicalStage" type="number" id="whoClinicalStage" value="<?php echo $whoClinicalStage;?>">  
														<!-- whoClinicalStage -->
													</td>													
												</tr>										
													
													
												<tr>																					
													<td width=25%>
														<!-- CD4Value -->																
															CD4
															<input name="CD4Value" type="text" id="CD4Value" value="<?php echo $CD4Value;?>">  
														<!-- CD4Value -->
													</td>
													<td width=25%>
														<!-- dateOfCD4 -->																
															Date du CD4
															<input name="dateOfCD4" type="date" id="dateOfCD4" value="<?php echo $dateOfCD4;?>">  
														<!-- dateOfCD4 -->
													</td>
													<td width=25%>
														<!-- pregnancy -->																
															Grossesse ? <br>
															<?php if ($pregnancy == 'O') {?>
															<input type="radio" name="pregnancy" value="O"  checked>Oui<br>
															<input type="radio" name="pregnancy" value="N" >Non<br>
															<?php  }else { if ($pregnancy == 'N') {?>	
															<input type="radio" name="pregnancy" value="O"  >Oui<br>
															<input type="radio" name="pregnancy" value="N" checked>Non<br>
															<?php }else {?>
															<input type="radio" name="pregnancy" value="O" >Oui<br>
															<input type="radio" name="pregnancy" value="N" >Non<br>
															<?php }}?>	
														<!-- pregnancy -->
													</td>
													<td width=25%>
														<!-- breatfeeding -->																
															Allaitement ? <br>
															<?php if ($breatfeeding == 'O') {?>
															<input type="radio" name="breatfeeding" value="O"  checked>Oui<br>
															<input type="radio" name="breatfeeding" value="N" >Non<br>
															<?php  }else { if ($breatfeeding == 'N') {?>	
															<input type="radio" name="breatfeeding" value="O"  >Oui<br>
															<input type="radio" name="breatfeeding" value="N" checked>Non<br>
															<?php }else {?>
															<input type="radio" name="breatfeeding" value="O"  >Oui<br>
															<input type="radio" name="breatfeeding" value="N" >Non<br>
															<?php }}?>	
														<!-- breatfeeding -->
													</td>													
												</tr>
												
												<tr>																					
													<td width=25%>
														<!-- tbScreening -->																
															TB Screening ? <br>
															<?php if ($tbScreening == 'O') {?>
															<input type="radio" name="tbScreening" value="O"  checked>Oui<br>
															<input type="radio" name="tbScreening" value="N" >Non<br>
															<?php  }else { if ($tbScreening == 'N') {?>	
															<input type="radio" name="tbScreening" value="O"  >Oui<br>
															<input type="radio" name="tbScreening" value="N" checked>Non<br>
															<?php }else {?>
															<input type="radio" name="tbScreening" value="O"  >Oui<br>
															<input type="radio" name="tbScreening" value="N" >Non<br>
															<?php }}?>	
														<!-- tbScreening -->
													</td>	
													<td width=25%>
														<!-- arvregimen -->																
															Ligne de traitement															
																<select  name="arvregimen"  id="arvregimen">
																		<option><?php echo $arvregimen;?></option>											  
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
														<!-- arvregimen -->
													</td>
													<td width=25%>
														<!-- patientExitMode -->
															Devenue du patinet
															<input name="patientExitMode" type="text" id="patientExitMode" value="<?php echo $patientExitMode;?>">  
														<!-- patientExitMode -->
													</td>
													<td width=25%>
														
													</td>
																									
												</tr>
													
											</table>	
												
										</fieldset>	
										<table>
											<tr>
												<td><input name="doSubmit" type="submit" id="doSubmit" value="Mettre à jour"></td>
												<td></td>
											</tr>
										</table>

<!----------------------------------------------------------------------------->										
										
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



