

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
 
		
	<div class="container">
		<p>
			<?php 
				if (checkAdmin()) {
					if($_POST['doSubmit'] == 'Enregistrer')
						{
							mysql_query("INSERT INTO `dhappdatabase`.`htc` (`num`, `dateOftest`, `region`, `facility`, `unit`, `documentSource`, `patientCode`, `age`, `sex`, `profession`, `knowPrevStatus`, `prevStatut`, `reasonTest`, `newStatus`, `retrivedResults`, `nameOfConsellor`, `referral`, `treatmentCenter`, `treatmentCode`, `referredBy`) 
										VALUES ('','$post[dateOftest]','$post[region]','$post[facility]','$post[unit]','$post[documentSource]','$post[patientCode]','$post[age]','$post[sex]','$post[profession]','$post[knowPrevStatus]','$post[prevStatut]','$post[reasonTest]','$post[newStatus]','$post[retrivedResults]','$post[nameOfConsellor]','$post[referral]','$post[treatmentCenter]','$post[treatmentCode]','$post[referredBy]')") or die(mysql_error()); 
						} 
			?>		  
		</p>
		<h2>Enregistrer un test</h2>
		
		<form name="htc_form" method="post" id="htc_form" action="htc_form.php">
			
			<div class="form-group">		     
					<div class="row">
						<!--dateOftest-->
							<table>
							<tr>															
								<td width="180px">	
								Date du test																								
								</td>
								<td>
									<input name="dateOftest" type="date" id="dateOftest" style="width:200px;" > 
								</td>
							</tr>
						</table>						
						<!-- dateOftest -->
						</div>
						<div class="row">	
						<!-- documentSource -->									
						<table>
							<tr>															
								<td width="180px">	
									Document source																						
								</td>
								<td >
									<input name="documentSource" type="text" id="documentSource" style="width:200px;">												
								</td>
							</tr>
						</table>
						<!-- documentSource -->
						</div>
						<div class="row">										
						<!--region-->
						<table>
							<tr>															
								<td width="180px">	
									Région																								
								</td>
								<td>
								<select  name="region"  id="region" style="width:200px;"  >																	  
									<option value="RSM1">RSM1</option>
									<option value="RSM2">RSM2</option>													 
								</select> 
								</td>
							</tr>
						</table>
						<!-- region -->
						</div>
						<div class="row">										
						<!--facility-->
						<table>
							<tr>															
								<td width="180px">	
								Formation Sanitaire																							
							</td>														
								<td>
									<select  name="facility"  id="facility" style="width:200px;" >										
										<optgroup label="RSM1">
										<option value="HMR1">HMR1</option>										
										<option value="SED">SED</option>
										<option value="GP">GP</option>
										<option value="BA101">BA101</option>
										<option value="BQG">BQG</option>
										<option value="SSM6">SSM6</option>
										<option value="22eBIM">22eBIM</option>
										</optgroup>
										<optgroup label="RSM2">
										<option value="HMR2">HMR2</option>
										<option value="REGEN">REGEN</option>
										<option value="BBR">BBR</option>
										<option value="GE2">GE2</option>
										<option value="RASA">RASA</option>
										<option value="BSA">BSA</option>
										<option value="SSM10">SSM10</option>
										<option value="RASS">RASS</option>
										</optgroup>
									</select>
								</td>
							</tr>
						</table>
						<!-- facility -->
						</div>
						<div class="row">					
						<!--unit-->
						<table>
							<tr>															
								<td width="180px">	
								Unité																						
							</td>														
								<td>
									<input type="text"  name="unit"  id="unit" style="width:200px;"  >
								</td>
							</tr>
						</table>
						<!-- unit -->
					</div>	
					<div class="row">
					<!-- Code -->
					<table>
						<tr>															
							<td width="180px">
								<label for="patientCode">Code client</label>
							</td>	
							<td >	
								<input name="patientCode" type="text" id="patientCode" >
							</td>
						</tr>
					</table>
					<!-- Code -->
					</div>
					<div class="row">
					<!-- age -->
					<table>
						<tr>															
							<td width="180px">
								<label for="age">Age</label>
							</td>	
							<td >
								<input name="age" type="number" id="age" >
							</td>
						</tr>
					</table>					
					<!-- age -->
					</div>
					<div class="row">
					<!-- Sexe -->
					<table>
						<tr>															
							<td width="180px">
								<label for="sex">Sexe :</label>
							</td>	
							<td >	
								<input type="radio" name="sex" value="M"> Homme 
								<input type="radio" name="sex" value="F"> Femme
							</td>
						</tr>
					</table>
					<!-- Sexe -->
					</div>

				
					<div class="row">
					<!-- Profession -->
					<table>
						<tr>															
							<td width="180px">
								<label for="profession">Profession </label> 
							</td>	
							<td >
								<td>
									<input type="radio" name="profession" value="Civ"> Civil
									<input type="radio" name="profession" value="Mil"> Militaire																					
								</td> 
							</td>
						</tr>
					</table>									
					<!-- Profession -->
					</div>
					
					<div class="row">
					<!-- knowPrevStatus	 -->
						<table>
							<tr>
								<td width="180px">
									<label for="knowPrevStatus">Statut pr&eacute;c&eacute;dent connu? </label> 
								</td>
								<td>
									<input type="radio" name="knowPrevStatus" value="O"> Oui
									<input type="radio" name="knowPrevStatus" value="N"> Non																					
								</td>
							</tr>
						</table>	
					<!-- knowPrevStatus	 -->
					</div>

					<div class="row">
					<!-- prevStatut	 -->
						<table>
							<tr>
								<td width="180px">
									<label for="prevStatut">Statut précédent</label> 
								</td>
								<td>
									<input type="radio" name="prevStatut" value="Pos"> Pos
									<input type="radio" name="prevStatut" value="Neg"> Neg
									<input type="radio" name="prevStatut" value="Ind"> Ind
								</td>
							</tr>
						</table>

					<!-- prevStatut	 -->
					</div>
				
		 
					<div class="row">
					<!-- reasonTest	 -->
					<table>
							<tr>
								<td width="180px">
									<label for="reasonTest">Raison du test </label> 
								</td>
								<td>						
									<input type="radio" name="reasonTest" value="PITC"> PITC
									<input type="radio" name="reasonTest" value="VCT"> VCT	
								</td>
							</tr>
					</table>						
					<!-- reasonTest	 -->												
					</div>
					
					<div class="row">
					<!-- newStatus	 -->
					<table>
							<tr>
								<td width="180px">
									<label for="newStatus">Nouveau Statut </label> 
								</td>
								<td>
									<input type="radio" name="newStatus" value="Pos"> Pos
									<input type="radio" name="newStatus" value="Neg"> Neg
									<input type="radio" name="newStatus" value="Ind"> Ind
								</td>
							</tr>
					</table>
					<!-- newStatus	 -->
					</div>	
					<div class="row">
					<!-- retrivedResults	 -->
					<table>
							<tr>
								<td width="180px">
									<label for="retrivedResults">Résultat retiré? </label> 
								</td>
								<td>						
									<input type="radio" name="retrivedResults" value="O"> Oui
									<input type="radio" name="retrivedResults" value="N"> Non
								</td>
							</tr>
					</table>						
					<!-- retrivedResults	 -->												
					</div>	
					<div class="row">
					<!-- referral	 -->
					<table>
							<tr>
								<td width="180px">
									<label for="referral">Reféré ?</label> 
								</td>
								<td>						
									<input type="radio" name="referral" value="O"> Oui
									<input type="radio" name="referral" value="N"> Non	
								</td>
							</tr>
					</table>						
					<!-- referral	 -->												
					</div>	
					<div class="row">
					<!-- referredBy	 -->
					<table>
							<tr>
								<td width="180px">
									<label for="referredBy">Reféré par </label> 
								</td>
								<td>		
									<input type="text" name="referredBy" > 
								</td>
							</tr>
					</table>						
					<!-- referredBy	 -->
					</div>	
					<div class="row">
					<!-- nameOfConsellor	 -->
					<table>
							<tr>
								<td width="180px">
									<label for="nameOfConsellor">Nom du Conselor </label> 
								</td>
								<td>						
									<input type="text" name="nameOfConsellor" > 
								</td>
							</tr>
					</table>						
					<!-- nameOfConsellor	 -->												
					</div>	
					<div class="row">
					<!-- treatmentCenter	 -->
					<table>
							<tr>
								<td width="180px">
									<label for="treatmentCenter">Centre de traitement </label> 
								</td>
								<td>
									<input type="text" name="treatmentCenter" > 
								</td>
							</tr>
					</table>									
					<!-- treatmentCenter	 -->												
					</div>	
					<div class="row">									
					<!-- treatmentCode	 -->
					<table>
							<tr>
								<td width="180px">
									<label for="treatmentCode">Code de traitement </label> 
								</td>
								<td>
									<input type="text" name="treatmentCode" > 
								</td>
							</tr>
					</table>						
					<!-- treatmentCode	 -->		
					</div>
					<div class="row">
					<table>
						<tr>
							<td><input name="doSubmit" type="submit" id="doSubmit" value="Enregistrer"></td>
							<td></td>
						</tr>
					</table>
					</div>
		  </div>		  
		</form>  
	</div> 
	<?php }
                else
					{
					header("Location: login.php");
					exit();
					}
				?>
  
<!---------------------------------footer --------------------------------------------->
	<?php	
		include 'block_footer.php';	
	?>
<!---------------------------------# end footer ------------------------------------->





