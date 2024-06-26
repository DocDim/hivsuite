
<table> 
				<tr>
						<?php if(checkAdmin()) {
						
						echo '<td>
						<p align="center"> 
							<a href="admin.php"><img src="images/user-manager-icon.png" width="60px"/></a><br>
							<a href="admin.php">Gestion des Utilisateurs </a>
						</p >
						</td>';						
						}
						?>
						<td>
						<p align="center"> 
							<a href="htc_form.php"><img src="images/HIVTest.png" width="65px"/></a><br>
							<a href="htc_form.php">Prevention</a>
						</p>
						</td>
				</tr>
				<tr>
						<td>
						<p align="center"> 
							<a href="htc_form.php"><img src="images/HIVTest.png" width="65px"/></a><br>
							<a href="htc_form.php">Dépistage</a>
						</p>
						</td>
						<td>
						<p align="center"> 
							<a href="data_list.php"><img src="images/gestion_data.png" width="65px"/></a><br>
							<a href="data_list.php">Gestion des données</a>
						</p> 
						</td>
					</tr>
				<tr>
						<td>
						<p align="center"> 
							<a href="statistics.php"><img src="images/statistics.png" width="65px"/></a><br>
							<a href="statistics.php">Statistique et Rapports </a>
						</p> 
						</td>
						<td>
						
						</td>
					</tr>					
				</table>