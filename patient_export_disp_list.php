<?php 
include 'dbc.php'; 

	$query = "SELECT patient.*, dispensation.* FROM patient, dispensation WHERE patient.serialNumber = dispensation.serialNumber order by patient.serialNumber";
	$result = mysqli_query($link, $query);
	// Entêtes des colonnes dans le fichier Excel
	$excel ="codePatient \t  region \t  facility \t  serialNumber \t  enrolmentDate \t  patientARTCode \t  artSartDate \t  city \t  areaVillage \t  profession \t  patientFirstContact \t  patientSecondContact \t  Statut_matrimonial \t  nbr_enfant \t  nameOfcontactPerson \t  contactStelephoneNum \t  sex \t  dateOfBirth \t  age \t  weight \t  height \t  bmi \t  whoClinicalStage \t  CD4Value \t  dateOfCD4 \t  pregnancy \t  breatfeeding \t  tbScreening \t  arvregimen \t  patientExitMode \t  dataOfPickup\t  nextPickupDate\t  regimen\t  nbBox\n";
	
	
	//Les resultats de la requette
	while ($tab = mysqli_fetch_array($result))
	{
		$excel .= "$tab[0] \t $tab[1] \t $tab[2] \t $tab[3] \t $tab[4] \t $tab[5] \t $tab[6] \t $tab[7] \t $tab[8] \t $tab[9] \t $tab[10] \t $tab[11] \t $tab[12] \t $tab[13] \t $tab[14] \t $tab[15] \t $tab[16] \t $tab[17] \t $tab[18] \t $tab[19] \t $tab[20] \t $tab[21] \t $tab[22] \t $tab[23] \t $tab[24] \t $tab[25] \t $tab[26] \t $tab[27] \t $tab[28] \t $tab[29]  \t $tab[32] \t $tab[33] \t $tab[34] \t $tab[35]\n";
	}
	header("Content-type: application/vnd.ms-excel");
	header("Content-disposition: attachment; filename=ListePatient-".date('Y-m-d').".xls");
	print $excel;
	exit; 
?>