<?php 
/********************** MYSETTINGS.PHP**************************
This updates user settings and password
************************************************************/
include 'dbc.php';
page_protect();

$err = array();
$msg = array();


if($_POST['doUpdate'] == 'Update')  
{


$rs_pwd = mysqli_query($link, "select pwd from users where id='$_SESSION[user_id]'");
list($old) = mysqli_fetch_row($rs_pwd);
$old_salt = substr($old,0,9);

//check for old password in md5 format
	if($old === PwdHash($_POST['pwd_old'],$old_salt))
	{
	$newsha1 = PwdHash($_POST['pwd_new']);
	mysqli_query($link, "update users set pwd='$newsha1' where id='$_SESSION[user_id]'");
	$msg[] = "Your new password is updated";
	//header("Location: mysettings.php?msg=Your new password is updated");
	} else
	{
	 $err[] = "Your old password is invalid";
	 //header("Location: mysettings.php?msg=Your old password is invalid");
	}

}

if($_POST['doSave'] == 'Save')  
{
// Filter POST data for harmful code (sanitize)
foreach($_POST as $key => $value) {
	$data[$key] = filter($value);
}


$req=mysqli_query($link, "UPDATE users SET
			`full_name` = '$data[name]',
			`address` = '$data[address]',
			`tel` = '$data[tel]',
			`fax` = '$data[fax]',
			`country` = '$data[country]',
			`website` = '$data[web]'
			 WHERE id='$_SESSION[user_id]'
			");
			if (!$req) {
				die(mysqli_error($req));
			}	
							

//header("Location: mysettings.php?msg=Profile Sucessfully saved");
$msg[] = "Profile Sucessfully saved";
 }
 
$rs_settings = mysqli_query($link, "select * from users where id='$_SESSION[user_id]'"); 
?>

<!------------------Header Block------------------------------------------------------------------------->
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
				include'block_myaccount.php';
				}
				if (checkAdmin()) {
				/*******************************END**************************/
				include 'block_functions_admin.php'; } 
				?>
			</div>
			<div id="content" class="column span9">
						<h3 class="titlehdr">My Account - Settings</h3>
      <p> 
        <?php	
	if(!empty($err))  {
	   echo "<div class=\"msg\">";
	  foreach ($err as $e) {
	    echo "* Error - $e <br>";
	    }
	  echo "</div>";	
	   }
	   if(!empty($msg))  {
	    echo "<div class=\"msg\">" . $msg[0] . "</div>";

	   }
	  ?>
      </p>
      <p>Here you can make changes to your profile. Please note that you will 
        not be able to change your email which has been already registered.</p>
	  <?php while ($row_settings = mysqli_fetch_array($rs_settings)) {?>
      <form action="mysettings.php" method="POST" name="myform" id="myform">
        <table width="90%" border="0" align="center" cellpadding="3" cellspacing="3" class="forms">
          <tr> 
			<td > Your Name / Company Name</td>
            <td > <input name="name" type="text" id="name"  class="required" value="<?php echo $row_settings['full_name']; ?>" size="50"> 
			</td>
          </tr>
          <tr> 
			<td > Address <span class="example">(full address with ZIP)</span></td>
            <td ><textarea name="address" cols="47" rows="4" class="required" id="address"><?php echo $row_settings['address']; ?></textarea> 
            </td>
          </tr>
          <tr> 
            <td>Country</td>
            <td><input name="country" type="text" id="country" value="<?php echo $row_settings['country']; ?>" size="50"></td>
          </tr>
          <tr> 
            <td width="27%">Phone</td>
            <td width="73%"><input name="tel" type="text" id="tel" class="required" value="<?php echo $row_settings['tel']; ?>" size="50"></td>
          </tr>
          <tr> 
            <td>Fax</td>
            <td><input name="fax" type="text" id="fax" value="<?php echo $row_settings['fax']; ?>" size="50"></td>
          </tr>
          <tr> 
            <td>Website</td>
            <td><input name="web" type="text" id="web" class="optional defaultInvalid url" value="<?php echo $row_settings['website']; ?>" size="50"> 
              <span class="example">Example: http://www.domain.com</span></td>
          </tr>
          <tr> 
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr> 
            <td>User Name</td>
            <td><input size="50" name="user_name" type="text" id="web2" value="<?php echo $row_settings['user_name']; ?>" disabled></td>
          </tr>
          <tr> 
            <td>Email</td>
            <td><input size="50" name="user_email" type="text" id="web3"  value="<?php echo $row_settings['user_email']; ?>" disabled></td>
          </tr>
        </table>
        <p align="center"> 
          <input name="doSave" type="submit" id="doSave" value="Save">
        </p>
      </form>
	  <?php } ?>
      <h3 class="titlehdr">Change Password</h3>
      <p>If you want to change your password, please input your old and new password 
        to make changes.</p>
      <form name="pform" id="pform" method="POST" action="">
        <table width="80%" border="0" align="center" cellpadding="3" cellspacing="3" class="forms">
          <tr> 
            <td width="31%">Old Password</td>
            <td width="69%"><input name="pwd_old" type="password" class="required password"  id="pwd_old"></td>
          </tr>
          <tr> 
            <td>New Password</td>
            <td><input name="pwd_new" type="password" id="pwd_new" class="required password"  ></td>
          </tr>
        </table>
        <p align="center"> 
          <input name="doUpdate" type="submit" id="doUpdate" value="Update">
        </p>
        <p>&nbsp; </p>
      </form>
      <p>&nbsp; </p>
      <p>&nbsp;</p>
	   
      <p align="right">&nbsp; </p></td>
    <td width="196" valign="top">&nbsp;</td>
  </tr>
  <tr> 
    <td colspan="3">&nbsp;</td>
  </tr>
</table>
						
			</div>
			
		</div>
	</div>


<!------------------Header Block----------------------------------------------------------------->
	
<?php	
include 'block_header.php';
	
?>	
<!------------------- #end Header --------------------------------------------------------------->  