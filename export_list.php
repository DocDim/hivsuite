<?php 
include 'dbc.php';
page_protect();

if(!checkAdmin()) {
header("Location: login.php");
exit();
}

$page_limit = 10; 


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
								<a href="data_list.php"><img src="images/view_data.png" width="60px"/></a><br>
								<a href="data_list.php">View Data</a>
							</p align="center">
							</td>
							<td>
							<p align="center"> 
								<a href="export_list.php"><img src="images/export_data.png" width="60px"/></a><br>
								<a href="export_list.php">Export Data</a>
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
	
    <h3 class="titlehdr">Export Data DOVE2</h3>
      
    
			<table> 
					<tr>
						<td>
						<p align="center"> 
							<a href="export_ircs.php"><img src="images/icon_ecxel.png" width="65px"/></a><br>
							<a href="export_ircs.php">IRCS Data </a>
						</p >
						</td>
						<td>
						<p align="center"> 
							<a href="export_fds.php"><img src="images/icon_ecxel.png" width="65px"/></a><br>
							<a href="export_fds.php">Fiche des stock 1</a>
						</p>
						</td>
						<td>
						<p align="center"> 
							<a href="export_fds2.php"><img src="images/icon_ecxel.png" width="65px"/></a><br>
							<a href="export_fds2.php">Fiche des stock 2</a>
						</p>
						</td>
						<td>
						<p align="center"> 
							<a href="export_fps.php"><img src="images/icon_ecxel.png" width="65px"/></a><br>
							<a href="export_fps.php">Fiche de sorti des patients </a>
						</p> 
						</td>
						<td>
						<p align="center"> 
							<a href="export_gdsd2.php"><img src="images/icon_ecxel.png" width="65px"/></a><br>
							<a href="export_gdsd2.php">GDSD2 Data </a>
						</p> 
						</td>
						
					</tr>
											
			</table>	
			
			<h3 class="titlehdr">Export Data REMMOCC</h3>
      
    
			<table> 
					<tr>
						<td>
						<p align="center"> 
							<a href="export_ebm.php"><img src="images/icon_ecxel.png" width="65px"/></a><br>
							<a href="export_ebm.php">Enquête de base dans les ménages </a>
						</p >
						</td>
						<td>
						<p align="center"> 
							<a href="export_vhm.php"><img src="images/icon_ecxel.png" width="65px"/></a><br>
							<a href="export_vhm.php">Visite hebdomadaire des ménages</a>
						</p>
						</td>
						<td>
						<p align="center"> 
							<a href="export_fncd.php"><img src="images/icon_ecxel.png" width="65px"/></a><br>
							<a href="export_fncd.php"> Fiche de notification des cas de diarrhé</a>
						</p>
						</td>
						<td>
						<p align="center"> 
							<a href="export_evape.php"><img src="images/icon_ecxel.png" width="65px"/></a><br>
							<a href="export_evape.php">Evaluation des points d'eau </a>
						</p> 
						</td>
						<td>
						<p align="center"> 
							<a href="export_wash.php"><img src="images/icon_ecxel.png" width="65px"/></a><br>
							<a href="export_wash.php">Enquête WASH </a>
						</p> 
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
