<?php 
include 'dbc.php';

page_protect();
echo 'test1';

if(!checkAdmin() and !clinicien() and !pharmacien() and !nurse()) {
header("Location: login.php");
exit();
}


function redir($url){
	echo '<script language="javascript">';
	echo 'window.location="',$url,'";';
	echo '</script>';
} 
echo 'test2';
$host  = $_SERVER['HTTP_HOST'];
$host_upper = strtoupper($host);
$login_path = @preg_replace('admin','',dirname($_SERVER['PHP_SELF']));
$path   = rtrim($login_path, '/\\');
echo 'test3';
// filter GET values
foreach($_GET as $key => $value) {
	$get[$key] = filter($value);
}
echo 'test4';
foreach($_POST as $key => $value) {
	$post[$key] = filter($value);
}

$Code = $_POST['Code'];

if(@$_POST['doSubmit'] == 'Dispenser'){
	
header("Location: dispensation_form.php?Code=$Code");
exit();							
}else{if(@$_POST['doSubmit'] == 'Afficher'){	
header("Location: patient_followup_sheet.php?Code=$Code");
exit();							
}
}
	
?>