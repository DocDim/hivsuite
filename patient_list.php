<?php 
include 'dbc.php';
page_protect();

$page_limit = 20; 


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

if(@$_POST['doDeleteSms'] == 'Delete') {

if(!empty($_POST['u'])) {
	foreach ($_POST['u'] as $uid) {
		$id = filter($uid);
		mysqli_query($link, "delete from outbox where ID='$id'");
	}
 }
 $ret = $_SERVER['PHP_SELF'] . '?'.$_POST['query_str'];;
 header("Location: $ret");

}
function checkMiss($serial) {
	$link = new mysqli("localhost", "pepfar_user", "pepfar", "dhappdatabase");
	$sql = "select COUNT(*) as `n` from `dhappdatabase`.`patient` where (`serialNumber`= '$serial') and (TO_DAYS(DATE(NOW()))-TO_DAYS(DATE(nextVisit))>3) and (TO_DAYS(DATE(NOW()))-TO_DAYS(DATE(nextVisit))<8) "; 
	
	$rs_total = mysqli_query($link, $sql);
	$nrow = mysqli_fetch_array($rs_total);
	if ($nrow['n']==0)
		{
			return False;
		}	
	else
	return True;
}

function checkDefaulter($serial) {
	$link = new mysqli("localhost", "pepfar_user", "pepfar", "dhappdatabase");
	$sql = "select COUNT(*) as `n` from `dhappdatabase`.`patient` where (`serialNumber`= '$serial') and  (TO_DAYS(DATE(NOW()))-TO_DAYS(DATE(nextVisit))>7) and (TO_DAYS(DATE(NOW()))-TO_DAYS(DATE(nextVisit))<91) "; 
	
	$rs_total = mysqli_query($link, $sql);
	$nrow = mysqli_fetch_array($rs_total);
	if ($nrow['n']==0)
		{
			return False;
		}	
	else
	return True;
}

function checkLfu($serial) {
	$link = new mysqli("localhost", "pepfar_user", "pepfar", "dhappdatabase");
	$sql = "select COUNT(*) as `n` from `dhappdatabase`.`patient` where (`serialNumber`= '$serial') and  (TO_DAYS(DATE(NOW()))-TO_DAYS(DATE(nextVisit))>90)"; 
	
	$rs_total = mysqli_query($link, $sql);
	$nrow = mysqli_fetch_array($rs_total);
	if ($nrow['n']==0)
		{
			return False;
		}	
	else
	return True;
}

function checkRdv($serial) {
	$link = new mysqli("localhost", "pepfar_user", "pepfar", "dhappdatabase");
	$sql = "select COUNT(*) as `n` from `dhappdatabase`.`patient` where (`serialNumber`= '$serial') and  (TO_DAYS(DATE(NOW()))=TO_DAYS(DATE(nextVisit)))"; 
	
	$rs_total = mysqli_query($link, $sql);
	$nrow = mysqli_fetch_array($rs_total);
	if ($nrow['n']==0)
		{
			return False;
		}	
	else
	return True;
}




?>
<!------------------Header Block----------------------------------------------------------------->
	
<?php	
/*include 'sms_import.php';*/
include 'block_header.php';
	
?>	
<!------------------- #end Header --------------------------------------------------------------->    
 

   
	<div id="main-wrapper" class="clearfix">
		<div id="main" class="row-fluid">
			<div  id="second_sidebar" class="column sidebar span3">
				<h2 id="block_entete" >Panneau d'administration </h2>  
		
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
				<h2 id="block_entete" >Suivi du patient </h2>
					<table>
						<tr>
						
						
						<td>
						<p align="center"> 
							<a href="patient_form.php"><img src="images/add_patient_Center_Icon.png" width="70px"/></a><br>
							<a href="patient_form.php">Enregistrer un patient</a>
						</p align="center">
						</td>
						<td>
						<p align="center"> 
							<a href="patient_export_list.php"><img src="images/export_data.png" width="55px"/></a><br>
							<a href="patient_export_list.php">Exporter les données</a>
						</p align="center">
						<td>	
							
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
						
    <h3 class="titlehdr">Suivi des patients</h3>
      
    
      <p>
        <?php 
	  
		$sql = "select * from `dhappdatabase`.`patient` ORDER BY `codePatient` DESC"; 
	    $rs_total = mysqli_query($link, $sql);
		
	  
	  ?>
	  
			<table style="width:100%;"  border=0>												
				<tr>																				
					<td width=60%>
						<fieldset  style="overflow:auto; height:560px;">
							<legend><strong> &nbsp;Liste des patients&nbsp;</strong> </legend>
		
							<table width="100%" border="0" align="center" cellpadding="2" cellspacing="0">
								  <tr bgcolor="#E6F3F9"> 
									<td width="10%"><strong>Code Clinique</strong></td>
									<td > <strong>Code pharmacie </strong></td>
									<td ><strong>Sexe</strong></td>
									<td ><strong>Age</strong></td>
									<td ><strong>Contact</strong></td>					
									<td ><strong>Profession</strong></td>
									<td  width="5%"></td>
									<td width="20%"><strong>Action</strong></td>
										
								  </tr>
								  
								  <?php $li=1; while ($rrows = mysqli_fetch_array($rs_total)) {?>
								  <tr bgcolor="<?php if (checkLfu($rrows['serialNumber'])) {echo '#ff6666';}
								  else if ($li%2==0) {echo '#E6F3F9';} ?>"> 
									<td><?php echo $rrows['serialNumber'];?></td>
									<td><?php echo $rrows['patientARTCode']; ?></td>
									<td><?php echo $rrows['sex'];?></td>
									<td><?php echo $rrows['age'];?></td>
									<td><?php echo $rrows['patientFirstContact']."<br>".$rrows['patientSecondContact']; ?></td>	
									<td><?php echo $rrows['profession']; ?></td>
									<td>
										<?php 
											if (checkDefaulter($rrows['serialNumber'])){?>
												<img src="images/redFlag.png" width="15px"/>
											<?php }
											else {
												if (checkMiss($rrows['serialNumber'])){?>
													<img src="images/orangeFlag.png" width="15px"/>
												<?php }
												else {
													if (checkRdv($rrows['serialNumber'])){?>
												<img src="images/greenFlag.png" width="15px"/>
											<?php }
													
												}
											}	
										?>	
									</td>
									
									<td>
										<a href="patient_followup_sheet.php?Code=<?php echo $rrows['serialNumber'];?>">Voir</a> | 
										<a href="patient_update_form.php?Code=<?php echo $rrows['serialNumber'];?>">Mettre à jour</a> 
										
									</td>
								  </tr>         
								  <?php $li++;} ?>
							</table>
						</fieldset>	
					</td>
					<td width=40%>
						<fieldset style="overflow:auto; height:180px;">
						<legend><strong> &nbsp;Rendez-vous Du jour&nbsp;</strong> </legend>
			
									
									<?php 
								  
										$sql = "select * from `dhappdatabase`.`patient` where TO_DAYS(DATE(NOW()))=TO_DAYS(DATE(nextVisit))"; 
										$rs_total = mysqli_query($link, $sql);			
								  
									?>
								 
								<table width="100%" border="0" align="center" cellpadding="2" cellspacing="0">
									  <tr bgcolor="#E6F3F9"> 										
										<td width="10%"><strong>N°</strong></td>
										<td width="10%"><strong>Code Clinique</strong></td>
										<td ><strong>Sexe</strong></td>
										<td ><strong>Contact du patient</strong></td>					
										<td ><strong>Profession</strong></td>
										<td ><strong>Action</strong></td>
											
									  </tr>
									  
									  <?php $li=1; while ($rrows = mysqli_fetch_array($rs_total)) {?>
									  <tr bgcolor="<?php if ($li%2==0) {echo '#E6F3F9';} ?>"> 
										<td><?php echo $li;?></td>
										<td><?php echo $rrows['serialNumber'];?></td>									
										<td><?php echo $rrows['sex'];?></td>									
										<td><?php echo $rrows['patientFirstContact']."<br>".$rrows['patientSecondContact']; ?></td>	
										<td><?php echo $rrows['profession']; ?></td>
										<td>
											<a href="patient_followup_sheet.php?Code=<?php echo $rrows['serialNumber'];?>">Voir</a> 										
											
										</td>
									  </tr>         
									  <?php $li++;} ?>
								</table>
							</fieldset>
							<fieldset style="overflow:auto; height:180px;">							
							<legend><strong> &nbsp;Rendez-vous manqué&nbsp;</strong> </legend>
		
								
								<?php 
							  
									$sql = "select * from `dhappdatabase`.`patient` where (TO_DAYS(DATE(NOW()))-TO_DAYS(DATE(nextVisit))>3) and (TO_DAYS(DATE(NOW()))-TO_DAYS(DATE(nextVisit))<8)";  
									$rs_total = mysqli_query($link, $sql);			
							  
								?>
							 
							<table width="100%" border="0" align="center" cellpadding="2" cellspacing="0">
								  <tr bgcolor="#E6F3F9"> 
									<td width="10%"><strong>N°</strong></td>
									<td width="10%"><strong>Code Clinique</strong></td>
									<td ><strong>Sexe</strong></td>
									<td ><strong>Contact du patient</strong></td>					
									<td ><strong>Profession</strong></td>
									<td ><strong>Action</strong></td>
										
								  </tr>
								  
								  <?php $li=1; while ($rrows = mysqli_fetch_array($rs_total)) {?>
								  <tr bgcolor="<?php if ($li%2==0) {echo '#E6F3F9';} ?>"> 
									<td><?php echo $li;?></td>
									<td><?php echo $rrows['serialNumber'];?></td>									
									<td><?php echo $rrows['sex'];?></td>									
									<td><?php echo $rrows['patientFirstContact']."<br>".$rrows['patientSecondContact']; ?></td>	
									<td><?php echo $rrows['profession']; ?></td>
									<td>
										<a href="patient_followup_sheet.php?Code=<?php echo $rrows['serialNumber'];?>">Voir</a>	
									</td>
								  </tr>         
								  <?php $li++;} ?>
							</table>
						</fieldset>	
						<fieldset style="overflow:auto; height:180px;">
							<legend><strong> &nbsp;Patient Défaillant&nbsp;</strong> </legend>
		
								
								<?php 
							  
									$sql = "select * from `dhappdatabase`.`patient` where (TO_DAYS(DATE(NOW()))-TO_DAYS(DATE(nextVisit))>7) and (TO_DAYS(DATE(NOW()))-TO_DAYS(DATE(nextVisit))<91)"; 
									$rs_total = mysqli_query($link, $sql);	

							  
								?>
							 
							<table width="100%" border="0" align="center" cellpadding="2" cellspacing="0">
								  <tr bgcolor="#E6F3F9"> 
									<td width="10%"><strong>N°</strong></td>
									<td width="10%"><strong>Code Clinique</strong></td>
									<td ><strong>Sexe</strong></td>
									<td ><strong>Contact du patient</strong></td>					
									<td ><strong>Profession</strong></td>
									<td ><strong>Action</strong></td>
										
								  </tr>
								  
								  <?php $li=1; while ($rrows = mysqli_fetch_array($rs_total)) {?>
								  <tr bgcolor="<?php if ($li%2==0) {echo '#E6F3F9';} ?>"> 
									<td><?php echo $li;?></td>
									<td><?php echo $rrows['serialNumber'];?></td>									
									<td><?php echo $rrows['sex'];?></td>									
									<td><?php echo $rrows['patientFirstContact']."<br>".$rrows['patientSecondContact']; ?></td>	
									<td><?php echo $rrows['profession']; ?></td>
									<td>
										<a href="patient_followup_sheet.php?Code=<?php echo $rrows['serialNumber'];?>">Voir</a> 										
										
									</td>
								  </tr>         
								  <?php $li++;} ?>
							</table> 
						</fieldset>	
					
					</td>
				</tr>
			</table>
			
		
		</div>			
	</div>
</div>
     

   
   
<!---------------------------------footer --------------------------------------------->
<?php	
include 'block_footer.php';
	
?>	
<!---------------------------------# end footer ------------------------------------->
