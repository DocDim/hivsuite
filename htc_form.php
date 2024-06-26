

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
				
						 if (isset($_POST['doSubmit']) and($_POST['doSubmit'] == 'Enregistrer'))
							{
														 
							$req=mysqli_query($link, "INSERT INTO `dhappdatabase`.`htc` (`num`, `dateOftest`, `region`, `facility`, `unit`, `documentSource`, `patientCode`, `age`, `sex`, `profession`, `knowPrevStatus`, `prevStatut`, `reasonTest`, `newStatus`, `retrivedResults`, `nameOfConsellor`, `referral`, `treatmentCenter`, `treatmentCode`, `referredBy`) 

							VALUES ('','$post[dateOftest]','$post[region]','$post[facility]','$post[unit]','$post[documentSource]','$post[patientCode]','$post[age]','$post[sex]','$post[profession]','$post[knowPrevStatus]','$post[prevStatut]','$post[reasonTest]','$post[newStatus]','$post[retrivedResults]','$post[nameOfConsellor]','$post[referral]','$post[treatmentCenter]','$post[treatmentCode]','$post[referredBy]')"); 
							if (!$req) {
								die(mysqli_error($req));
							}	
							
							} ?>
								  
								  <h3 class="titlehdr">Enregistrer un test</h3>
								  <table width="80%" border="0" cellpadding="5" cellspacing="2" class="myaccount">
									<tr>
									  <td>	
										<form name="htc_form" method="post" id="htc_form" action="htc_form.php">	

											<fieldset  >
												<legend></legend>
												<table style="width:100%;"  >
													
													<tr>
														<!--dateOftest-->
														<td>	
															Date du test																								
														</td>
														<td>
															<input name="dateOftest" type="date" id="dateOftest" style="width:200px;" > 
														</td>	
														<!-- dateOftest -->
														
														<td>	
															Document source																						
														</td>
														<td >
															<!-- documentSource -->
															<input name="documentSource" type="text" id="documentSource" style="width:200px;">												
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
																<option></option>																	  
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
															<select  name="facility"  id="facility" style="width:200px;" onfocus="formationFunction()" ></select>
														</td>
														<!-- facility -->	
														<!--unit-->
														<td>	
															Unité																						
														</td>														
														<td>
															<input type="text"  name="unit"  id="unit" style="width:200px;"  >
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
																<input name="patientCode" type="text" id="patientCode" >
															<!-- Code -->
														</td>
														
														<td width=25%>
															<!-- age -->
																Age 
																<input name="age" type="number" id="age" >  
															<!-- age -->
														</td>
														
														<td width=25%>
															<!-- Sexe -->
																Sexe :<br>
																<input type="radio" name="sex" value="M"> Masculin <br>   
																<input type="radio" name="sex" value="F"> Feminin<br>				
															<!-- Sexe -->	
														</td>
														
														<td width=25%>
															<!-- Profession -->
																Profession 
																<input name="profession" type="text" id="profession" >  
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
																	<input type="radio" name="knowPrevStatus" value="O"> Oui<br>
																	<input type="radio" name="knowPrevStatus" value="N"> Non<br>				
															<!-- knowPrevStatus	 -->												
														</td>
														<td width=25%>
															<!-- prevStatut	 -->
																	Statut précédent<br>
																	<input type="radio" name="prevStatut" value="Pos"> Positif<br>
																	<input type="radio" name="prevStatut" value="Neg"> N&eacute;gatif<br>
																	<input type="radio" name="prevStatut" value="Ind"> Ind&eacute;termin&eacute;<br>
															<!-- prevStatut	 -->												
														</td>
														<td width=25%>
															<!-- reasonTest	 -->
																	Raison du test<br>
																	<input type="radio" name="reasonTest" value="PITC"> PITC<br>
																	<input type="radio" name="reasonTest" value="VCT"> VCT<br>				
															<!-- reasonTest	 -->												
														</td>
														<td width=25%>
															<!-- newStatus	 -->
																	Nouveau Statut<br>
																	<input type="radio" name="newStatus" value="Pos"> Positif<br>
																	<input type="radio" name="newStatus" value="Neg"> N&eacute;gatif<br>
																	<input type="radio" name="newStatus" value="Ind"> Ind&eacute;termin&eacute;<br>
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
																	<input type="radio" name="retrivedResults" value="O"> Oui<br>
																	<input type="radio" name="retrivedResults" value="N"> Non<br>				
															<!-- retrivedResults	 -->												
														</td>
														
														<td width=25%>
															<!-- referral	 -->
																	Reféré ?<br>
																	<input type="radio" name="referral" value="O"> Oui<br>
																	<input type="radio" name="referral" value="N"> Non<br>	
															<!-- referral	 -->												
														</td>
														<td width=25%>
															<!-- referredBy	 -->
																	Reféré par<br>
																	<input type="text" name="referredBy" > 																	
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
																	<input type="text" name="nameOfConsellor" > 																	
															<!-- nameOfConsellor	 -->												
														</td>
														
														</td>
														<td width=25%>
															<!-- treatmentCenter	 -->
																	Centre de traitement<br>
																	<input type="text" name="treatmentCenter" > 																	
															<!-- treatmentCenter	 -->												
														</td>
														
														
														<td width=25%>
															<!-- treatmentCode	 -->
																	Code de traitement<br>
																	<input type="text" name="treatmentCode" > 																	
															<!-- treatmentCode	 -->												
														</td>
														<td width=25%>
																										
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





