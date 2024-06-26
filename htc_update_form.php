

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



function redir($url){
		echo '<script language="javascript">';
		echo 'window.location="',$url,'";';
	    echo '</script>';
} 


$Code = $_POST['Code_patient'];

 if (!empty($_POST['Code_patient'])){
 
$sql = "SELECT * FROM `dhappdatabase`.`htc`  WHERE `patientCode`= '$Code' ";
$result = mysql_query($sql) or die(mysql_error());


if(mysql_num_rows($result)== 0){
	echo '<script>alert("Ce code n\'existe pas");</script>';	
	redir("htc_list.php");
	exit();
}
else{

while ($rrows = mysql_fetch_array($result)) {
	
$num=$rrows['num'];
$dateOftest=$rrows['dateOftest'];
$region=$rrows['region'];
$facility=$rrows['facility'];
$unit=$rrows['unit'];
$documentSource=$rrows['documentSource'];
$patientCode=$rrows['patientCode'];
$age=$rrows['age'];
$sex=$rrows['sex'];
$profession=$rrows['profession'];
$knowPrevStatus=$rrows['knowPrevStatus'];
$prevStatut=$rrows['prevStatut'];
$reasonTest=$rrows['reasonTest'];
$newStatus=$rrows['newStatus'];
$retrivedResults=$rrows['retrivedResults'];
$nameOfConsellor=$rrows['nameOfConsellor'];
$referral=$rrows['referral'];
$treatmentCenter=$rrows['treatmentCenter'];
$treatmentCode=$rrows['treatmentCode'];
$referredBy=$rrows['referredBy'];	
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
				if (checkAdmin()) {
				/*******************************END**************************/
				?>
				<h2 id="block_entete" >Dépistage </h2>
				<table>
					<tr>
						<td>
						<p align="center"> 
							<a href="htc_list.php"><img src="images/HIVTest_list.png" width="65px"/></a><br>
							<a href="htc_list.php">Liste des test </a>
						</p align="center">
						<td>
						<td>
						<p align="center"> 
							<a href="htc_form.php"><img src="images/HIVTest_add.png" width="60px"/></a><br>
							<a href="htc_form.php">Enregistrer un test</a>
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
				
						 if($_POST['doSubmit'] == 'Mettre à jour')
							{
														 
							mysql_query("UPDATE `dhappdatabase`.`htc` 
										SET  `dateOftest`= '$post[dateOftest]', `region`= '$post[region]', `facility`='$post[facility]', `unit`='$post[unit]', `documentSource`='$post[documentSource]', `patientCode`='$post[patientCode]', `age`='$post[age]', `sex`='$post[sex]', `profession`='$post[profession]', `knowPrevStatus`='$post[knowPrevStatus]', `prevStatut`='$post[prevStatut]', `reasonTest`='$post[reasonTest]', `newStatus`='$post[newStatus]', `retrivedResults`='$post[retrivedResults]', `nameOfConsellor`='$post[nameOfConsellor]', `referral`='$post[referral]', `treatmentCenter`='$post[treatmentCenter]', `treatmentCode`='$post[treatmentCode]', `referredBy`='$post[referredBy]' 
										WHERE patientCode='$post[patientCode]'")or die(mysql_error());
							
							redir("htc_list.php");
							} ?>
								  
								  <h3 class="titlehdr">Enregistrer un test</h3>
								  <table width="80%" border="0" cellpadding="5" cellspacing="2" class="myaccount">
									<tr>
									  <td>	
										<form name="htc_form" method="post" id="htc_form" action="htc_update_form.php">	

											<fieldset >
												<legend></legend>
												<table style="width:100%;"  >
													
													<tr>
														<!--dateOftest-->
														<td>	
															Date du test																								
														</td>
														<td>
															<input name="dateOftest" type="date" id="dateOftest" style="width:200px;" value= "<?php echo $dateOftest;?>"> 
														</td>	
														<!-- dateOftest -->
														
														<td>	
															Document source																						
														</td>
														<td >
															<!-- documentSource -->
															<input name="documentSource" type="text" id="documentSource" style="width:200px;" value= "<?php echo $documentSource;?>">												
															<!-- documentSource -->
														</td>
														<td>	
																																				
														</td>	
														<td>	
																																				
														</td>	
														
													</tr>	
													
													<tr>
														<!--region-->
														<td>	
															Région																								
														</td>
														<td>
															<select  name="region"  id="region" style="width:200px;"  >
																<option><?php echo $region;?></option>																	  
																<option value="RSM1">RSM1</option>
																<option value="RSM2">RSM2</option>													 
															</select> 
														</td>
														<!-- region -->
														
														<!--facility-->
														<td>	
															Formation Sanitaire																							
														</td>														
														<td>
															<select  name="facility"  id="facility" style="width:200px;" onfocus="formationFunction()" >
																<option><?php echo $facility;?></option>
															</select>
														</td>
														<!-- facility -->	
															<!--unit-->
														<td>	
															Unité																						
														</td>														
														<td>
															<input type="text"  name="unit"  id="unit" style="width:200px;"  value= "<?php echo $unit;?>">
														</td>
														<!-- unit -->	
														
													</tr>
												</table>
											</fieldset>	

											<br>
										
											<fieldset>
												<legend></legend>												
												
												<table >
													<tr>															
														<td width=25%>
															<!-- Code -->																
																Code du patient / client * 
																<input name="patientCode" type="text" id="patientCode" value= "<?php echo $patientCode;?>" readonly>
															<!-- Code -->
														</td>
														
														<td width=25%>
															<!-- age -->
																Age 
																<input name="age" type="number" id="age" value= "<?php echo $age;?>">  
															<!-- age -->
														</td>
														
														<td width=25%>
															<!-- Sexe -->
																Sexe :<br>
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
																Profession 
																<input name="profession" type="text" id="profession" value= "<?php echo $profession;?>" >  
															<!-- Profession -->	
														</td>
													</tr>
													</table>
													<br>
													<table>
													<tr>
														<td width=25%>
															<!-- knowPrevStatus	 -->
																	Statut pr&eacute;c&eacute;dent connu?<br>
																	<?php if ($knowPrevStatus == 'O') {?>																
																	<input type="radio" name="knowPrevStatus" checked  value="O">Oui<br>
																	<input type="radio" name="knowPrevStatus"  value="N">Non<br>
																	<?php  }else { if ($knowPrevStatus == 'N') {?>																
																		<input type="radio" name="knowPrevStatus"  value="O" >Oui<br>
																		<input type="radio" name="knowPrevStatus"  checked  value="N">Non<br>
																	<?php }else {?>																
																		<input type="radio" name="knowPrevStatus"  value="O">Oui<br>
																		<input type="radio" name="knowPrevStatus"  value="N">Non<br>	
																	<?php }}?>			
															<!-- knowPrevStatus	 -->												
														</td>
														<td width=25%>
															<!-- prevStatut	 -->
																	Statut précédent<br>																
																	
																	<?php if ($prevStatut == 'Pos') {?>																
																				<input type="radio" name="prevStatut" checked  value="Pos">Positif<br>
																				<input type="radio" name="prevStatut"  value="Neg">N&eacute;gatif<br>
																				<input type="radio" name="prevStatut"  value="Ind">Ind&eacute;termin&eacute;<br>
																			<?php  }else { if ($prevStatut == 'Neg') {?>																
																				<input type="radio" name="prevStatut"  value="Pos">Positif<br>
																				<input type="radio" name="prevStatut" checked  value="Neg">N&eacute;gatif<br>
																				<input type="radio" name="prevStatut"  value="Ind">Ind&eacute;termin&eacute;<br>
																			<?php }else { if ($prevStatut == 'Ind') {?>																
																				<input type="radio" name="prevStatut" value="Pos">Positif<br>
																				<input type="radio" name="prevStatut"  value="Neg">N&eacute;gatif<br>
																				<input type="radio" name="prevStatut" checked  value="Ind">Ind&eacute;termin&eacute;<br>
																			<?php }else {?>																			
																				<input type="radio" name="prevStatut"  value="Pos">Positif<br>
																				<input type="radio" name="prevStatut"  value="Neg">N&eacute;gatif<br>
																				<input type="radio" name="prevStatut"  value="Ind">Ind&eacute;termin&eacute;<br>
																	<?php }}}?>		
																	
															<!-- prevStatut	 -->												
														</td>
														<td width=25%>
															<!-- reasonTest	 -->
																	Raison du test<br>
																	
																	<?php if ($reasonTest == 'VCT') {?>
																	<input type="radio" name="reasonTest" value="PITC" >PITC<br>
																	<input type="radio" name="reasonTest" value="VCT"  checked>VCT<br>
																	
																	<?php  }else { if ($reasonTest == 'PITC') {?>
																	<input type="radio" name="reasonTest" value="PITC" checked>PITC<br>
																	<input type="radio" name="reasonTest" value="VCT"  >VCT<br>
																	
																	<?php }else {?>
																	<input type="radio" name="reasonTest" value="PITC" >PITC<br>
																	<input type="radio" name="reasonTest" value="VCT" >VCT<br>
																	
																	<?php }}?>																		
															<!-- reasonTest	 -->												
														</td>
														<td width=25%>
															<!-- newStatus	 -->
																	Nouveau Statut<br>
																	<?php if ($newStatus == 'Pos') {?>																
																				<input type="radio" name="newStatus" checked  value="Pos">Positif<br>
																				<input type="radio" name="newStatus"  value="Neg">N&eacute;gatif<br>
																				<input type="radio" name="newStatus"  value="Ind">Ind&eacute;termin&eacute;<br>
																			<?php  }else { if ($newStatus == 'Neg') {?>																
																				<input type="radio" name="newStatus"  value="Pos">Positif<br>
																				<input type="radio" name="newStatus" checked  value="Neg">N&eacute;gatif<br>
																				<input type="radio" name="newStatus"  value="Ind">Ind&eacute;termin&eacute;<br>
																			<?php }else { if ($newStatus == 'Ind') {?>																
																				<input type="radio" name="newStatus" value="Pos">Positif<br>
																				<input type="radio" name="newStatus"  value="Neg">N&eacute;gatif<br>
																				<input type="radio" name="newStatus" checked  value="Ind">Ind&eacute;termin&eacute;<br>
																			<?php }else {?>																			
																				<input type="radio" name="newStatus"  value="Pos">Positif<br>
																				<input type="radio" name="newStatus"  value="Neg">N&eacute;gatif<br>
																				<input type="radio" name="newStatus"  value="Ind">Ind&eacute;termin&eacute;<br>
																	<?php }}}?>	
															<!-- newStatus	 -->												
														</td>	
													</tr>	
													</table>
													<br>
													<table>
													<tr>
													   
														<td width=25%>
															<!-- retrivedResults	 -->
																	Résultat retiré?<br>
																	
																	<?php if ($retrivedResults == 'O') {?>																
																	<input type="radio" name="retrivedResults" checked  value="O">Oui<br>
																	<input type="radio" name="retrivedResults"  value="N">Non<br>
																	<?php  }else { if ($retrivedResults == 'N') {?>																
																		<input type="radio" name="retrivedResults"  value="O" >Oui<br>
																		<input type="radio" name="retrivedResults"  checked  value="N">Non<br>
																	<?php }else {?>																
																		<input type="radio" name="retrivedResults"  value="O">Oui<br>
																		<input type="radio" name="retrivedResults"  value="N">Non<br>	
																	<?php }}?>		
																		
															<!-- retrivedResults	 -->												
														</td>
														
														<td width=25%>
															<!-- referral	 -->
																	Reféré ?<br>
																	<?php if ($referral == 'O') {?>																
																	<input type="radio" name="referral" checked  value="O">Oui<br>
																	<input type="radio" name="referral"  value="N">Non<br>
																	<?php  }else { if ($referral == 'N') {?>																
																		<input type="radio" name="referral"  value="O" >Oui<br>
																		<input type="radio" name="referral"  checked  value="N">Non<br>
																	<?php }else {?>																
																		<input type="radio" name="referral"  value="O">Oui<br>
																		<input type="radio" name="referral"  value="N">Non<br>	
																	<?php }}?>	
															<!-- referral	 -->												
														</td>
														<td width=25%>
															<!-- referredBy	 -->
																	Reféré par<br>
																	<input type="text" name="referredBy" value= "<?php echo $referredBy;?>" > 																	
															<!-- referredBy	 -->
														</td>
														
														<td width=25%>
																										
														</td>
																										
														
													</tr>
													</table>
													<br>
													<table>
													<tr>
													   
														<td width=25%>
															<!-- nameOfConsellor	 -->
																	Nom du Conselor<br>
																	<input type="text" name="nameOfConsellor" value= "<?php echo $nameOfConsellor;?>"> 																	
															<!-- nameOfConsellor	 -->												
														</td>
														
														</td>
														<td width=25%>
															<!-- treatmentCenter	 -->
																	Centre de traitement<br>
																	<input type="text" name="treatmentCenter" value= "<?php echo $treatmentCenter;?>"> 																	
															<!-- treatmentCenter	 -->												
														</td>
														
														
														<td width=25%>
															<!-- treatmentCode	 -->
																	Code de traitement<br>
																	<input type="text" name="treatmentCode" value= "<?php echo $treatmentCode;?>"> 																	
															<!-- treatmentCode	 -->												
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





