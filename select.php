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
if(isset($_POST['JoinGroup'])){
	$output_join_group = '';
	//connects to db
	include("connection.php");
	//get all members of that group
	$query_join_member_info="select * from user where user_groupname='". $_POST['JoinGroup']. "'";
	//execute the member query
	$result_join_member_info=mysqli_query($conn, $query_join_member_info);
	//get count of members, +1 inclusive of the current candidate
	$count_existing_members=mysqli_affected_rows($conn)+1;
	//get group info
	$query_join_group_info="select * from user_group where GroupName='".$_POST['JoinGroup']."'";
	//execute group query
	$result_join_group_info=mysqli_query($conn, $query_join_group_info);
	//getvalues from that group
	$row_group_info=mysqli_fetch_array($result_join_group_info);
	$max_members_group=$row_group_info["MaxMembers"];
	//if group full
	if($count_existing_members>$max_members_group){
		$output_join_group='<div>Group full, join request cannot be processed</div>';
	}
	//if group not full
	else{
			//set group status full if adding this member=maxmembers limit
			if($count_existing_members==$max_members_group)
			{
				$query_update_grp_status="update user_group set GroupStatus=1 where GroupName='".$_POST['JoinGroup']."'";
				if(!mysqli_query($conn, $query_update_grp_status))
				{
					echo("Update group status, Error description: " . mysqli_error($con). "</br>");
				}
				else{
					//echo "group status set to full</br>";
				}
				
			}
			//update user group name to current group
			//$query_update_user_group="update user set user_groupname='".$_POST['JoinGroup']."' where EmailId='". $_SESSION["user"] ."'";
			$query_update_user_group="update user set user_groupname='".$_POST['JoinGroup']."' where EmailId='ramyav@yahoo.com'";
			if(!mysqli_query($conn, $query_update_user_group))
			{
				echo("Update user group, Error description: " . mysqli_error($con));
			}
			else{
				//echo "current user group updated</br>";
			}
			//set session var of user
			$_SESSION['groupname']=$_POST['JoinGroup'];
			//get name of current user
			//$query_current_user="select FirstName, LastName from user where EmailId='".$_SESSION['user']."'";
			$query_current_user="select FirstName, LastName from user where EmailId='ramyav@yahoo.com'";
			$result_current_user=mysqli_query($conn, $query_current_user);
			$row_current_user=mysqli_fetch_array($result_current_user);
			$name_user=$row_current_user['FirstName'].' '.$row_current_user['LastName'];
			//send notification to current user
			//notification content
			$notification_content='You have joined group named '.$_POST['JoinGroup'];
			//$query_notify_user="insert into notifications values($_SESSION['user'],$notification_content,1 )";
			$query_notify_user="insert into notifications values('ramyav@yahoo.com','$notification_content',1 )";
			if(!mysqli_query($conn, $query_notify_user)){
				echo("Notify user, Error description: " . mysqli_error($conn)."</br>");
				echo "notification to current user failed</br>";
			}
			else{
				//echo "notified current user</br>";
			}
			//send notification to all group members (except current user)-check
			//notification content
			$notification_content=$name_user.' has joined your group';
			//get members into array
			while($current_members_group=mysqli_fetch_array($result_join_member_info))
			{
				$member_email=$current_members_group['EmailId'];
				$query_notify_member="insert into notifications values('$member_email','$notification_content',1 )";
				if(!mysqli_query($conn, $query_notify_member)){
					echo("Notify member, Error description: " . mysqli_error($conn)."</br>");
					echo "notification to member failed</br>";
				}
				else{
					//echo "notified member ".$current_members_group['EmailId']."</br>";
				}
			}
			$output_join_group="<div>You are now part of group named ".$_POST['JoinGroup'] ."</div>";
			
			
			
	}
	echo $output_join_group;
}
?>