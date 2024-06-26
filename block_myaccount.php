<div class="myaccount">
	<table>
		<tr>
			<td>
				<p align="center">
					Welcome <?php echo $_SESSION['user_name'];?>  
				</p>			
			</td>
		</tr>
	</table>
	<table width="80%" >
		<tr>
			<td valign="bottom">
				<p align="center">
					<a href="myaccount.php"><img src="images/home-icon.png" width="35px"/></a><br>
					<a href="myaccount.php">Admin Panel</a>
				</p>
			</td>
			<td valign="bottom">
				<p align="center">
					<a href="mysettings.php"><img src="images/config.png" width="35px"/></a><br>
					<a href="mysettings.php">Settings</a>
				</p>
			</td>
			<td valign="bottom">
				<p align="center">
					<a href="logout.php"><img src="images/exit.png" width="35px"/></a><br>
					<a href="logout.php">Logout </a>
				</p>
			</td>
		</tr>			
	</table>			
				    
</div>