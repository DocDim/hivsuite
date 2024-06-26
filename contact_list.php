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
$login_path = @ereg_replace("admin",'',dirname($_SERVER['PHP_SELF']));
$path   = rtrim($login_path, '/\\');

// filter GET values
foreach($_GET as $key => $value) {
	$get[$key] = filter($value);
}

foreach($_POST as $key => $value) {
	$post[$key] = filter($value);
}


if(@$_POST['doDeleteContact'] == 'Delete') {

if(!empty($_POST['u'])) {
	foreach ($_POST['u'] as $uid) {
		$id = filter($uid);
		mysql_query("delete from pbk where ID='$id'");
	}
 }
 $ret = $_SERVER['PHP_SELF'] . '?'.$_POST['query_str'];;
 header("Location: $ret");

}


?>
<!------------------Header Block----------------------------------------------------------------->
	
<?php	
include 'block_header.php';
	
?>	
<!------------------- #end Header --------------------------------------------------------------->    
 

   
	<div id="main-wrapper" class="clearfix">
		<div id="main" class="row-fluid">
			<div  id="second_sidebar" class="column sidebar span3">
				<h2 id="block_entete" >My Account </h2>  
		
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
				<h2 id="block_entete" >PhoneBook </h2>
				<table>
					<tr>
						<td>
						<p align="center"> 
							<a href="contact_list.php"><img src="images/phonebook.png" width="60px"/></a><br>
							<a href="contact_list.php">Contact List</a>
						</p align="center">
						<td>
						<td>
						<p align="center"> 
							<a href="add_contact.php"><img src="images/add_phoneicon.png" width="60px"/></a><br>
							<a href="add_contact.php">Add Contact </a>
						</p align="center">
						</td>
						<td>&nbsp;</td>
						
					</tr>
					<tr>
						<td>
						<p align="center"> 
							<a href="add_group.php"><img src="images/group_contact.png" width="60px"/></a><br>
							<a href="add_group.php">Add contact group</a>
						</p align="center">
						<td>
						<td>
						<p align="center"> 
							<a href="upload_contact.php"><img src="images/phone_upload.png" width="60px"/></a><br>
							<a href="upload_contact.php">Upload Contact </a>
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

	

	
    <h3 class="titlehdr">Contact List</h3>
      
    
      <p>
        <?php 
	  
		$sql = "select * from pbk"; 
	    $rs_total = mysql_query($sql) or die(mysql_error());
		$total = mysql_num_rows($rs_total);
	  
	  if (!isset($_GET['page']) )
		{ $start=0; } else
		{ $start = ($_GET['page'] - 1) * $page_limit; }
	  
	  $rs_results = mysql_query($sql . " limit $start,$page_limit") or die(mysql_error());
	  $total_pages = ceil($total/$page_limit);
	  
	  ?>
      
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
		$qstr = ereg_replace("&page=[0-9]+","",$_SERVER['QUERY_STRING']);
		echo "<a href=\"contact_list.php?$qstr&page=$page_no\">$page_no</a> ";
		$i++;
		}
		echo "</div>";
		}  ?>
		</p>
		<form name "searchform" action="contact_list.php" method="post">
        <table width="100%" border="0" align="center" cellpadding="2" cellspacing="0">
          <tr bgcolor="#E6F3F9"> 
            <td width="4%"><strong>ID</strong></td>
            <td> <strong>Group Name</strong></td>
            <td><strong>Name</strong></div></td>
			<td ><strong>Phone number</strong></td>
            <td>&nbsp;</td>     
          </tr>
          <tr> 
            <td>&nbsp;</td>
            <td >&nbsp;</td>
            <td >&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
			
          </tr>
          <?php while ($rrows = mysql_fetch_array($rs_results)) {?>
          <tr bgcolor="#E6F3F9"> 
            <td><input name="u[]" type="checkbox" value="<?php echo $rrows['ID']; ?>" id="u[]"></td>
            <td>
			<?php
				$gr=(int)$rrows['GroupID'];
				$sqlt="select Name from pbk_groups where `ID` = $gr";
				$rt_results = mysql_query($sqlt) or die("2");			
				while ($rowst = mysql_fetch_array($rt_results)) 
				{
				echo $rowst['Name']; 
				} 
			?>
			
			
			</td>
            <td> <?php echo $rrows['Name'];?></td>
           	<td><?php echo $rrows['Number']; ?></td>
			<td> <font size="2">
                <a href="javascript:void(0);" onclick='$("#edit<?php echo $rrows['ID'];?>").show("slow");'>Edit</a> &nbsp;&nbsp;
			</font> </td>
          </tr>
		 
          <tr> 
            <td colspan="7">
			
			<div style="display:none;font: normal 11px arial; padding:10px; background: #e6f3f9" id="edit<?php echo $rrows['ID']; ?>">
			
			<input type="hidden" name="id<?php echo $rrows['ID']; ?>" id="id<?php echo $rrows['ID']; ?>" value="<?php echo $rrows['ID']; ?>">
			Group Name:<input name="GroupID<?php echo $rrows['ID']; ?>" id="GroupID<?php echo $rrows['ID']; ?>" type="text" size="20" value="<?php echo $rrows['GroupID']; ?>" >
			Name:<input name="Name<?php echo $rrows['ID']; ?>" id="Name<?php echo $rrows['ID']; ?>"  type="text" size="20" value="<?php echo $rrows['Name']; ?>" >
			Phone Number:<input name="Number<?php echo $rrows['ID']; ?>" id="Number<?php echo $rrows['ID']; ?>" type="text" size="20" value="<?php echo $rrows['Number']; ?>" >
			<br><br><input name="doSave" type="button" id="doSave" value="Save" onclick='$.get("do.php",{ cmd: "editcontact", Number:$("input#Number<?php echo $rrows['ID']; ?>").val(),Name:$("input#Name<?php echo $rrows['ID']; ?>").val(),GroupID: $("input#GroupID<?php echo $rrows['ID']; ?>").val(),id: $("input#id<?php echo $rrows['ID']; ?>").val() } ,function(data){ $("#msg<?php echo $rrows['ID']; ?>").html(data); });'> 
			<a  onclick='$("#edit<?php echo $rrows['ID'];?>").hide();' href="contact_list.php">close</a>
		 
		  <div style="color:red" id="msg<?php echo $rrows['ID']; ?>" name="msg<?php echo $rrows['ID']; ?>"></div>
		  </div>
		  
		  </td>
          </tr>
          <?php } ?>
        </table>
	    <p><br>
          <input name="doDeleteContact" type="submit" id="doDeleteContact" value="Delete">
          <input name="query_str" type="hidden" id="query_str" value="<?php echo $_SERVER['QUERY_STRING']; ?>">
          
      </form>
	    
      &nbsp;</p>
	  
	 
	  
       
      <p>&nbsp;</p>
      <p>&nbsp;</p>
      <p>&nbsp;</p>
      <p>&nbsp;</p></td>
    <td width="12%">&nbsp;</td>

						
			</div>
			
		</div>
	</div>
     

   
   
<!---------------------------------footer --------------------------------------------->
<?php	
include 'block_footer.php';
	
?>	
<!---------------------------------# end footer ------------------------------------->
