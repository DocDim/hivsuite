

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
							<a href="prev_list.php"><img src="images/HIVPrev_list.png" width="65px"/></a><br>
							<a href="prev_list.php">Liste des préventions</a>
						</p align="center">
						<td>
						<td>
						<p align="center"> 
							<a href="prev_form.php"><img src="images/HIVPrev_add.png" width="65px"/></a><br>
							<a href="prev_form.php">Enregistrer une prévention</a>
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
				
						 if($_POST['doSubmit'] == 'Enregistrer')
							{
														 
							mysql_query("INSERT INTO `pepfarcongo`.`fiche_de_prevention` (`sn`, `Nom_personnel`, `Date_prev`, `Code_client`, `Age-client`, `Sexe_client`, `Adresse_client`, `Profession_client`, `Grade_client`, `Statut_matrimonial`, `nbr_enfant`, `Strategie_prevention`, `Condom_recu`, `refere_vers`, `refere_pour`, `Signe_IST`, `Grossesse`, `PWID`, `TS`, `MSM`, `Transsexuel`, `date_rendez_Vous`)
							
							VALUES ('','$post[Nom_personnel]','$post[Date_prev]','$post[Code_client]','$post[Age_client]','$post[Sexe_client]','$post[Adresse_client]','$post[Profession_client]','$post[Grade_client]','$post[Statut_matrimonial]','$post[nbr_enfant]','$post[Strategie_prevention]','$post[Condom_recu]','$post[refere_vers]','$post[refere_pour]','$post[Signe_IST]','$post[Grossesse]','$post[PWID]','$post[TS]','$post[MSM]','$post[Transsexuel]','$post[date_rendez_Vous]')") or die(mysql_error()); 
							} ?>
								  
								  <h3 class="titlehdr">Fiche de prévention</h3>
								  <table width="80%" border="0" cellpadding="5" cellspacing="2" class="myaccount">
									<tr>
									  <td><form name="prev_form" method="post" action="prev_form.php">
											<fieldset>
											
											<table border=1>
													<tr>
														<td width=50%>
															<!-- Nom_personnel -->
															Nom du Personnel 
																<input name="Nom_personnel" type="text" id="Nom_personnel" > 
															<!-- Nom_personnel -->
														</td>
														<td>	
															<!-- date_test	 -->
																<label for="Date_prev">Date de la prévention</label>
																<input name="Date_prev" type="date" id="Date_prev">  
															<!-- date_test -->	
														</td>
													</tr>
											</table>
											</fieldset>
																				   
											<fieldset>
												<legend>Information sur le client</legend>												
												
												<table border=1>
													<tr>
														<td width=25%>
															<!-- Code -->
																
																	Code du client* 
																	<input name="Code_client" type="text" id="Code_client" placeholder="Format de saisie"> 
																													
															<!-- Code -->
														</td>
														<td width=25%>
															<!-- Age -->
																
																	Age 
																	<input name="Age_client" type="number" id="Age_client" >  
																
															<!-- Age -->
														</td>
														<td width=25%>
															<!-- Sexe -->											
																
																	Sexe :<br>
																	<input type="radio" name="Sexe_client" value="M"> Masculin<br>
																	<input type="radio" name="Sexe_client" value="F"> Feminin<br>
																																			
															<!-- Sexe -->	
														</td>
														<td width=25%>
															<!-- Transsexuel -->											
																
																	Transsexuel ?<br>
																	<input type="radio" name="Transsexuel" value="O"> Oui<br>
																	<input type="radio" name="Transsexuel" value="N"> Non<br>
																																			
															<!-- Transsexuel -->	
														</td>
													</tr>				
												</table>
												
												<table border=1>
													<tr>
														<td width=25%>
															<!-- Adresse -->
																
																	Adresse 
																	<input name="Adresse_client" type="text" id="Adresse_client">  
																
															<!-- Adresse -->															
														</td>
														<td width=25%>

															<!-- Profession -->
																
																	Profession 
																	<input name="Profession_client" type="text" id="Profession_client" >  
																
															<!-- Profession -->	
															
														</td width=25%>
														<td>
															<!-- Grade -->
																
																	Grade 
																	<select  name="Grade_client"  id="Grade_client">
																	  <option></option>
																	  <optgroup label="Militaires du rang">
																		<option value="Caporal-chef">Caporal-chef</option>
																		<option value="Caporal">Caporal</option>
																		<option value="Soldat">Soldat</option>
																	  </optgroup>
																	 
																	  <optgroup label="Sous-officiers">
																		<option value="Major">Major</option>
																		<option value="Adjudant-chef">Adjudant-chef</option>
																		<option value="Adjudant">Adjudant</option>
																		<option value="Sergent-chef">Sergent-chef</option>
																		<option value="Sergent">Sergent</option>
																	  </optgroup>
																	  
																	  <optgroup label="Officiers subalternes">
																		<option value="Capitaine">Capitaine</option>
																		<option value="Lieutenant">Lieutenant</option>
																		<option value="Sous-lieutenant">Sous-lieutenant</option>
																		<option value="Aspirant">Aspirant</option>
																	  </optgroup>
																	  
																	  <optgroup label="Officiers supérieurs">
																		<option value="Colonel">Colonel</option>
																		<option value="Lieutenant-colonel">Lieutenant-colonel</option>   
																		<option value="Commandant">Commandant</option>
																	  </optgroup>
																	  
																	  <optgroup label="Officiers généraux">
																		<option value="Général de corps d'armée">Général de corps d'armée</option>
																		<option value="Général de division">Général de division</option>   
																		<option value="Général de brigade">Général de brigade</option>
																	  </optgroup>
																	</select> 																	
																
															<!-- Grade -->			
														</td>
														<td width=25%>
																										
														</td>
													</tr>				
												</table>
												
												<table border=1>
													<tr>
														
														<td width=25%>
															<!-- Statut_matrimonial	 -->											
																
																	Statut matrimonial:<br>
																	<input type="radio" name="Statut_matrimonial" value="C"> Célibataire<br>
																	<input type="radio" name="Statut_matrimonial" value="M"> Marié(e)<br>
																	<input type="radio" name="Statut_matrimonial" value="D"> Divorcé(e)<br>
																																				
															<!-- Statut_matrimonial	 -->												
														</td>
														<td width=25%>
															<!-- nbr_enfant	 -->
																
																	Nombre d'enfant	 
																	<input name="nbr_enfant" type="number" id="nbr_enfant">  
																
															<!-- nbr_enfant -->	
														</td>
														<td width=25%>
																										
														</td>
														<td width=25%>
																										
														</td>
													</tr>				
												</table>

											</fieldset>	
											<fieldset>
																								
																				
												
												<table border=1>
													<tr>
														<td width=25%>
													
															<!-- Strategie -->																
																	Stratégie de prévention:<br>
																	<input type="radio" name="Strategie_prevention" value="Mob"> Mobile<br>
																	<input type="radio" name="Strategie_prevention" value="Fix"> Fixe<br>
															
															<!-- Strategie -->	
														</td>
														
														<td width=25%>
															<!-- Strategie -->																
																Le Client a t-il reçu les Condom?<br>
																	<input type="radio" name="Condom_recu" value="O"> Oui<br>
																	<input type="radio" name="Condom_recu" value="N"> Non<br>
															
															<!-- Strategie -->												
														</td>	
														
														<td width=25%>
															<!-- refere_vers -->
																	Client reféré vers<br>
																	<input type="text" name="refere_vers"  id="refere_vers">
															<!-- refere_vers -->	
														</td>	
														<td width=25%>
															<!-- refere_pour -->
																	Client reféré pour<br>
																	<input type="text" name="refere_pour"  id="refere_pour">
															<!-- refere_pour -->	
														</td>
																											
													</tr>
												</table>
												
												
												<!-- Populations-clés	 -->
															Populations-clés
															<table border=1>
																<tr>
																	<th width=25%></th>
																	<th width=25%>TS</th>
																	<th width=25%>MSM</th>
																	<th>PWID</th>
																</tr>
																<tr>
																	<td>Oui</td>
																	<td><input type="radio" name="TS" value="O"></td>
																	<td><input type="radio" name="MSM" value="O"></td>
																	<td><input type="radio" name="PWID" value="O"></td>
																</tr>
																<tr>
																	<td>Non</td>
																	<td><input type="radio" name="TS" value="N"></td>
																	<td><input type="radio" name="MSM" value="N"></td>
																	<td><input type="radio" name="PWID" value="N"></td>
																</tr>
															</table>
												<!--  Populations-clés	 -->
												
												<!-- Facteurs de risque	 -->
															
															<table border=1>
																<tr>
																	<th width=25%></th>
																	<th width=25%>Signe d'IST?</th>
																	<th width=25%>Grossesse?</th>
																	<th width=25%></th>
																</tr>
																<tr>
																	<td>Oui</td>
																	<td><input type="radio" name="Signe_IST" value="O"></td>
																	<td><input type="radio" name="Grossesse" value="O"></td>
																	<td></td>
																</tr>
																<tr>
																	<td>Non</td>
																	<td><input type="radio" name="Signe_IST" value="N"></td>
																	<td><input type="radio" name="Grossesse" value="N"></td>
																	<td></td>
																</tr>
															</table>
												<!--  Facteurs de risque	 -->
												
												<!-- date_rendez_Vous-->
													Date du rendez-vous <br>
													<input type="Date" name="date_rendez_Vous" id="date_rendez_Vous">
												<!-- date_rendez_Vous -->	
												
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





