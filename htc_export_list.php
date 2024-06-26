<?php 
include 'dbc.php'; 

	$query = "SELECT * from `dhappdatabase`.`htc`";
	$result = mysql_query($query) or die(mysql_error());
	// Entêtes des colonnes dans le fichier Excel
	$excel ="num \t dateOftest \t region \t facility \t unit \t documentSource \t patientCode \t age \t sex \t profession \t knowPrevStatus \t prevStatut \t reasonTest \t newStatus \t retrivedResults \t nameOfConsellor \t referral \t treatmentCenter \t treatmentCode \t referredBy \n";
	
	
	
	
	//Les resultats de la requette
	while($tab = mysql_fetch_array($result)) 
	{
		$excel .= "$tab[0] \t $tab[1] \t $tab[2] \t $tab[3] \t $tab[4] \t $tab[5] \t $tab[6] \t $tab[7] \t $tab[8] \t $tab[9] \t $tab[10] \t $tab[11] \t $tab[12] \t $tab[13] \t $tab[14] \t $tab[15] \t $tab[16] \t $tab[17] \t $tab[18] \t $tab[19] \n";
	}
	header("Content-type: application/vnd.ms-excel");
	header("Content-disposition: attachment; filename=HTC-".date('Y-m-d').".xls");
	print $excel;
	exit; 
?>