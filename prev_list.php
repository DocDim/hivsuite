<?php 
include 'dbc.php';
page_protect();

if(!checkAdmin()) {
header("Location: login.php");
exit();
}

$page_limit = 20; 


$host  = $_SERVER['HTTP_HOST'];
$host_upper = strtoupper($host);
$login_path = @ereg_replace("admin",'',dirname($_SERVER['PHP_SELF']));
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
		mysql_query("delete from outbox where ID='$id'");
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
				<h2 id="block_entete" >My Account </h2>  
		
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
				<h2 id="block_entete" >Manage Data </h2>
					<table>
						<tr>
							<td>
							<p align="center"> 
								<a href="prev_form.php"><img src="images/HIVPrev_add.png" width="75px"/></a><br>
								<a href="prev_form.php">Enregistrer une prévention</a>
							</p align="center">
							</td>
							<td>
							<p align="center"> 
								<a href="prev_export_list.php"><img src="images/export_data.png" width="60px"/></a><br>
								<a href="prev_export_list.php">Exporter les données</a>
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

	

	
    <h3 class="titlehdr">Liste des préventions</h3>
      
    
      <p>
        <?php 
	  
		$sql = "select * from  fiche_de_prevention ORDER BY `sn` DESC"; 
	    $rs_total = mysql_query($sql) or die(mysql_error());
		$total = mysql_num_rows($rs_total);
	  
	  if (!isset($_GET['page']) )
		{ $start=0; } else
		{ $start = ($_GET['page'] - 1) * $page_limit; }
	  
	  $rs_results = mysql_query($sql . " limit $start,$page_limit") or die(mysql_error());
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
					$qstr = ereg_replace("&page=[0-9]+","",$_SERVER['QUERY_STRING']);
					echo "<a href=\"data_list.php?$qstr&page=$page_no\">$page_no</a> ";
					$i++;
					}
					echo "</div>";
					}  ?>
			</p>
		
			<table width="100%" border="0" align="center" cellpadding="2" cellspacing="0">
				  <tr bgcolor="#E6F3F9"> 
					<td width="5%"><strong>SN</strong></td>
					<td > <strong>Code du Client </strong></td>
					<td ><strong>Sexe</strong></td>
					<td ><strong>Age</strong></td>
					<td ><strong>Adresse</strong></td>
					<td ><strong>Date de la prévention</strong></td>
					<td ><strong>A reçu le Condom?</strong></td>
						
				  </tr>
				  
				  <?php $li=1; while ($rrows = mysql_fetch_array($rs_results)) {?>
				  <tr bgcolor="<?php if ($li%2==0) {echo '#E6F3F9';} ?>"> 
					<td><?php echo $rrows['sn'];?></td>
					<td><?php echo $rrows['Code_client']; ?></td>
					<td><?php echo $rrows['Sexe_client'];?></td>
					<td><?php echo $rrows['Age-client'];?></td>
					<td><?php echo $rrows['Adresse_client']; ?></td>	
					<td><?php echo $rrows['Date_prev']; ?></td>						
					<?php 
					$d=$rrows['Condom_recu'];
					if ($d=='N') 
					{echo "<td style=\"color:#ff0000;\"><strong>Non</strong></td>";}
					else{						
						{echo "<td >Oui</td>";}						
						
						}				
						
					?>					

				  </tr>         
				  <?php $li++;} ?>
			</table>	
		</div>			
	</div>
</div>
     

   
   
<!---------------------------------footer --------------------------------------------->
<?php	
include 'block_footer.php';
	
?>	
<!---------------------------------# end footer ------------------------------------->
