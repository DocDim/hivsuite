<?php 
include 'dbc.php';

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

	$sql1 = "SELECT * FROM `dhappdatabase`.`patient`";									
	$rs_total = mysqli_query($link, $sql1);
	if (!$rs_total) {
    printf("Error: %s\n", mysqli_error($link));
    exit();
}
	$excel ="Code \t TARV Code \t Initiation Date \t Sex \t DoB \t Age \t Prof \t Statut \t Date de prescription \t Date de prelèvement \t Date de résultat \t Nombre de copie \n";	

	$li=1; 
	while ($rrows = mysqli_fetch_array($rs_total)) {									
										
									$summary[$li]= $rrows;
									$summary[$li]['code']=null;
									$summary[$li]['dateOfOrder']=null;
									$summary[$li]['dateOfsample']=null;
									$summary[$li]['dateOfresult']=null;
									$summary[$li]['vlCount']=null;	
										
									$req2="SELECT * FROM `dhappdatabase`.`viralLoad`  WHERE (`serialNumber`='$rrows[serialNumber]') and (`dateOfsample` BETWEEN '$get[startDate]' AND '$get[endDate]' )";
									$rs_total2 = mysqli_query($link, $req2);									
																				
									while ($rrows2 = mysqli_fetch_array($rs_total2)) {											
											
									$summary[$li]['dateOfOrder']= $rrows2['dateOfOrder'];
									$summary[$li]['dateOfsample']= $rrows2['dateOfsample'];
									$summary[$li]['dateOfresult']= $rrows2['dateOfresult'];
									$summary[$li]['vlCount']= $rrows2['vlCount'];							
										}																			
										 
										$Code = $summary[$li]['serialNumber'];
										$patientARTCode = $summary[$li]['patientARTCode'];
										$artSartDate = $summary[$li]['artSartDate'];
										$Sex = $summary[$li]['sex'];
										$DoB = $summary[$li]['dateOfBirth'];
										$Age = $summary[$li]['age'];
										$Prof = $summary[$li]['profession'];
										$Statut = $summary[$li]['patientExitMode'];										
										$dateOfOrder= $summary[$li]['dateOfOrder'];
										$dateOfsample= $summary[$li]['dateOfsample'];
										$dateOfresult= $summary[$li]['dateOfresult'];
										$vlCount= $summary[$li]['vlCount'];
										
										$excel .= "$Code \t $patientARTCode \t $artSartDate \t $Sex \t $DoB \t $Age \t $Prof \t $Statut \t $dateOfOrder \t $dateOfsample \t $dateOfresult \t $vlCount \n";													
										$li++;
									} 
	header("Content-type: application/vnd.ms-excel");
	header("Content-disposition: attachment; filename=ViralLoadFollowUP-".date('Y-m-d').".xls");
	print $excel;
	exit; 
?>