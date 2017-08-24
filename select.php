<?php
SESSION_START();
include("connection.php");
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
	if(!mysqli_query($conn, $query_join_group_info)){
		$output_join_group.='<div>'.mysqli_error($conn).'<div>';
	}
	//execute group query
	$result_join_group_info=mysqli_query($conn, $query_join_group_info);
	//getvalues from that group
	$row_group_info=mysqli_fetch_array($result_join_group_info);
	$max_members_group=$row_group_info['MaxMembers'];
	//if group full
	if($count_existing_members > $max_members_group){
		$output_join_group.='<div>Group full, join request cannot be processed</div>';
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
			//$query_notify_user="insert into notifications (EmailId, Notification_content, Type) values($_SESSION['user'],$notification_content,1 )";
			$query_notify_user="insert into notifications (EmailId, Notification_content, Type) values('ramyav@yahoo.com','$notification_content',1 )";
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
				$query_notify_member="insert into notifications (EmailId, Notification_content, Type) values('$member_email','$notification_content',1 )";
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
if(isset($_POST['MyGroup'])){
	$output = '';
	//get all users belonging to that group
	$query="select * from user where user_groupname='". $_POST['MyGroup']. "'";
	//execute the member query
	$result=mysqli_query($conn, $query);
	//get group info
	$querygroup="select * from user_group where GroupName='".$_POST['MyGroup']."'";
	//execute group query
	$resultgroup=mysqli_query($conn, $querygroup);
	//getvalues from that group
	$rowgroup=mysqli_fetch_array($resultgroup);
	//Display the results
	$output.= '<div class="table-responsive">
				<table class="table">
					<thead>
						<tr>
							<th>My Group Details</th>
							<th style="text-align:right"><button type="button"  class="btn btn-info btn-sm" data-toggle="modal" data-target="#contactmod" >Edit</button></th>
						</tr>
				</thead>
				<tbody>';
				//Display group name
				$output .= '<tr>
							<td>Group Name</td>
							<td>'.$rowgroup["GroupName"].'</td>
							</tr>';
				//Display budget of group
				$output .= '<tr>
							<td>Budget</td>
							<td>'.$rowgroup["Budget"].'</td>
							</tr>';
				//Display apartment name of group
				$output .= '<tr>
							<td>Apartment Name</td>
							<td>'.$rowgroup["ApartmentName"].'</td>
							</tr>';
				//Display Max members of group
				$output .= '<tr>
							<td>Max Members</td>
							<td>'.$rowgroup["MaxMembers"].'</td>
							</tr>';
				//Loop through members			
				$output.='<tr>
						<td>Members</td>
						<td>';
				while($row=mysqli_fetch_array($result))
				{
					$output .= '<a href=# class="hover" id="'. $row['EmailId'].'">'.$row["FirstName"].' '.$row["LastName"].'</a></br>';
				}
				$output .= '</td></tr>';
				$output .= '</tbody></table></div>';
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
if(isset($_POST['ExitGroup'])){
	$output_exit_group = '';
	//connects to db
	include("connection.php");
	//get all members of that group
	$query_exit_member_info="select * from user where user_groupname='". $_POST['ExitGroup']. "'";
	//execute the member query
	$result_exit_member_info=mysqli_query($conn, $query_exit_member_info);
	//get count of members
	$count_existing_members=mysqli_affected_rows($conn);
	//echo "number of existing members: ".$count_existing_members. "</br>";
	//get group info
	$query_exit_group_info="select * from user_group where GroupName='".$_POST['ExitGroup']."'";
	//execute group query
	$result_exit_group_info=mysqli_query($conn, $query_exit_group_info);
	//getvalues from that group
	$row_group_info=mysqli_fetch_array($result_exit_group_info);
	$max_members_group=$row_group_info["MaxMembers"];
	//echo "number of existing members: ".$max_members_group."</br>";
	
	//if group full
	if($count_existing_members==$max_members_group){
		$update_group_status="update user_group set GroupStatus=0 where GroupName='".$_POST['ExitGroup']."'";
		if(!mysqli_query($conn, $update_group_status)){
			echo "could not update group status from full to vacant</br>";
		}
		else{
			//echo "updated group status from full to vacant</br>";
		}
			
	}
	
			//update user group name to current group
			//$query_update_user_group="update user set user_groupname='".$_POST['JoinGroup']."' where EmailId='". $_SESSION["user"] ."'";
			$query_update_user_group="update user set user_groupname='' where EmailId='ramyav@yahoo.com'";
			if(!mysqli_query($conn, $query_update_user_group))
			{
				echo("Update user group, Error description: " . mysqli_error($con));
			}
			else{
				//echo "current user group updated</br>";
			}
			
			//set session var of user
			$_SESSION['groupname']='';
			
			//get name of current user
			//$query_current_user="select FirstName, LastName from user where EmailId='".$_SESSION['user']."'";
			$query_current_user="select FirstName, LastName from user where EmailId='ramyav@yahoo.com'";
			$result_current_user=mysqli_query($conn, $query_current_user);
			$row_current_user=mysqli_fetch_array($result_current_user);
			$name_user=$row_current_user['FirstName'].' '.$row_current_user['LastName'];
			
			//send notification to current user
			//notification content
			$notification_content='You have no longer a member of group named '.$_POST['ExitGroup'];
			//$query_notify_user="insert into notifications  (EmailId, Notification_content, Type) values($_SESSION['user'],$notification_content,1 )";
			$query_notify_user="insert into notifications (EmailId, Notification_content, Type) values('ramyav@yahoo.com','$notification_content',1 )";
			if(!mysqli_query($conn, $query_notify_user)){
				echo("Notify user, Error description: " . mysqli_error($conn)."</br>");
				echo "notification to current user failed</br>";
			}
			else{
				//echo "notified current user</br>";
			}
			
			//notification content
			$notification_content=$name_user.' has is no longer a member of your group';
			//execute the member query
			$result_exit_member_info=mysqli_query($conn, $query_exit_member_info);
			//get members into array
			while($current_members_group=mysqli_fetch_array($result_exit_member_info))
			{
				$member_email=$current_members_group['EmailId'];
				$query_notify_member="insert into notifications (EmailId, Notification_content, Type) values('$member_email','$notification_content',1 )";
				if(!mysqli_query($conn, $query_notify_member)){
					echo("Notify member, Error description: " . mysqli_error($conn)."</br>");
					echo "notification to member failed</br>";
				}
				else{
					//echo "notified member ".$current_members_group['EmailId']."</br>";
				}
			}
			$output_exit_group="<div>You no longer are part of group named ".$_POST['ExitGroup'] ."</div>";
			
			
			
	
	echo $output_exit_group;
}	
if(isset($_POST['EditGroup'])){
	$output = array();
	$output['content'] = '';
	//connect to db
	include("connection.php");
	//get group info
	$querygroup="select * from user_group where GroupName='".$_POST['EditGroup']."'";
	//execute group query
	$resultgroup=mysqli_query($conn, $querygroup);
	//getvalues from that group
	$rowgroup=mysqli_fetch_array($resultgroup);
	//Display the results
	$output['content'].= '<form method="post" enctype="multipart/form-data" action="select.php"> 
				<div class="table-responsive">
				<table class="table table-bordered">';
				//Display group name
				$output['content'] .= '<tr>
							<td><label>Group Name</label></td>
							<td><input type="text" name="groupname" value="'.$rowgroup["GroupName"].'"></td>
							</tr>';
				//Display budget of group
				$output['content'] .= '<tr>
							<td><label>Budget</label></td>
							<td><input type="text" name="budget" value="'.$rowgroup["Budget"].'"></td>
							</tr>';
				//Display apartment name of group
				$output['content'] .= '<tr>
							<td><label>Apartment Name</label></td>
							<td><input type="text" name="aptname" value="'.$rowgroup["ApartmentName"].'"></td>
							</tr>';
				//Display Max members of group
				$output['content'] .= '<tr>
							<td><label>Max Members</label></td>
							<td><input type="text" name="maxmembers" value="'.$rowgroup["MaxMembers"].'"></td>
							</tr>';
				$output['content'] .= '</table></div>';
				$output['content'] .= '<input type="submit" name="update" value="Update" class="btn btn-info update">';
				$output['content'] .= '</form>';
				echo json_encode($output);
				
				
				
}
//when update details is clicked
if(isset($_POST['update'])){
				include("connection.php");
				$groupname=$_POST['groupname'];
				$budget=$_POST['budget'];
				$aptname=$_POST['aptname'];
				
				//send message back to user
				$message='';
				
				//set max members to original max members initially
				//$get_max_members_original="select * from user_group where GroupName='".$_SESSION['groupname']."'";
				$get_max_members_original="select * from user_group where GroupName='working'";
				$result_maxmembers_original=mysqli_query($conn, $get_max_members_original);
				$row_maxmembers_original=mysqli_fetch_array($result_maxmembers_original);
				$maxmembers=$row_maxmembers_original['MaxMembers'];
				
				//check if updated value is not equal to already present value i.e. no update has been made to groupname
				if($_POST['groupname']!='working')
				{
					//check if groupname already exists, throw error if it does
					$check_groupname_query="select * from user_group where GroupName='".$_POST['groupname']."'";
					if(mysqli_query($conn, $check_groupname_query)){
						if(mysqli_affected_rows($conn)>0){
						  header("Location: joingroupv1.php?message=Update failed, try a different group name"); 
						  exit;
						}
					}
				}
				
				//get count of existing members
				//$q_member="select * from user where user_groupname='".$_SESSION['groupname']."'";
				$q_member="select * from user where user_groupname='working'";
				mysqli_query($conn, $q_member);
				$getcount_members=mysqli_affected_rows($conn);
				//if curr count > updated max members, send error msg, do not change max members column
				//$message.="maxmember ".$getcount_members;
				if($getcount_members>$_POST['maxmembers']){
					$message.='Cannot update maxmembers, existing member count exceeds updated value. ';						
				}
				else{
					$maxmembers=$_POST['maxmembers'];
				}
				


				//update existing members user_groupname
				//$update_curr_members="update user set user_groupname='".$_POST['groupname']."' where user_groupname='".$_SESSION['groupname']."'";
				$update_curr_members="update user set user_groupname='".$_POST['groupname']."' where user_groupname='working'";
				if(mysqli_query($conn, $update_curr_members))
				{

					//set session var
					$_SESSION['groupname']=$groupname;
					
					//update user_group table with posted values
					$query_update="update user_group set GroupName='".$groupname."', Budget='".$budget."', ApartmentName='".$aptname."', MaxMembers='".$maxmembers."' where GroupName='working'";
					if(!mysqli_query($conn, $query_update)){
						  //trying to send error msg to user
						  header("Location: joingroupv1.php?message=Update failed, try a different group name"); 
						  exit;
					}
					else
					{
						//echo "update successful";
						//send notifications (EmailId, Notification_content, Type) to current user
						//$curr_user=$_SESSION['emailid'];
						$curr_user='kanna@yahoo.com';
						//$curr_user_name=$_SESSION['user'];
						$curr_user_name='Vishnu';
						$notification_content='You have updated your group details';
						$notify_curr_user="insert into notifications (EmailId, Notification_content, Type) values('$curr_user','$notification_content', 1)";
						if(!mysqli_query($conn, $notify_curr_user))
						{
							$message.="notification to curr user failed   ";
							$message.=mysqli_error($conn);
							
						}
						//send notification to all group members
						$group_members_query="select * from user where user_groupname='".$groupname."' and EmailId !='".$curr_user."'";
						/*if(!mysqli_query($conn, $group_members_query))
						{
							$message.="MEmber query not exe";
						}
						else{
							$message.="MEmber query exe";
						}*/
						$result_group_members_query=mysqli_query($conn, $group_members_query);
						/*if(mysqli_affected_rows($conn)==0){
							$message.='no members existing';
						}
						else{
							$message.="MEmbers existing";
						}*/
						$notification_content=$curr_user_name.' has updated group details';
						//$message=$notification_content." notify member messgae ";
						while($row_group_members=mysqli_fetch_array($result_group_members_query)){
							$emailid=$row_group_members['EmailId'];
							//$message.=$emailid." group member ";
							$query_notify_group_members="insert into notifications (EmailId, Notification_content, Type) values('$emailid', '$notification_content',1)";
							if(!mysqli_query($conn, $query_notify_group_members)){
								$message.="   notification to group member failed";
								$message.=mysqli_error($conn);
							}
							else{
								//$message.=" member notified ";
							}
						}
						
						$message.='Group information updated. ';
						header("Location: joingroupv1.php?message=$message"); 
						exit;
						
					}
				}

				
					
}
//to fetch profile details based on selection-potential roommates
if(isset($_POST['EmailId'])){
	$output = '';
	//connect to db
	include("connection.php");
	
	//get profile info for Name, Gender, Group, Smoking, Drinking, FoodHabits, Budget, NoOfRoommates, EmailId and Phone number
	$query="select * from user where EmailId='". $_POST['EmailId']. "'";
	//execute the user query
	$result=mysqli_query($conn, $query);
	//fetch user data
	$row=mysqli_fetch_array($result);


	//get profile major info-1 major
	$querymajor="select * from major where EmailId='".$_POST['EmailId']."' and Type=1";
	//execute profile major query
	$resultmajor=mysqli_query($conn, $querymajor);
	//fetch major value
	$rowmajor=mysqli_fetch_array($resultmajor);
	
	//get profile native info-1 native
	$querynative="select * from native where EmailId='".$_POST['EmailId']."' and Type=1";
	//execute profile native query
	$resultnative=mysqli_query($conn, $querynative);
	//fetch native value
	$rownative=mysqli_fetch_array($resultnative);
	
	//get profile language info-more than 1 language known
	$querylanguage="select * from languagesknown where EmailId='".$_POST['EmailId']."' and Type=1";
	//execute profile language query
	$resultlanguage=mysqli_query($conn, $querylanguage);
	//fetch inside while since more than 1
	
	
	//Display the results
	  $output.= '<ul class="nav nav-tabs">
					<li class="active"><a data-toggle="tab" href="#basic">Basic Information</a></li>
					<li><a data-toggle="tab" href="#additional">Additional Details</a></li>
					<li><a data-toggle="tab" href="#contact">Contact Information</a></li>
				  </ul>

				  <div class="tab-content">
				  
					<div id="basic" class="tab-pane fade in active">
					  <div class="table-responsive">
						<table class="table table-bordered">
							<tr>
							<td><label>Name</label></td>
							<td>'.$row["FirstName"].' '.$row["LastName"].'</td>
							</tr>
							<tr>
							<td><label>Gender</label></td>
							<td>'.$row["Gender"].'</td>
							</tr>
							<tr>
							<td><label>Major</label></td>
							<td>'.$rowmajor["Major"].'</td>
							</tr>
							<tr>
							<td><label>Native</label></td>
							<td>'.$rownative["Native"].'</td>
							</tr>
							<tr>
							<td><label>Group</label></td>
							<td>'.$row["user_groupname"].'</td>
							</tr>
						</table>
					  </div>
					</div>
					
					<div id="additional" class="tab-pane fade">
					  <div class="table-responsive">
						<table class="table table-bordered">
							<tr>
							<td><label>Smoking</label></td>
							<td>'.$row["SmokingSelf"].'</td>
							</tr>
							<tr>
							<td><label>Drinking</label></td>
							<td>'.$row["DrinkingSelf"].'</td>
							</tr>
							<tr>
							<td><label>Food Preferences</label></td>
							<td>'.$row["FoodHabitsSelf"].'</td>
							</tr>
							<tr>
							<td><label>Budget</label></td>
							<td>'.$row["Budget"].'</td>
							</tr>
							<tr>
							<td><label>No of roommates</label></td>
							<td>'.$row["NoOfRoommates"].'</td>
							</tr>
							<tr>
							<td><label>Languages Known</label></td>
							<td>';
							while($rowlanguage=mysqli_fetch_array($resultlanguage))
								{
									$output .= $rowlanguage['LanguagesKnown'].'</br>';
								}				
							
			$output.= '</td>
					  </tr>
					  </table>
					  </div>
					</div>
					
					<div id="contact" class="tab-pane fade">
					  <div class="table-responsive">
						<table class="table table-bordered">
							<tr>
							<td><label>Email</label></td>
							<td>'.$row["EmailId"].'</td>
							</tr>
							<tr>
							<td><label>Phone</label></td>
							<td>'.$row["ContactNumber"].'</td>
							</tr>
						</table>
					  </div>
					</div>
				  </div>';
				echo $output;
				//display popover by accepting emailid as input, makes ajax request to fetch.php to get user data
	
}
//edit basic info of my profile page
if(isset($_POST['EditBasic'])){
	$output = array();
	$output['content'] = '';
	//connect to db
	include("connection.php");
	//get user info
	$query="select * from user where EmailId='".$_POST['EditBasic']."'";
	//execute user query
	$result=mysqli_query($conn, $query);
	//getvalues from that user
	$row=mysqli_fetch_array($result);
	
	//get user major info
	//$sql_user_major="select * from major where EmailId='".$_SESSION["emailId"]."' and Type=1";
	$sql_user_major="select * from major where EmailId='vishram@gmail.com' and Type=1";
	$result_user_major=mysqli_query($conn, $sql_user_major);
	$row_user_major=mysqli_fetch_array($result_user_major);
	
	//Display the results
	$output['content'].= '<form method="post" enctype="multipart/form-data" action="select.php"> 
				<div class="table-responsive">
				<table class="table table-bordered">';
				//Display user firstname
				$output['content'] .= '<tr>
							<td><label>First Name</label></td>
							<td><input type="text" name="firstname" value="'.$row["FirstName"].'"></td>
							</tr>';
				//Display user lastname
				$output['content'] .= '<tr>
							<td><label>Last Name</label></td>
							<td><input type="text" name="lastname" value="'.$row["LastName"].'"></td>
							</tr>';
				//Display Gender 
				$output['content'] .= '<tr>
							<td><label>Gender</label></td>
							<td>';
							//Get gender from user
							$gender=$row["Gender"];
							$sel_y=$sel_n=$sel_other='';
							switch($gender)
							{
								case 'male':
									$sel_y = 'CHECKED';
									break;
								case 'female':
									$sel_n = 'CHECKED';
									break;
								default:
									$sel_other= 'CHECKED';
									break;
							}
				$output['content'] .= '<input type="radio" name="gender" value="male" '.$sel_y.'/> Male ';
				$output['content'] .= '<input type="radio" name="gender" value="female" '.$sel_n.'/> Female ';
				$output['content'] .= '<input type="radio" name="gender" value="other" '.$sel_other.'/> Other ';
				$output['content'] .='</td></tr>';
				//Display contact number of user
				$output['content'] .= '<tr>
							<td><label>Contact Number</label></td>
							<td><input type="text" name="contactnum" value="'.$row["ContactNumber"].'"></td>
							</tr>';
				//Display major of user
				$output['content'] .= '<tr>
							<td><label>Major</label></td>
							<td><select  id="majorself" name="majorself">
								<option value="null"';
								if($row_user_major["Major"]=="null"){ 
				$output['content'] .= 'selected="selected"';
								}
				$output['content'] .='></option>
								<option value="Computer Science"';
								if($row_user_major["Major"]=="Computer Science"){ 
				$output['content'] .= 'selected="selected"';
								}
				$output['content'] .='>Computer Science</option>
								<option value="Computer Engineering"';
								if($row_user_major["Major"]=="Computer Engineering"){ 
				$output['content'] .= 'selected="selected"';
								}
				$output['content'] .='>Computer Engineering</option>
								<option value="Electrical Engineering"';
								if($row_user_major["Major"]=="Electrical Engineering"){ 
				$output['content'] .= 'selected="selected"';
								}
				$output['content'] .='>Electrical Engineering</option>
								<option value="Industrial Engineering"';
								if($row_user_major["Major"]=="Industrial Engineering"){ 
				$output['content'] .= 'selected="selected"';
								}
				$output['content'] .='>Industrial Engineering</option>
								<option value="Civil Engineering"';
								if($row_user_major["Major"]=="Civil Engineering"){ 
				$output['content'] .= 'selected="selected"';
								}
				$output['content'] .='>Civil Engineering</option>
								<option value="Structural Engineering"';
								if($row_user_major["Major"]=="Structural Engineering"){ 
				$output['content'] .= 'selected="selected"';
								}
				$output['content'] .='>Structural Engineering</option>
								<option value="Bio-Medical Engineering"';
								if($row_user_major["Major"]=="Bio-Medical Engineering"){ 
				$output['content'] .= 'selected="selected"';
								}
				$output['content'] .='>Bio-Medical Engineering</option>
								<option value="Mechanical Engineering"';
								if($row_user_major["Major"]=="Mechanical Engineering"){ 
				$output['content'] .= 'selected="selected"';
								}
				$output['content'] .='>Mechanical Engineering</option>

							</select>   </td>
							</tr>';
				$output['content'] .= '</table></div>';
				$output['content'] .= '<input type="submit" name="update_basic" value="Update" class="btn btn-info update_basic">';
				$output['content'] .= '</form>';				
			
				echo json_encode($output);	
				
}
//on click of update basic profile details
if(isset($_POST['update_basic'])){
	$message='';
	$fName=$_POST['firstname'];
	$lName=$_POST['lastname'];
	$gender=$_POST['gender'];
	$contactnum=$_POST['contactnum'];
	$major=$_POST['majorself'];
	
	//$quser="update user set FirstName='$fName', LastName='$lName', Gender='$gender', ContactNumber='$contactnum' where EmailId='".$_SESSION['emailId']."'";
	$quser="update user set FirstName='$fName', LastName='$lName', Gender='$gender', ContactNumber='$contactnum' where EmailId='vishram@gmail.com'";
	if(!mysqli_query($conn, $quser)){
		$message.= "could not update user table";
	}
	//$qusermajor="update major set Major='$major' where EmailId='".$_SESSION['emailId']."'";
	$qusermajor="update major set Major='$major' where EmailId='vishram@gmail.com'";
	if(!mysqli_query($conn, $qusermajor)){
		$message.="could not update major table";
	}	
	$message.='Basic information updated. ';
	header("Location: view_my_profile.php?message=$message"); 
	exit;
}

if(isset($_POST['EditAdditional'])){
	$output = array();
	$output['content'] = '';

	//get user info, smoking, drinking, foodhabits, budget, noofrommates
	$query="select * from user where EmailId='".$_POST['EditBasic']."'";
	//execute user query
	$result=mysqli_query($conn, $query);
	//getvalues from that user
	$row=mysqli_fetch_array($result);
	

	//get user native info, native
	//$sql_user_native="select * from native where EmailId='".$_SESSION["emailId"]."' and Type=1";
	$sql_user_native="select * from native where EmailId='vishram@gmail.com' and Type=1";
	$result_user_native=mysqli_query($conn, $sql_user_native);
	$row_user_native=mysqli_fetch_array($result_user_native);
		
	//get user language info, languagesknown
	//$sql_user_languages="select * from languagesknown where EmailId='".$_SESSION["emailId"]."' and Type=1";
	$sql_user_languages="select * from languagesknown where EmailId='vishram@gmail.com' and Type=1";
	$result_user_languages=mysqli_query($conn, $sql_user_languages);
	//multiple
	//while($row_user_languages=mysqli_fetch_array($result_user_languages))
	
	//Display the results
	$output['content'].= '<form method="post" enctype="multipart/form-data" action="select.php"> 
				<div class="table-responsive">
				<table class="table table-bordered">';
				//Display smoking
				$output['content'] .= '<tr>
							<td><label>Smoking</label></td>
							<td>							
								<select  id="smokingself" class="selectpicker" name="smokingself">
										<option value="null"';
										if($row["SmokingSelf"]=="null"){
				$output['content'] .= 'selected="selected"';							
										}
				$output['content'] .='	></option>
										<option value="Yes"';
										if($row["SmokingSelf"]=="Yes"){
				$output['content'] .= 'selected="selected"';							
										}
				$output['content'] .='	>Yes</option>
										<option value="No"';
										if($row["SmokingSelf"]=="No"){
				$output['content'] .= 'selected="selected"';							
										}
				$output['content'] .='	>No</option>
										<option value="Occasional"';
										if($row["SmokingSelf"]=="Occasional"){
				$output['content'] .= 'selected="selected"';							
										}
				$output['content'] .='	>Occasional</option>
								</select> 
							</td>
							</tr>';
				//Display drinking
				$output['content'] .= '<tr>
							<td><label>Drinking</label></td>
							<td>
							<select  id="drinkingself" class="selectpicker" name="drinkingself">
										<option value="null"';
										if($row["DrinkingSelf"]=="null"){
				$output['content'] .= 'selected="selected"';							
										}
				$output['content'] .='	></option>
										<option value="Yes"';
										if($row["DrinkingSelf"]=="Yes"){
				$output['content'] .= 'selected="selected"';							
										}
				$output['content'] .='	>Yes</option>
										<option value="No"';
										if($row["DrinkingSelf"]=="No"){
				$output['content'] .= 'selected="selected"';							
										}
				$output['content'] .='	>No</option>
										<option value="Occasional"';
										if($row["DrinkingSelf"]=="Occasional"){
				$output['content'] .= 'selected="selected"';							
										}
				$output['content'] .='	>Occasional</option>
								</select> 
							</td>
							</tr>';
				//Display FoodHabits 
				$output['content'] .= '<tr>
							<td><label>Food Habits</label></td>
							<td>
							<select  id="foodhabitsself" class="selectpicker" name="foodhabitsself">
										<option value="null"';
										if($row["FoodHabitsSelf"]=="null"){
				$output['content'] .= 'selected="selected"';							
										}
				$output['content'] .='	></option>
										<option value="Vegetarian"';
										if($row["FoodHabitsSelf"]=="Vegetarian"){
				$output['content'] .= 'selected="selected"';							
										}
				$output['content'] .='	>Vegetarian</option>
										<option value="Non-Vegetarian"';
										if($row["FoodHabitsSelf"]=="Non-Vegetarian"){
				$output['content'] .= 'selected="selected"';							
										}
				$output['content'] .='	>Non-Vegetarian</option>
										<option value="Eggetarian"';
										if($row["FoodHabitsSelf"]=="Eggetarian"){
				$output['content'] .= 'selected="selected"';							
										}
				$output['content'] .='	>Eggetarian</option>
							</select>
							</td>
							</tr>';
				//Display budget of user
				$output['content'] .= '<tr>
							<td><label>Budget</label></td>
							<td>
							<select  id="budgetself"  class="selectpicker" name="budgetself">
									<option value="null"';
										if($row["Budget"]=="null"){
				$output['content'] .= 'selected="selected"';							
										}
				$output['content'] .='></option>
									<option value="less than 200"';
										if($row["Budget"]=="less than 200"){
				$output['content'] .= 'selected="selected"';							
										}
				$output['content'] .='>less than 200</option>
									<option value="200-250"
									';
										if($row["Budget"]=="200-250"){
				$output['content'] .= 'selected="selected"';							
										}
				$output['content'] .='>200-250</option>
									<option value="250-300"';
										if($row["Budget"]=="250-300"){
				$output['content'] .= 'selected="selected"';							
										}
				$output['content'] .='>250-300</option>
									<option value="greater than 300"';
										if($row["Budget"]=="greater than 300"){
				$output['content'] .= 'selected="selected"';							
										}
				$output['content'] .='>greater than 300</option>
							</select> 
							</td>
							</tr>';
				//Display noofrommates of user
				$output['content'] .= '<tr>
							<td><label>No of roommates</label></td>
							<td><select  id="roommatesself" class="selectpicker" name="roommatesself">
									<option value="null"';
										if($row["NoOfRoommates"]=="null"){
				$output['content'] .= 'selected="selected"';							
										}
				$output['content'] .='></option>
									<option value="less than 2"';
										if($row["NoOfRoommates"]=="less than 2"){
				$output['content'] .= 'selected="selected"';							
										}
				$output['content'] .='>less than 2</option>
									<option value="2-3"';
										if($row["NoOfRoommates"]=="2-3"){
				$output['content'] .= 'selected="selected"';							
										}
				$output['content'] .='>2-3</option>
									<option value="4-5"';
										if($row["NoOfRoommates"]=="4-5"){
				$output['content'] .= 'selected="selected"';							
										}
				$output['content'] .='>4-5</option>
									<option value="more than 5"';
										if($row["NoOfRoommates"]=="more than 5"){
				$output['content'] .= 'selected="selected"';							
										}
				$output['content'] .='>more than 5</option>
							</select></td>
							</tr>';
				//Display native of user
				$output['content'] .= '<tr>
							<td><label>Native</label></td>
							<td>							<select  id="nativeself" class="selectpicker" name="nativeself">
								<option value="null"></option>
								<option value="Hyderabad">Hyderabad</option>
								<option value="Chennai">Chennai</option>
								<option value="Bangalore">Bangalore</option>
								<option value="Coimbatore">Coimbatore</option>
								<option value="Cochin">Cochin</option>
								<option value="Kolkata">Kolkata</option>
								<option value="Ahmedabad">Ahmedabad</option>
								<option value="Delhi">Delhi</option>
								<option value="Noida">Noida</option>
								<option value="Chandigarh">Chandigarh</option>
							</select></td>
							</tr>';
				$output['content'] .= '</table></div>';
				$output['content'] .= '<input type="submit" name="update_basic" value="Update" class="btn btn-info update_basic">';
				$output['content'] .= '</form>';
				
			
				echo json_encode($output);	
				
}
//on click of update basic profile details
if(isset($_POST['update_basic'])){
	$message='';
	$fName=$_POST['firstname'];
	$lName=$_POST['lastname'];
	$gender=$_POST['gender'];
	$contactnum=$_POST['contactnum'];
	$major=$_POST['majorself'];
	
	//$quser="update user set FirstName='$fName', LastName='$lName', Gender='$gender', ContactNumber='$contactnum' where EmailId='".$_SESSION['emailId']."'";
	$quser="update user set FirstName='$fName', LastName='$lName', Gender='$gender', ContactNumber='$contactnum' where EmailId='vishram@gmail.com'";
	if(!mysqli_query($conn, $quser)){
		$message.= "could not update user table";
	}
	//$qusermajor="update major set Major='$major' where EmailId='".$_SESSION['emailId']."'";
	$qusermajor="update major set Major='$major' where EmailId='vishram@gmail.com'";
	if(!mysqli_query($conn, $qusermajor)){
		$message.="could not update major table";
	}	
	$message.='Basic information updated. ';
	header("Location: view_my_profile.php?message=$message"); 
	exit;
}

?>