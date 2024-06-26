<table> 
					<tr>
						<?php if(checkAdmin()) {
						
						echo '<td>
						<p align="center"> 
							<a href="admin.php"><img src="images/user-manager-icon.png" width="65px"/></a><br>
							<a href="admin.php">Manage Users </a>
						</p >
						</td>';
						
						}
						?>
						<!--<td>
						<p align="center"> 
							<a href="prev_list.php"><img src="images/HIVPrev.png" width="75px"/></a><br>
							<a href="prev_list.php">Prevention</a>
						</p>
						</td>-->
						<td>
						<p align="center"> 
							<a href="htc_list.php"><img src="images/HIVTest.png" width="70px"/></a><br>
							<a href="htc_list.php">Dépistage</a>
						</p>
						</td>
						<td>
						<p align="center"> 
							<a href="patient_list.php"><img src="images/Patient_Center_Icon.png" width="75px"/></a><br>
							<a href="patient_list.php">Suivi patient</a>
						</p>
						</td>
						<td>
						<p align="center"> 
							<a href="statistics.php"><img src="images/statistics.png" width="65px"/></a><br>
							<a href="statistics.php">Statistique et Rapports </a>
						</p> 
						</td>
						<td>
						<p align="center"> 
							<a href="data_list.php"><img src="images/gestion_data.png" width="65px"/></a><br>
							<a href="data_list.php">Gestion des données</a>
						</p> 
						</td>
					</tr>
</table>	