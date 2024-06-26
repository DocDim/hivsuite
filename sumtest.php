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
	$excel ="Code \t Sex \t Age \t Prof \t Statut \t Jan \t Fev \t Mar \t Apr \t May \t Jun \t Jul \t Aug \t Sept \t Oct \t Nov \t Dec \n";	

	$li=1; 
	while ($rrows = mysqli_fetch_array($rs_total)) {									
										
										$summary[$li]= $rrows;
										$summary[$li]['Jan']=0;
										$summary[$li]['Fev']=0;
										$summary[$li]['Mar']=0;
										$summary[$li]['Apr']=0;
										$summary[$li]['May']=0;
										$summary[$li]['Jun']=0;
										$summary[$li]['Jul']=0;
										$summary[$li]['Aug']=0;
										$summary[$li]['Sep']=0;
										$summary[$li]['Oct']=0;
										$summary[$li]['Nov']=0;
										$summary[$li]['Dec']=0;
										
										$req2="SELECT * FROM `dhappdatabase`.`dispensation`  WHERE (`serialNumber`='$rrows[serialNumber]') and (`dataOfPickup` BETWEEN '2019-01-01' AND '2019-09-30' )";
										$rs_total2 = mysqli_query($link, $req2);									
																				
										while ($rrows2 = mysqli_fetch_array($rs_total2)) {											
											
										$date = $rrows2['dataOfPickup'];
										$d = date_parse_from_format("Y-m-d", $date);
																													
										switch ($d["month"]) {
											case 1:
												$summary[$li]['Jan']= $summary[$li]['Jan'] + 1;
												break;
											case 2:
												$summary[$li]['Fev']= $summary[$li]['Fev'] + 1;
												break;
											case 3:
												$summary[$li]['Mar']= $summary[$li]['Mar'] + 1;
												break;
											case 4:
												$summary[$li]['Apr']= $summary[$li]['Apr'] + 1;
												break;
											case 5:
												$summary[$li]['May']= $summary[$li]['May'] + 1;
												break;
											case 6:
												$summary[$li]['Jun']= $summary[$li]['Jun'] + 1;
												break;
											case 7:
												$summary[$li]['Jul']= $summary[$li]['Jul'] + 1;
												break;
											case 8:
												$summary[$li]['Aug']= $summary[$li]['Aug'] + 1;
												break;
											case 9:
												$summary[$li]['Sep']= $summary[$li]['Sep'] + 1;
												break;
											case 10:
												$summary[$li]['Oct']= $summary[$li]['Oct'] + 1;
												break;
											case 11:
												$summary[$li]['Nov']= $summary[$li]['Nov'] + 1;
												break;
											case 12:
												$summary[$li]['Dec']= $summary[$li]['Dec'] + 1;
												break;											
										}																			
										} 
										$Code = $summary[$li]['serialNumber'];
										$Sex = $summary[$li]['sex'];
										$Age = $summary[$li]['age'];
										$Prof = $summary[$li]['profession'];
										$Statut = $summary[$li]['patientExitMode'];
										$Jan = $summary[$li]['Jan'];
										$Fev = $summary[$li]['Fev'];
										$Mar = $summary[$li]['Mar'];
										$Apr = $summary[$li]['Apr'];
										$May = $summary[$li]['May'];
										$Jun = $summary[$li]['Jun'];
										$Jul = $summary[$li]['Jul'];
										$Aug = $summary[$li]['Aug'];
										$Sept = $summary[$li]['Sep'];
										$Oct = $summary[$li]['Oct'];
										$Nov = $summary[$li]['Nov'];
										$Dec  = $summary[$li]['Dec'];
										
										$excel .= "$Code \t $Sex \t $Age \t $Prof \t $Statut \t $Jan \t $Fev \t $Mar \t $Apr \t $May \t $Jun \t $Jul \t $Aug \t $Sept \t $Oct \t $Nov \t $Dec \n";													
										$li++;
									} 
	header("Content-type: application/vnd.ms-excel");
	header("Content-disposition: attachment; filename=ListePatient-".date('Y-m-d').".xls");
	print $excel;
	exit; 
?>