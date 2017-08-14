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
					$output .= '<a href=# class="hover" id="'. $row['EmailId'].'">'.$row["FirstName"].' '.$row["LastName"].'</a></br>';
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
				//display popover by accepting emailid as input, makes ajax request to fetch.php to get user data
				echo "<script>
					$(document).ready(function(){
						$('.hover').popover({
							title:fetchData,
							html:true,
							placement:'right'
						});
						
						function fetchData()
						{
							var fetch_data='';
							var element=$(this);
							var id=element.attr('id');
							$.ajax({
								url:'fetch.php',
								method:'POST',
								async:false,
								data:{emailid:id},
								success:function(data)
								{
									fetch_data=data;
								}
							});
							return fetch_data;
						}
					});
				</script>";
	
}
?>