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
					<legend>Filtrer la liste</legend>	
					<form name="diepensation_summary" method="post" action="vl_summary.php">
					<table>						
						
						<tr>
							<!-- startDate -->													
							<td width=50%>
								Date de début															
							</td>
							<td width=50%>	
								<input name="startDate" type="date" id="startDate" >
							</td>
							<!-- startDate -->
						</tr>	
						<tr>
							<!-- endDate -->													
							<td width=50%>
								Date de fin															
							</td>
							<td width=50%>	
								<input name="endDate" type="date" id="endDate" >
							</td>
							<!-- endDate -->
						</tr>				
					</table>
					<table>						
						<tr>	
							<td style="float:left;">							
								<input name="doSubmit" type="submit" id="doSubmit" value="Filtrer" style="width: 95px;" >
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
						 <h3 class="titlehdr">Récapitulatif des Charges virales</h3>
								
							
						
						<?php if(checkAdmin() || clinicien() || pharmacien() ) {
				
							if(isset($_POST['doSubmit']) and($_POST['doSubmit'] == 'Filtrer')){
								
								$sql1 = "SELECT * FROM `dhappdatabase`.`patient`";									
								$rs_total = mysqli_query($link, $sql1);
								if (!$rs_total) {
									printf("Error: %s\n", mysqli_error($link));
									exit();
								}
								$li=1;?>							
								<fieldset  style="overflow:auto; height:500px;">
								<table width="80%" border="0" cellpadding="5" cellspacing="2" class="myaccount">
									<tr bgcolor="#E6F3F9"> 
										<td ><strong>Code</strong></td>										
										<td ><strong>Sex</strong></td>
										<td ><strong>Age</strong></td>
										<td ><strong>Date de prescription</strong></td>
										<td ><strong>Date de prelèvement</strong></td>
										<td ><strong>Date de résultat</strong></td>
										<td ><strong>Nombre de copie</strong></td>														
									</tr>	
								
								<?php

								while ($rrows = mysqli_fetch_array($rs_total)) {									
									$summary[$li]= $rrows;
									$summary[$li]['code']=null;
									$summary[$li]['dateOfOrder']=null;
									$summary[$li]['dateOfsample']=null;
									$summary[$li]['dateOfresult']=null;
									$summary[$li]['vlCount']=null;								
									
									
									$req2="SELECT * FROM `dhappdatabase`.`viralLoad`  WHERE (`serialNumber`='$rrows[serialNumber]') and (`dateOfsample` BETWEEN '$post[startDate]' AND '$post[endDate]' )";
									$rs_total2 = mysqli_query($link, $req2);									
									while ($rrows2 = mysqli_fetch_array($rs_total2)) {	
									
										$summary[$li]['code']= $rrows2['serialNumber'];
										$summary[$li]['dateOfOrder']= $rrows2['dateOfOrder'];
										$summary[$li]['dateOfsample']= $rrows2['dateOfsample'];
										$summary[$li]['dateOfresult']= $rrows2['dateOfresult'];
										$summary[$li]['vlCount']= $rrows2['vlCount'];
																													
									} ?>
									<tr bgcolor="<?php if ($li%2==0) {echo '#E6F3F9';} ?>"> 
										<td><?php echo $summary[$li]['serialNumber'];?></td>										
										<td><?php echo $summary[$li]['sex'];?></td>
										<td><?php echo $summary[$li]['age'];?></td>
										<td><?php echo $summary[$li]['dateOfOrder'];?></td>
										<td><?php echo $summary[$li]['dateOfsample']; ?></td>
										<td><?php echo $summary[$li]['dateOfresult']; ?></td>
										<td><?php echo $summary[$li]['vlCount'];?></td>										
									</tr> 
									
								
								<?php
									$li++;
								}?>	
							</table>
						</fieldset>	
						<div style="margin-top:10px;">
						<a href="vl_summary_export.php?startDate=<?php echo $post['startDate'];?>&endDate=<?php echo $post['endDate'];?>" class="button">Exporter</a>
						<div>
						<?php						
							} 
						?>
								  
								
									
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







