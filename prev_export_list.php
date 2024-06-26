<?php 
include 'dbc.php'; 

	$query = "SELECT * FROM fiche_de_prevention";
	$result = mysql_query($query) or die(mysql_error());
	// Entêtes des colonnes dans le fichier Excel
	$excel ="sn \t Nom_personnel \t Date_prev \t Code_client \t Age-client \t Sexe_client \t Adresse_client \t Profession_client \t Grade_client \t Statut_matrimonial \t nbr_enfant \t Strategie_prevention \t Condom_recu \t refere_vers \t refere_pour \t Signe_IST \t Grossesse \t PWID \t TS \t MSM \t Transsexuel \t date_rendez_Vous \n";
	
	
	//Les resultats de la requette
	while($tab = mysql_fetch_array($result)) 
	{
		$excel .= "$tab[0] \t $tab[1] \t $tab[2] \t $tab[3] \t $tab[4] \t $tab[5] \t $tab[6] \t $tab[7] \t $tab[8] \t $tab[9] \t $tab[10] \t $tab[11] \t $tab[12] \t $tab[13] \t $tab[14] \t $tab[15] \t $tab[16] \t $tab[17] \t $tab[18] \t $tab[19] \t $tab[20] \t $tab[21] \n";
	}
	header("Content-type: application/vnd.ms-excel");
	header("Content-disposition: attachment; filename=PREV-".date('Y-m-d').".xls");
	print $excel;
	exit; 
?>