<?php 
include 'dbc.php';
page_protect();

if(!checkAdmin()) {
header("Location: login.php");
exit();
}

$page_limit = 100; 


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
				if (checkAdmin()) {
				/*******************************END**************************/
				?>
				<h2 id="block_entete" >Gestion des Tests</h2>
					<table>
						<tr>
							<td>
							<p align="center"> 
								<a href="htc_form.php"><img src="images/HIVTest_add.png" width="70px"/></a><br>
								<a href="htc_form.php">Enregistrer un test</a>
							</p align="center">
							</td>
							<td>
							<p align="center"> 
								<a href="htc_export_list.php"><img src="images/export_data.png" width="60px"/></a><br>
								<a href="htc_export_list.php">Exporter les données</a>
							</p align="center">
							</td>
							
							
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

	

	
    <h3 class="titlehdr">Liste des Test VIH</h3>
      
    
      <p>
        <?php 
	  
		$sql = "select * from  `dhappdatabase`.`htc` ORDER BY `dateOftest` DESC"; 
	    $rs_total = mysqli_query($link, $sql);
		$total = mysqli_num_rows($rs_total);
	  
	  if (!isset($_GET['page']) )
		{ $start=0; } else
		{ $start = ($_GET['page'] - 1) * $page_limit; }
	  
	  $rs_results = mysqli_query($link, $sql . " limit $start,$page_limit");
	  $total_pages = ceil($total/$page_limit);
	  
	  ?>
	  </p>
      
			<p align="right"> 
					<?php 
				  
				  // outputting the pages
					if ($total > $page_limit)
					{
					echo "<div><strong>Pages:</strong> ";
					$i = 0;
					while ($i < $page_limit)
					{
					
					
					$page_no = $i+1;
					$qstr = @preg_replace("&page=[0-9]+","",$_SERVER['QUERY_STRING']);
					echo "<a href=\"htc_list.php?$qstr&page=$page_no\">$page_no</a> ";
					$i++;
					}
					echo "</div>";
					}  ?>
			</p>
		
			<table width="100%" border="0" align="center" cellpadding="2" cellspacing="0">
				  <tr bgcolor="#E6F3F9"> 
					<td width="5%"><strong>N°</strong></td>
					<td > <strong>Code du client </strong></td>
					<td ><strong>Sexe</strong></td>
					<td ><strong>Age</strong></td>
					<td ><strong>Profession</strong></td>
					<td ><strong>Date du test</strong></td>
					<td ><strong>Nouveau statut</strong></td>
						
				  </tr>
				  
				  <?php $li=1; while ($rrows = mysqli_fetch_array($rs_results)) {?>
				  <tr bgcolor="<?php if ($li%2==0) {echo '#E6F3F9';} ?>"> 
					<td><?php echo $rrows['num'];?></td>
					<td><?php echo $rrows['patientCode']; ?></td>
					<td><?php echo $rrows['sex'];?></td>
					<td><?php echo $rrows['age'];?></td>
					<td><?php echo $rrows['profession']; ?></td>	
					<td><?php echo $rrows['dateOftest']; ?></td>						
					<?php 
					$d=$rrows['newStatus'];
					if ($d=='Pos') 
					{echo "<td style=\"color:#ff0000;\"><strong>Positif</strong></td>";}
					else{
						if ($d=='Neg') 
						{echo "<td >N&eacute;gatif</td>";}
						else
						{echo "<td>Ind&eacute;termin&eacute;</td>";}
						}					
						
					?>					

				  </tr>         
				  <?php $li++;} ?>
			</table>
			<table style="width:30%;" " border="0" cellpadding="5" cellspacing="2" class="myaccount">
				<form name="patient_update_form" method="post" action="htc_update_form.php">
				<tr>				
					<td>				
						Mettre à jour les information sur un test
					</td>
				</tr>
				<tr>				
					<td>
						<!-- Code -->									
							<input name="Code_patient" type="text" id="Code_patient" placeholder="Entrez le Code">			
						<!-- Code -->						
							
					</td>
					<td>							
							<input name="doSubmit" type="submit" id="doSubmit" value="Modifier">							
					</td>
				</tr>
				</form>	
			</table>	
		</div>			
	</div>
</div>
     

   
   
<!---------------------------------footer --------------------------------------------->
<?php	
include 'block_footer.php';
	
?>	
<!---------------------------------# end footer ------------------------------------->
