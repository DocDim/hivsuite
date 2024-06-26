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
?>

<html> 
<head>
<title>Liste des Rendez-vous manqués</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<script language="JavaScript" type="text/javascript" src="js/jquery-1.3.2.min.js"></script>
<script language="JavaScript" type="text/javascript" src="js/jquery.validate.js"></script>
<script language="JavaScript" type="text/javascript" src="js/bootstrap.js"></script>
<script language="JavaScript" type="text/javascript" src="js/bootstrap.min.js"></script>
<script language="JavaScript" type="text/javascript" src="js/map_formation_sanitaire.js"></script>
<script language="JavaScript" type="text/javascript" src="js/mes_fonctions.js"></script>
<!--<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=true"></script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC_26aH3UznDIOKyQYIEYxg86eL6N1-nxY&callback=initMap"
  type="text/javascript"></script>-->

  <script>
  $(document).ready(function(){
    $("#logForm").validate();
  });
  </script>
  

<link href="css/style.css" rel="stylesheet" type="text/css">
<link href="css/bootstrap.css" rel="stylesheet" type="text/css">
<link href="css/bootstrap-responsive.css" rel="stylesheet" type="text/css">
<link href="css/colors.css" rel="stylesheet" type="text/css">
<link href="css/ie.css" rel="stylesheet" type="text/css">
<link href="css/ie6.css" rel="stylesheet" type="text/css">
<link href="css/ie-rtl.css" rel="stylesheet" type="text/css">
<link href="css/layout.css" rel="stylesheet" type="text/css">
<link href="css/layout-rtl.css" rel="stylesheet" type="text/css">
<link href="css/maintenance-page.css" rel="stylesheet" type="text/css">
<link href="css/style-rtl.css" rel="stylesheet" type="text/css">

</head>

<body class="html front logged-in one-sidebar sidebar-first page-node toolbar toolbar-drawer" ><!--onload="initialize()"-->
<div id="sheet">
<!------------------------------------------------------------------->
<div  class="row-fluid">
    <nav class="navbar navbar-inverse">
        <div class="navbar-inner">
            <div class="container row-fluid">
                <div id="menu_top" ></div>
            </div>
        </div>
    </nav>
</div>
<div  id="ppr_page_containt" class="row-fluid" >
	<div  class="row-fluid">		
	
            <div class="row-fluid" style="background:url('images/header.png');  background-repeat:no-repeat; background-position: right center;  min-height: 100px;" >
				<div class="span12" style=" vertical-align: middle; padding-top:40px; padding-left:10px;">
				<span style="font-size: 40px;"><strong>Electronic Data Base</strong></span><span >web v 1.0</span>
				</div>
			</div>
			
			<div  class="row-fluid">		
				<nav class="navbar navbar-inverse">
					<div class="navbar-inner">
						<div class="container row-fluid">
							<div id="menu_top" >  
								<div class="region region-menu-inter-contain">
									<div id="block-system-main-menu" class="block block-system block-menu">
										<div id="block_contenu"  class="content">
											<ul class="menu clearfix"><li class="first leaf"><a href="./index.php" class="active">Accueil</a></li>
												<li class="leaf"><a href="./myaccount.php" title="" class="active">Panneau d'administration</a></li>
												<!--<li class="leaf"><a href="./prev_list.php" title="" class="active">Prevention</a></li>-->
												<li class="leaf"><a href="./htc_list.php" title="" class="active">Dépistage</a></li>
												<li class="leaf"><a href="./patient_list.php" title="" class="active">Suivi des patients</a></li>
												<li class="leaf"><a href="./statistics.php" title="" class="active">Statistique et rapports</a></li>
												<li class="leaf"><a href="./#" title="" class="active">Gestion des Données</a></li>
												<li class="last leaf"><a href="./#" title="" class="active">Contacts</a></li>
											</ul>  
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</nav>  
			<div>
	</div> 
	
	
<!----------------- File d'ariane et recherche----------------------------------------------------------->  
            
	<div  id="breadcrumb" class="row-fluid">
			<div class="span9" >
                    <div ></div>
			</div>
			<div class="span3" >
				
			</div>
	
	</div>	

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
				<?php
						include 'block_functions_admin.php';
						?>
										
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
						
				<div class="row-fluid" style="margin:auto;">
						<input type="button" onclick="printDiv('printableArea')" value="imprimer la liste" />
					</div>

					<script>

					function printDiv(divName) {
						 var printContents = document.getElementById(divName).innerHTML;
						 var originalContents = document.body.innerHTML;

						 document.body.innerHTML = printContents;

						 window.print();

						 document.body.innerHTML = originalContents;
					}
					</script>
			  <div id="printableArea">
					 
						<div  style="padding-top:20px; padding-bottom:20px; margin:auto; text-align: center;">
						<span style="font-size: 36px;"><strong><h3 class="titlehdr">Liste des Rendez-vous manqués</h3></strong></span>
						</div>	
													
					<?php 
												  
					$sql = "select * from `dhappdatabase`.`patient` where (TO_DAYS(DATE(NOW()))-TO_DAYS(DATE(nextVisit))>3) and (TO_DAYS(DATE(NOW()))-TO_DAYS(DATE(nextVisit))<8)";  
														$rs_total = mysqli_query($link, $sql);			
												  
													?>
												 
												<table width="100%" border="0" align="center" cellpadding="2" cellspacing="0">
													 <tr bgcolor="#E6F3F9"> 
														
														<td ><strong>N°</strong></td>
														<td ><strong>Code Clinique</strong></td>
														<td > <strong>Code pharmacie </strong></td>
														<td ><strong>Sexe</strong></td>
														<td ><strong>Age</strong></td>
														<td ><strong>Contact</strong></td>					
																						
															
													  </tr>
													  
													  <?php $li=1; while ($rrows = mysqli_fetch_array($rs_total)) {?>
													  <tr bgcolor="<?php if ($li%2==0) {echo '#E6F3F9';} ?>"> 
														<td><?php echo $li;?></td>
														<td><?php echo $rrows['serialNumber'];?></td>
														<td><?php echo $rrows['patientARTCode']; ?></td>
														<td><?php echo $rrows['sex'];?></td>
														<td><?php echo $rrows['age'];?></td>
														<td><?php echo $rrows['patientFirstContact']."  ".$rrows['patientSecondContact']; ?></td>	
														
													  </tr>         
													  <?php $li++;} ?>
												</table>
					</div>
				
			
		
		</div>			
	</div>
</div>
     

   
   
<!---------------------------------footer --------------------------------------------->
<?php	
include 'block_footer.php';
	
?>	
<!---------------------------------# end footer ------------------------------------->
