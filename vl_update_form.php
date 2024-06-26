

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
 
$sql = "SELECT * FROM `dhappdatabase`.`viralLoad`  WHERE `id`= '$Code' ";
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
$dateOfOrder = $rrows['dateOfOrder'];	 
$dateOfsample = $rrows['dateOfsample'];	 
$dateOfresult = $rrows['dateOfresult'];	 
$vlCount = $rrows['vlCount'];	
	
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
				
						if(isset($_POST['doSubmit']) and($_POST['doSubmit'] == 'Modifier'))
							{
							
							
							mysqli_query($link, "UPDATE `dhappdatabase`.`viralLoad` 
										SET `dateOfOrder`='$post[dateOfOrder]', `dateOfsample`='$post[dateOfsample]', `dateOfresult`='$post[dateOfresult]', `vlCount`='$post[vlCount]'
										WHERE id='$post[id]'");
										
										$linkU="patient_followup_sheet.php?Code=".$post[serialNumber];
										redir($linkU);
							
							} ?>
								  
								  <h3 class="titlehdr">Modifier une Charge Virale</h3>
								  <table width="80%" border="0" cellpadding="5" cellspacing="2" class="myaccount">
									<tr>
									  <td><form name="vl_update_form" method="post" action="vl_update_form.php">									
											
											
											
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
																		<!-- dateOfOrder -->																		
																		<td width=30%>																		
																			Date de prescription									
																			<input name="dateOfOrder" type="date" id="dateOfOrder" value="<?php echo $dateOfOrder;?>">																		
																		</td>
																		<!-- dateOfOrder -->																	
																		<!-- dateOfsample -->																		
																		<td width=30%>																		
																			Date de prélèvement										
																			<input name="dateOfsample" type="date" id="dateOfsample" value="<?php echo $dateOfsample;?>">																		
																		</td>
																		<!-- dateOfsample -->
																		<!-- dateOfresult -->																		
																		<td width=30%>																		
																			Date de resultat										
																			<input name="dateOfresult" type="date" id="dateOfresult" value="<?php echo $dateOfresult;?>">																		
																		</td>
																		<!-- dateOfresult -->
																		<td width=30%>																		
																			Nombre de copie										
																			<input name="vlCount" type="number" id="vlCount" value="<?php echo $vlCount;?>">																		
																		</td>
																		<!-- dateOfresult -->
																	</tr>
																</table>
															</fieldset>	
														</td>
													</tr>											
												</table>
										<table>
											<tr>
												<td><input name="doSubmit" type="submit" id="doSubmit" value="Modifier"></td>
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





