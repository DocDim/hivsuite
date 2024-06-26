<?php 
include 'dbc.php';
	$sql1 = "SELECT * FROM `dhappdatabase`.`dispensation` ORDER BY `id` ASC"; 
	$rs_total = mysqli_query($link, $sql1);
	$li=1; 
	
	while ($rrows = mysqli_fetch_array($rs_total)) {
		
		$req1=mysqli_query($link,"UPDATE `dhappdatabase`.`patient` SET `lastVisit`='$rrows[dataOfPickup]', `nextVisit`='$rrows[nextPickupDate]' WHERE serialNumber='$rrows[serialNumber]'");
							
		if (!$req1) {
			echo $rrows['serialNumber'];
			die(mysqli_error($req1));
		}
		
				
		$li++;
		} 

echo 'Successful Updated...';
?>


