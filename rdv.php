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


<?php 
								  
$sql = "select * from `dhappdatabase`.`patient` where `serialNumber` in (SELECT `serialNumber` FROM `dhappdatabase`.`dispensation`  WHERE (TO_DAYS(DATE(NOW()))=TO_DAYS(DATE(nextPickupDate))) and (`serialNumber` in (SELECT `serialNumber`  FROM (SELECT *
FROM  `dispensation`
INNER JOIN
    (SELECT `serialNumber` AS `serial`, MAX(`id`) AS `Maxscore`
    FROM `dispensation`
    GROUP BY `serial`)    `topscore`
ON `dispensation`.`serialNumber` = `topscore`.`serial` 
AND `dispensation`.`id` = `topscore`.`Maxscore`) as t)))  ORDER BY `codePatient` ASC"; 
										$rs_total = mysqli_query($link, $sql);			
								  
?>
								 
								<table width="100%" border="0" align="center" cellpadding="2" cellspacing="0">
									<tr bgcolor="#E6F3F9"> 
										<td width="10%"><strong>Code Clinique</strong></td>
										<td ><strong>Sexe</strong></td>
										<td ><strong>Age</strong></td>
										<td ><strong>Contact du patient</strong></td>					
										<td ><strong>Profession</strong></td>
										<td ><strong>Action</strong></td>
											
									  </tr>
									  
									  <?php $li=1; while ($rrows = mysqli_fetch_array($rs_total)) {?>
									  <tr bgcolor="<?php if ($li%2==0) {echo '#E6F3F9';} ?>"> 
										<td><?php echo $rrows['serialNumber'];?></td>									
										<td><?php echo $rrows['sex'];?></td>
										<td><?php echo $rrows['age'];?></td>										
										<td><?php echo $rrows['patientFirstContact']."<br>".$rrows['patientSecondContact']; ?></td>	
										<td><?php echo $rrows['profession']; ?></td>
										<td>
											<a href="patient_followup_sheet.php?Code=<?php echo $rrows['serialNumber'];?>">Voir</a> 										
											
										</td>
									  </tr>         
									  <?php $li++;} ?>
								</table>
								<form>
				<input id="impression" name="impression" type="button" onclick="imprimer_bloc('Bonjour', 'content')" value="Imprimer cette page" />
			</form>