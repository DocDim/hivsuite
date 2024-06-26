<?php 
include 'dbc.php';
page_protect();

if(!checkAdmin()) {
header("Location: login.php");
exit();
}

$page_limit = 10; 


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

if(!empty($_POST['doBan']) and ($_POST['doBan'] == 'Ban')) {

if(!empty($_POST['u'])) {
	foreach ($_POST['u'] as $uid) {
		$id = filter($uid);
		mysqli_query($link, "update users set banned='1' where id='$id' and `user_name` <> 'admin'");
	}
 }
 $ret = $_SERVER['PHP_SELF'] . '?'.$_POST['query_str'];;
 
 header("Location: $ret");
 exit();
}

if(!empty($_POST['doUnban']) and ($_POST['doUnban'] == 'Unban')) {

if(!empty($_POST['u'])) {
	foreach ($_POST['u'] as $uid) {
		$id = filter($uid);
		mysqli_query($link, "update users set banned='0' where id='$id'");
	}
 }
 $ret = $_SERVER['PHP_SELF'] . '?'.$_POST['query_str'];;
 
 header("Location: $ret");
 exit();
}

if(!empty($_POST['doDelete']) and ($_POST['doDelete'] == 'Delete')) {

if(!empty($_POST['u'])) {
	foreach ($_POST['u'] as $uid) {
		$id = filter($uid);
		mysqli_query($link, "delete from users where id='$id' and `user_name` <> 'admin'");
	}
 }
 $ret = $_SERVER['PHP_SELF'] . '?'.$_POST['query_str'];;
 
 header("Location: $ret");
 exit();
}

if(!empty($_POST['doApprove']) and ($_POST['doApprove'] == 'Approve')) {

if(!empty($_POST['u'])) {
	foreach ($_POST['u'] as $uid) {
		$id = filter($uid);
		mysqli_query($link, "update users set approved='1' where id='$id'");
		
	list($to_email) = mysqli_fetch_row(mysqli_query($link, "select user_email from users where id='$uid'"));	
 
$message = 
"Hello,\n
Thank you for registering with us. Your account has been activated...\n

*****LOGIN LINK*****\n
http://$host$path/login.php

Thank You

Administrator
$host_upper
______________________________________________________
THIS IS AN AUTOMATED RESPONSE. 
***DO NOT RESPOND TO THIS EMAIL****
";

@mail($to_email, "User Activation", $message,
    "From: \"Member Registration\" <auto-reply@$host>\r\n" .
     "X-Mailer: PHP/" . phpversion()); 
	 
	}
 }
 
 $ret = $_SERVER['PHP_SELF'] . '?'.$_POST['query_str'];	 
 header("Location: $ret");
 exit();
}


$rs_all = mysqli_query($link, "select count(*) as total_all from users");
if (!$rs_all) {
	die(mysqli_error($rs_all));
}
$rs_active = mysqli_query($link, "select count(*) as total_active from users where approved='1'");
if (!$rs_active) {
	die(mysqli_error($rs_active));
}

$rs_total_pending = mysqli_query($link, "select count(*) as tot from users where approved='0'");	
if (!$rs_total_pending) {
	die(mysqli_error($rs_total_pending));
}					   

list($total_pending) = mysqli_fetch_row($rs_total_pending);
list($all) = mysqli_fetch_row($rs_all);
list($active) = mysqli_fetch_row($rs_active);


?>
<!------------------Header Block------------------------------------------------------------------------->
	
<?php	
include 'block_header.php';
	
?>	
<!------------------- #end Header --------------------------------------------------------------->   
 

   
	<div id="main-wrapper" class="clearfix">
		<div id="main" class="row-fluid">
		<div  id="second_sidebar" class="column sidebar span3">
				<h2 id="block_entete" >Mon compte </h2>  
		
				<?php 
				/*********************** MYACCOUNT MENU ****************************
				This code shows my account menu only to logged in users. 
				Copy this code till END and place it in a new html or php where
				you want to show myaccount options. This is only visible to logged in users
				*******************************************************************/
				if (isset($_SESSION['user_id'])) {
				include'block_myaccount.php';}
				if (checkAdmin()) {
				/*******************************END**************************/
				?>
				<h2 id="block_entete" >Gestion des Utilisateurs </h2>
				<table>
					<tr>
						<td>
						<p align="center"> 
							<a href="admin.php"><img src="images/edit-user-icon.png" width="65px"/></a><br>
							<a href="admin.php">Modifier un utilisateur </a>
						</p align="center">
						<td>
						<td>
						<p align="center"> 
							<a href="create_user.php"><img src="images/add-user-icon.png" width="60px"/></a><br>
							<a href="create_user.php">Ajouter un utilisateur </a>
						</p align="center">
						</td>
						<td>&nbsp;</td>
						
					</tr>
				</table>
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

	

	
    <h3 class="titlehdr">Modifier un utilisateur</h3>
      <table width="100%" border="0" cellpadding="5" cellspacing="0" class="myaccount">
        <tr>
          <td>Nombre Total d'utilisateurs: <?php echo $all;?></td>
          <td>Utilisateurs Actifs: <?php echo $active; ?></td>
          <td>Utilisateurs en attente: <?php echo $total_pending; ?></td>
        </tr>
      </table>
      <p><?php 
	  if(!empty($msg)) {
	  echo $msg[0];
	  }
	  ?></p>
    <table width="80%" border="0" align="left" cellpadding="10" cellspacing="0" style="background-color: #E4F8FA;padding: 2px 5px;border: 1px solid #CAE4FF;" >
        <tr>
          <td><form name="form1" method="get" action="admin.php">
		  
				<table>
					<tr>
					   <td>	<label for="q">Recherche</label> </td> 
					   <td><input name="q" type="text" id="q" size="40" placeholder="Saisissez le nom de l'e-mail ou de l'utilisateur"></td> 
					</tr>
					<tr>
						<td></td>
						<td>
							<fieldset >
								<legend>Vous pouvez laisser la recherche vide si vous utilisez l'option ci-dessous </legend>
									<p align="left">
										<input type="radio" name="qoption" value="pending">
										Utilisateurs en attente <br>
										<input type="radio" name="qoption" value="recent">
										Récemment enregistré <br>
										<input type="radio" name="qoption" value="banned">
										Utilisateurs interdits <br>
									</p>
							</fieldset>
						</td>
					</tr>
					<tr>
					   <td>	</td> 
					   <td><p align="left"><input name="doSearch" type="submit" id="doSearch2" value="Recherche"></p></td> 
					</tr>
				</table> 
              </form>
			</td>
        </tr>
	</table>
      <p>
      <?php if (!empty($get['doSearch']) and ($get['doSearch'] == 'Recherche')) {
	  $cond = '';
	 /* if($get['qoption'] == 'pending') {
	  $cond = "where `approved`='0' order by date desc";
	  }
	  if($get['qoption'] == 'recent') {
	  $cond = "order by date desc";
	  }
	  if($get['qoption'] == 'banned') {
	  $cond = "where `banned`='1' order by date desc";
	  }*/
	  
	  if($get['q'] == '') { 
	  $sql = "select * from users $cond"; 
	  } 
	  else { 
	  $sql = "select * from users where `user_email` = '$_REQUEST[q]' or `user_name`='$_REQUEST[q]' ";
	  }

	  
	  $rs_total = mysqli_query($link, $sql);
	  if (!$rs_total) {
			die(mysqli_error($rs_total));
		}
	  $total = mysqli_num_rows($rs_total);
	  
	  if (!isset($_GET['page']) )
		{ $start=0; } else
		{ $start = ($_GET['page'] - 1) * $page_limit; }
	  
	  $rs_results = mysqli_query($link, $sql . " limit $start,$page_limit");
	  if (!$rs_results) {
		die(mysqli_error($rs_results));
		}	
	  $total_pages = ceil($total/$page_limit);
	  
	  ?>
      <p> &nbsp; 
            
      <p align="right"> 
        <?php 
	  
	  // outputting the pages
		if ($total > $page_limit)
		{
		echo "<div><strong>Pages:</strong> ";
		$i = 0;
		while ($i < $page_limit)
		{
		
		
		$page_no = $i+1;
		$qstr = @preg_replace("&page=[0-9]+","",$_SERVER['QUERY_STRING']);
		echo "<a href=\"admin.php?$qstr&page=$page_no\">$page_no</a> ";
		$i++;
		}
		echo "</div>";
		}  ?>
		</p>
		<form name "searchform" action="admin.php" method="post">
        <table width="100%" border="0" align="center" cellpadding="2" cellspacing="0">
          <tr bgcolor="#E6F3F9"> 
            <td width="4%"><strong>ID</strong></td>
            <td> <strong>Date</strong></td>
            <td><strong>Nom d'utilisateurs</strong></td>
            <td width="15%"><strong>Email</strong></td>
            <td width="10%"><strong>Approbation</strong></td>
            <td width="10%"> <strong>Interdit</strong></td>
			<td width="30%">&nbsp;</td>
          </tr>
          <tr> 
            <td>&nbsp;</td>
            <td width="10%">&nbsp;</td>
            <td width="17%"><div align="center"></div></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
			
          </tr>
          <?php while ($rrows = mysqli_fetch_array($rs_results)) {?>
          <tr> 
            <td><input name="u[]" type="checkbox" value="<?php echo $rrows['id']; ?>" id="u[]"></td>
            <td><?php echo $rrows['date']; ?></td>
            <td> <?php echo $rrows['user_name'];?></td>
            <td><?php echo $rrows['user_email']; ?></td>
            <td> <span id="approve<?php echo $rrows['id']; ?>"> 
              <?php if(!$rrows['approved']) { echo "Pending"; } else {echo "Active"; }?>
              </span> </td>
            <td><span id="ban<?php echo $rrows['id']; ?>"> 
              <?php if(!$rrows['banned']) { echo "no"; } else {echo "yes"; }?>
              </span> </td>
            <td> <font size="2"><a href="javascript:void(0);" onclick='$.get("do.php",{ cmd: "approve", id: "<?php echo $rrows['id']; ?>" } ,function(data){ $("#approve<?php echo $rrows['id']; ?>").html(data); });'>Approuver</a> &nbsp;
              <a href="javascript:void(0);" onclick='$.get("do.php",{ cmd: "ban", id: "<?php echo $rrows['id']; ?>" } ,function(data){ $("#ban<?php echo $rrows['id']; ?>").html(data); });'>Banni</a> &nbsp;
              <a href="javascript:void(0);" onclick='$.get("do.php",{ cmd: "unban", id: "<?php echo $rrows['id']; ?>" } ,function(data){ $("#ban<?php echo $rrows['id']; ?>").html(data); });'>Rétablir</a> &nbsp;
              <a href="javascript:void(0);" onclick='$("#edit<?php echo $rrows['id'];?>").show("slow");'>Modifier</a> 
              </font> </td>
          </tr>
          <tr> 
            <td colspan="7">
			
			<div style="display:none;font: normal 11px arial; padding:10px; background: #e6f3f9" id="edit<?php echo $rrows['id']; ?>">
			
			<input type="hidden" name="id<?php echo $rrows['id']; ?>" id="id<?php echo $rrows['id']; ?>" value="<?php echo $rrows['id']; ?>">
			Nom d'utilisateur: <input name="user_name<?php echo $rrows['id']; ?>" id="user_name<?php echo $rrows['id']; ?>" type="text" size="10" value="<?php echo $rrows['user_name']; ?>" >
			Email:<input id="user_email<?php echo $rrows['id']; ?>" name="user_email<?php echo $rrows['id']; ?>" type="text" size="20" value="<?php echo $rrows['user_email']; ?>" >
			Niveau d'acces: <input id="user_level<?php echo $rrows['id']; ?>" name="user_level<?php echo $rrows['id']; ?>" type="text" size="5" value="<?php echo $rrows['user_level']; ?>" >  0->Infirmier,1->Pharmacien,2->Clinicien,3->operateur,4->superviseur,5->administrateur	
			<br><br>Nouveau mot de passe: <input id="pass<?php echo $rrows['id']; ?>" name="pass<?php echo $rrows['id']; ?>" type="text" size="20" value="" ><br>
			<input name="doSave" type="button" id="doSave" value="Enregistrer" 
			onclick='$.get("do.php",{ cmd: "edit", pass:$("input#pass<?php echo $rrows['id']; ?>").val(),user_level:$("input#user_level<?php echo $rrows['id']; ?>").val(),user_email:$("input#user_email<?php echo $rrows['id']; ?>").val(),user_name: $("input#user_name<?php echo $rrows['id']; ?>").val(),id: $("input#id<?php echo $rrows['id']; ?>").val() } ,function(data){ $("#msg<?php echo $rrows['id']; ?>").html(data); });'> 
			&nbsp; &nbsp;<a  onclick='$("#edit<?php echo $rrows['id'];?>").hide();' href="javascript:void(0);">Fermer</a>
		 
		  <div style="color:red" id="msg<?php echo $rrows['id']; ?>" name="msg<?php echo $rrows['id']; ?>"></div>
		  </div>
		  
		  </td>
          </tr>
          <?php } ?>
        </table>
	    <p><br>
          <input name="doApprove" type="submit" id="doApprove" value="Approve">
          <input name="doBan" type="submit" id="doBan" value="Ban">
          <input name="doUnban" type="submit" id="doUnban" value="Unban">
          <input name="doDelete" type="submit" id="doDelete" value="Delete">
          <input name="query_str" type="hidden" id="query_str" value="<?php echo $_SERVER['QUERY_STRING']; ?>"></p> 
          <p><strong>Note:</strong> Si vous supprimez l'utilisateur peut s'inscrire à nouveau, il faut plûtot bannir l'utilisateur. </p> 
		  <p><strong>Modifier un utilisateur:</strong> Pour modifier le courrier électronique, le nom d'utilisateur ou le mot de passe,Vous devez d'abord supprimer l'utilisateur et créer un nouveau avec le même email et Nom d'utilisateur.</p>
      </form>
	  
	  <?php } ?>
       </td>
    <td width="12%">&nbsp;</td>

						
			</div>
			
		</div>
	</div>
     

   
   
<!---------------------------------footer --------------------------------------------->
<?php	
include 'block_footer.php';
	
?>	
<!---------------------------------# end footer ------------------------------------->

