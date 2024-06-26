

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




if (!empty($_GET['Code'])){
$Code = $_GET['Code'];
 
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
						 
							
						
						<?php if(checkAdmin() || clinicien() || pharmacien() || nurse()) { ?>
								  
								<h3 class="titlehdr">Fiche de suivi du patient</h3>
								<table width="80%" border="0" cellpadding="5" cellspacing="2" class="myaccount">
									<tr>
										<td>
													<table style="width:100%;"  border=0>												
														<tr>																						
															<td width=30%>
															<!-- serialNumber -->
															<input name="serialNumber" type="hidden" id="serialNumber" value="<?php echo $serialNumber;?>">
															<span style="font-size: 3em; color: #057405;"><strong>
															<?php echo $serialNumber;?>
															</strong></span>
															<!-- serialNumber -->	
															</td>
															<td width=60%>
															<!-- serialNumber -->
															<span style="font-size: 3em; color: #f62b14;">
															<strong>
															<?php echo $patientARTCode;?>
															</strong></span>
															<!-- serialNumber -->	
															</td>
															<td width=20%>
															<!-- patientExitMode -->
															<span style="font-size: 3em; color: #f62b14;">
															<strong>
															<?php echo $patientExitMode;?>
															</strong></span>
															<!-- patientExitMode -->	
															</td>
														</tr>	
													</table>
													<table style="width:100%;"  border=0>												
														<tr>																						
															<td width=40%>	
																<p>
																	<span style="font-size: 1em; "> <strong>Sexe : </strong><?php echo $sex;?> </span>
																</p>
																<p>
																	<span style="font-size: 1em; ">  <strong>Date de naissance : </strong><?php echo $dateOfBirth;?><strong></span>
																</p>
																<p>
																	<span style="font-size: 1em; "> <strong><strong>Age : </strong>
																	<?php 
																	if(isset($dateOfBirth)){
																	$ag= date("Y")- date('Y', strtotime($dateOfBirth)); 
																	echo $ag;
																	} else echo $age; 
																	?></span>
																</p>
															</td>
																							
															<td width=40%>	
																<p>
																	<span style="font-size: 1em; "> <strong>Tel. : </strong><?php echo $patientFirstContact." / ".$patientSecondContact;?> </span>
																</p>
																<p>
																	<span style="font-size: 1em; "> <strong>Ville : </strong><?php echo $city;?></span>
																</p>
																<p>
																	<span style="font-size: 1em; "> <strong>Quartier : </strong><?php echo $areaVillage;?></span>
																</p>
															</td>
															<td width=20%>
															<?php if(checkAdmin() || clinicien() || pharmacien()) { ?>
																	<a href="patient_update_form.php?Code=<?php echo $Code; ?>" class="button">Mettre à jour les informations</a>
																	<?php }		?>	
															</td>															
														</tr>															
													</table>
													<table style="width:100%;"  border=0>												
														<tr>																				
															
															<td width=50%>
																<fieldset >
																	<legend><strong> &nbsp;Rendez-vous&nbsp;</strong> </legend>
																	<?php 
																	  
																		$sql1 = "SELECT * FROM `dhappdatabase`.`dispensation`  WHERE `serialNumber`= '$serialNumber' ORDER BY `nextPickupDate` DESC"; 
																		$rs_total = mysqli_query($link, $sql1);
																		if (!$rs_total) {
																			printf("Error: %s\n", mysqli_error($con));
																			exit();
																		}																		
																	?>
																	<div style="overflow:auto; height:186px;">
																	<table width="100%" border="0" align="center" cellpadding="2" cellspacing="0">
																		<tr bgcolor="#E6F3F9"> 
																			<td width="10%"><strong>ID</strong></td>
																			<td > <strong>Date visite </strong></td>
																			<td ><strong>Rendez-vous</strong></td>
																			<td ><strong>Protocole</strong></td>
																			<td ><strong>Quantité</strong></td>
																			<td ><strong>Action</strong></td>
																		</tr>
																		 <?php $li=1; while ($rrows = mysqli_fetch_array($rs_total)) {?>
																		<tr bgcolor="<?php if ($li%2==0) {echo '#E6F3F9';} ?>"> 
																			<td><?php echo $rrows['id'];?></td>
																			<td><?php echo $rrows['dataOfPickup']; ?></td>
																			<td><?php echo $rrows['nextPickupDate']; ?></td>
																			<td><?php echo $rrows['regimen'];?></td>
																			<td><?php echo $rrows['nbBox'];?></td>
																			<td>
																				<a href="dispensation_update_form.php?id=<?php echo $rrows['id'];?>">Modifier</a> | 
																				<a href="dispensation_delete_form.php?id=<?php echo $rrows['id'];?>">Supprimer</a> 
																			</td>
																		</tr>         
																		<?php $li++;} ?>
																	</table>
																	</div>
																	<?php if(checkAdmin() || clinicien() || pharmacien()) { ?>
																	<a href="dispensation_form.php?Code=<?php echo $Code; ?>" class="button">Ajouter une visite</a>
																	<?php }		?>	
																</fieldset>	
																
																<fieldset >
																	<legend><strong> &nbsp;Paramètres vitaux&nbsp;</strong> </legend>
																	<?php 
																	  
																		$sql1 = "SELECT * FROM `dhappdatabase`.`vitalParameter`  WHERE `serialNumber`= '$serialNumber' ORDER BY `dateOfRecord` DESC"; 
																		$rs_total = mysqli_query($link, $sql1);
																		if (!$rs_total) {
																			printf("Error: %s\n", mysqli_error($link));
																			exit();
																		}
																		
																	?>
																	<div style="overflow:auto; height:186px;">
																	<table width="100%" border="0" align="center" cellpadding="2" cellspacing="0">
																		<tr bgcolor="#E6F3F9"> 
																			<td width="10%"><strong>ID</strong></td>
																			<td > <strong>Date enregistrement </strong></td>
																			<td ><strong>IMC</strong></td>
																			<td ><strong>Température</strong></td>
																			<td ><strong>TA</strong></td>
																			<td ><strong>Action</strong></td>
																		</tr>
																		 <?php $li=1; while ($rrows = mysqli_fetch_array($rs_total)) {?>
																		<tr bgcolor="<?php if ($li%2==0) {echo '#E6F3F9';} ?>"> 
																			<td><?php echo $rrows['id'];?></td>
																			<td><?php echo $rrows['dateOfRecord']; ?></td>
																			<td><?php echo $rrows['bmi']; ?></td>
																			<td><?php echo $rrows['temperature'];?></td>
																			<td><?php echo $rrows['bloodPressure'];?></td>
																			<td>
																				<a href="vitalParameter_update_form.php?id=<?php echo $rrows['id'];?>">Modifier</a> | 
																				<a href="vitalParameter_delete_form.php?id=<?php echo $rrows['id'];?>">Supprimer</a> 
																			</td>
																		</tr>         
																		<?php $li++;} ?>
																	</table>
																	</div>
																	<a href="vitalParameter_add_form.php?Code=<?php echo $Code; ?>" class="button">Prendre les paramètres</a>
																</fieldset>	
															</td>
															<td width=50%>
																<?php if(checkAdmin() || clinicien()) { ?>
																<fieldset >
																	<legend><strong>&nbsp;Examens&nbsp;</strong></legend>
																	
																	<?php 
																	  
																		$sql1 = "SELECT * FROM `dhappdatabase`.`viralLoad`  WHERE `serialNumber`= '$serialNumber' ORDER BY `dateOfsample` DESC"; 
																		$rs_total = mysqli_query($link, $sql1);
																		if (!$rs_total) {
																			printf("Error: %s\n", mysqli_error($link));
																			exit();
																		}
																	
																	?>
																	<p><strong> Charges Virales</strong></p>
																	<div style="overflow:auto; height:180px;">
																	<table width="100%" border="0" align="center" cellpadding="2" cellspacing="0" >
																		<tr bgcolor="#E6F3F9"> 
																			<td width="10%"><strong>ID</strong></td>
																			<td ><strong>Date prélèvement</strong></td>
																			<td ><strong>Date resultat</strong></td>
																			<td ><strong>Nombre de Copie</strong></td>
																			<td ><strong>Action</strong></td>
																		</tr>
																		 <?php $li=1; 
																		 while ($rrows = mysqli_fetch_array($rs_total)) {?>
																		<tr bgcolor="<?php if ($li%2==0) {echo '#E6F3F9';} ?>"> 
																			<td><?php echo $rrows['id'];?></td>
																			<td><?php echo $rrows['dateOfsample']; ?></td>
																			<td><?php echo $rrows['dateOfresult']; ?></td>
																			<td><?php echo $rrows['vlCount'];?></td>
																			<td>
																				<a href="vl_update_form.php?id=<?php echo $rrows['id'];?>">Modifier</a> | 
																				<a href="vl_delete_form.php?id=<?php echo $rrows['id'];?>">Supprimer</a> 
																			</td>
																		</tr>         
																		<?php $li++;} ?>
																	</table>
																	</div>
																	
																	<a href="vl_add_form.php?Code=<?php echo $Code; ?>" class="button">Ajouter une CV</a>
																	<div style="overflow:auto; height:180px;">
																	<?php 
																	  
																		$sql1 = "SELECT * FROM `dhappdatabase`.`cd4`  WHERE `serialNumber`= '$serialNumber' ORDER BY `dateOfsample` DESC"; 
																		$rs_total = mysqli_query($link, $sql1);
																		$total = mysqli_num_rows($rs_total);
																		if (!$rs_total) {
																			printf("Error: %s\n", mysqli_error($link));
																			exit();
																		}
																	?>
																	
																	<p><strong> CD4</strong></p>
																	<table width="100%" border="0" align="center" cellpadding="2" cellspacing="0">
																		<tr bgcolor="#E6F3F9"> 
																			<td width="10%"><strong>ID</strong></td>
																			<td ><strong>Date prélèvement</strong></td>
																			<td ><strong>Date resultat</strong></td>
																			<td ><strong>Valeur</strong></td>
																			<td ><strong>Action</strong></td>
																		</tr>
																		 <?php $li=1; while ($rrows = mysqli_fetch_array($rs_total)) {?>
																		<tr bgcolor="<?php if ($li%2==0) {echo '#E6F3F9';} ?>"> 
																			<td><?php echo $rrows['id'];?></td>
																			<td><?php echo $rrows['dateOfsample']; ?></td>
																			<td><?php echo $rrows['dateOfresult']; ?></td>
																			<td><?php echo $rrows['cd4Count'];?></td>
																			<td>
																				<a href="cd4_update_form.php?id=<?php echo $rrows['id'];?>">Modifier</a> | 
																				<a href="cd4_delete_form.php?id=<?php echo $rrows['id'];?>">Supprimer</a> 
																			</td>
																		</tr>         
																		<?php $li++;} ?>
																	</table>
																	</div>
																	<a href="cd4_add_form.php?Code=<?php echo $Code; ?>" class="button">Ajouter un CD4</a>
																	
																</fieldset>
																<?php }		?>														
															</td>
														</tr>
													</table>
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





