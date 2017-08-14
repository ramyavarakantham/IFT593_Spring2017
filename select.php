<?php
if(isset($_POST['GroupName'])){
	$output = '';
	//connect to db
	include("connection.php");
	//get all users belonging to that group
	$query="select * from user where user_groupname='". $_POST['GroupName']. "'";
	//execute the member query
	$result=mysqli_query($conn, $query);
	//get group info
	$querygroup="select * from user_group where GroupName='".$_POST['GroupName']."'";
	//execute group query
	$resultgroup=mysqli_query($conn, $querygroup);
	//getvalues from that group
	$rowgroup=mysqli_fetch_array($resultgroup);
	//Display the results
	$output.= '<div class="table-responsive">
				<table class="table table-bordered">
				<tr>
						<td><label>Members</label></td>
						<td>';
				//Loop through members
				while($row=mysqli_fetch_array($result))
				{
					$output .= ''.$row["FirstName"].' '.$row["LastName"].'</br>';
				}
				$output .= '</td></tr>';
				//Display budget of group
				$output .= '<tr>
							<td><label>Budget</label></td>
							<td>'.$rowgroup["Budget"].'</td>
							</tr>';
				//Display apartment name of group
				$output .= '<tr>
							<td><label>Apartment Name</label></td>
							<td>'.$rowgroup["ApartmentName"].'</td>
							</tr>';
				
				$output .= '</table></div>';
				echo $output;
	
}
?>