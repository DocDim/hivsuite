<?php
include 'dbc.php';

	$query = "SELECT * FROM dove2_ircs";
	$result = mysql_query($query) or die(mysql_error());
	// Entêtes des colonnes dans le fichier Excel
	$excel ="id \t sms_id \t tel_enquet \t num_patient \t initiale \t age \t sex \t village \t air_sante \t dist_sante \t for_sanitaire \t consent \t nbr_selle \t type_dia \t dia_depuis_7 \t symptom \t soif \t elast_peau \t deshydra \t cas_suspect \t date_debut \t date_consult \t date_traite \t patient_host \t sro_avant \t soin_rehydra \t dure_consul_rehydra \t antibio \t result_dip \t collect_filtre \t collect \t itineraire \t evolution \t cat_pers \t cas_dia_fam \t cas_dia_vil \t transport \t temps \t dose_polio_oral \t dose_rota \t dose_ora_cho \t date_collect \t initiale_pers \n";
	
	//Les resultats de la requette
	while($tab = mysql_fetch_array($result)) 
	{
		$excel .= "$tab[0] \t $tab[1] \t $tab[2] \t $tab[3] \t $tab[4] \t $tab[5] \t $tab[6] \t $tab[7] \t $tab[8] \t $tab[9] \t $tab[10] \t $tab[11] \t $tab[12] \t $tab[13] \t $tab[14] \t $tab[15] \t $tab[16] \t $tab[17] \t $tab[18] \t $tab[19] \t $tab[20] \t $tab[21] \t $tab[22] \t $tab[23] \t $tab[24] \t $tab[25] \t $tab[26] \t $tab[27] \t $tab[28] \t $tab[29] \t $tab[30] \t $tab[31] \t $tab[32] \t $tab[33] \t $tab[34] \t $tab[35] \t $tab[36] \t $tab[37] \t $tab[38] \t $tab[39] \t $tab[40] \t $tab[41] \t $tab[42]\n";
	}
	header("Content-type: application/vnd.ms-excel");
	header("Content-disposition: attachment; filename=ircs-".date('Y-m-d').".xls");
	print $excel;
	exit;
?>