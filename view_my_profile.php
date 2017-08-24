<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<!-- The above 3 meta tags *must* come first in the head; any other head 
			 content must come *after* these tags -->
		<title>Ristorante Con Fusion: About Us</title>
		  <!-- Bootstrap -->
		  <!-- Latest compiled and minified CSS -->
			<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
			<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css">
			<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-social.css">
						
			<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

			<!-- Latest compiled JavaScript -->
			<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
			
			<!--Mobile first. Adapts itself to screen width-->
			<meta name="viewport" content="width=device-width, initial-scale=1">
			
			<!--font-awesome-->
			<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
			<!--remove backgroudn image
			<link href="Ramya_index_css.css" rel="stylesheet">
			-->
		<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
		  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->
	</head>
	<body>
		<?php
		
		include("connection.php");
		SESSION_START();
		
		//get user info
		//$sql_user="select * from user where EmailId='".$_SESSION["emailId"]."'";
		$sql_user="select * from user where EmailId='vishram@gmail.com'";
		$result_user=mysqli_query($conn, $sql_user);
		$row_user=mysqli_fetch_array($result_user);
		
		//get user major info
		//$sql_user_major="select * from major where EmailId='".$_SESSION["emailId"]."' and Type=1";
		$sql_user_major="select * from major where EmailId='vishram@gmail.com' and Type=1";
		$result_user_major=mysqli_query($conn, $sql_user_major);
		$row_user_major=mysqli_fetch_array($result_user_major);
		
		//get user major info-pref
		//$sql_user_major="select * from major where EmailId='".$_SESSION["emailId"]."' and Type=2";
		$sql_user_major_p="select * from major where EmailId='vishram@gmail.com' and Type=2";
		$result_user_major_p=mysqli_query($conn, $sql_user_major_p);
		//multiple
		//while($row_user_major_p=mysqli_fetch_array($result_user_major_p))
		
		//get user native info
		//$sql_user_native="select * from native where EmailId='".$_SESSION["emailId"]."' and Type=1";
		$sql_user_native="select * from native where EmailId='vishram@gmail.com' and Type=1";
		$result_user_native=mysqli_query($conn, $sql_user_native);
		$row_user_native=mysqli_fetch_array($result_user_native);
		
		//get user native info-pref
		//$sql_user_native="select * from native where EmailId='".$_SESSION["emailId"]."' and Type=2";
		$sql_user_native_p="select * from native where EmailId='vishram@gmail.com' and Type=2";
		$result_user_native_p=mysqli_query($conn, $sql_user_native_p);
		//multiple
		//while($row_user_native_p=mysqli_fetch_array($result_user_native_p))
			
		//get user language info
		//$sql_user_languages="select * from languagesknown where EmailId='".$_SESSION["emailId"]."' and Type=1";
		$sql_user_languages="select * from languagesknown where EmailId='vishram@gmail.com' and Type=1";
		$result_user_languages=mysqli_query($conn, $sql_user_languages);
		//multiple
		//while($row_user_languages=mysqli_fetch_array($result_user_languages))
			
		//get user languages info-pref
		//$sql_user_native="select * from languagesknown where EmailId='".$_SESSION["emailId"]."' and Type=2";
		$sql_user_languages_p="select * from languagesknown where EmailId='vishram@gmail.com' and Type=2";
		$result_user_languages_p=mysqli_query($conn, $sql_user_languages_p);
		//multiple
		//while($row_user_languages_p=mysqli_fetch_array($result_user_languages_p))
			
		//get all users belonging to that group
		//$query="select * from user where user_groupname='". $_POST['MyGroup']. "'";
		$query="select * from user where user_groupname='working'";
		//execute the member query
		$result=mysqli_query($conn, $query);
		$currentcount=mysqli_affected_rows($conn);
		//get group info
		//$querygroup="select * from user_group where GroupName='".$_POST['MyGroup']."'";
		$querygroup="select * from user_group where GroupName='working'";
		//execute group query
		$resultgroup=mysqli_query($conn, $querygroup);
		//getvalues from that group
		$rowgroup=mysqli_fetch_array($resultgroup);
		$vacancies=$rowgroup['MaxMembers']-$currentcount;
		?>
					<?php
			if(isset($_POST['update'])){
	$message='';
	$fName=$_POST['fname'];
	$lName=$_POST['lname'];
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

	if($message=='Basic information updated. '){
		header('Location: '.$_SERVER['REQUEST_URI']);
	}
	
	 
	
}
?>
		<div class="container" style="padding-top:80px;">
			<div class="row">
				<div class="col-sm-3">
					<ul class="nav nav-pills nav-stacked">
						<li class="active"><a href="#my_details" data-toggle="pill">My Details</a></li>
						<li><a href="#my_preferences" data-toggle="pill">My Preferences</a></li>
						<li><a href="#my_group" data-toggle="pill" class="view_my_group">My Group</a></li>
				  </ul>
				</div>
				<div class="tab-content col-sm-6 text-center">
				<span><?php 
				if(isset($message) && $message != ''){
					echo '<div class="alert alert-danger alert-dismissible">'.$message.'<button type="button" class="close close_alert" data-dismiss="alert" aria-label="close"><span aria-hidden="true">&times;</span></button></div>';
				}
				?> </span>
					<div class="tab-pane active" id="my_details" >
						<div id="basic_table">
							<table class="table">
								<thead>
								  <tr>
									<th>Basic Information</th>
								   <th style="text-align:right"><button type="button"  class="btn btn-info btn-sm edit_basic">Edit</button></th>
								  </tr>
								</thead>
								<tbody>
								  <tr>
									<td>First Name</td>
									<td><?php echo $row_user['FirstName']; ?></td>
								  </tr>
								  <tr>
									<td>Last Name</td>
									<td><?php echo $row_user['LastName']; ?></td>
								  </tr>
								  <tr>
									<td>Gender</td>
									<td><?php echo $row_user['Gender']; ?></td>
								  </tr>
								  <tr>
									<td>Password</td>
									<td><a href="updatepassword.php">Update Password</a></td>
								  </tr>
								  <tr>
									<td>Contact Number</td>
									<td><?php echo $row_user['ContactNumber']; ?></td>
								  </tr>
								  <tr>
									<td>Major</td>
									<td><?php echo $row_user_major['Major']; ?></td>
								  </tr>
								</tbody>
							</table>
						</div>
						<table class="table">
							<thead>
							  <tr>
								<th>Additional Information</th>
								<th style="text-align:right"><button type="button"  class="btn btn-info btn-sm edit_additional" >Edit</button></th>
							  </tr>
							</thead>
							<tbody>
							  <tr>
								<td>Smoking</td>
								<td><?php  echo $row_user['SmokingSelf'];?></td>
							  </tr>
							  <tr>
								<td>Drinking</td>
								<td><?php  echo $row_user['DrinkingSelf'];?></td>
							  </tr>
							  <tr>
								<td>Food Habits</td>
								<td><?php  echo $row_user['FoodHabitsSelf'];?></td>
							  </tr>
							  <tr>
								<td>Budget</td>
								<td><?php  echo $row_user['Budget'];?></td>
							  </tr>
							  <tr>
								<td>Native</td>
								<td><?php  echo $row_user_native['Native'];?></td>
							  </tr>
							  <tr>
								<td>Number of Roommates</td>
								<td><?php  echo $row_user['NoOfRoommates'];?></td>
							  </tr>
							  <tr>
								<td>Languages known</td>
								<td>
								<?php  
								while($row_user_languages=mysqli_fetch_array($result_user_languages)){
									echo $row_user_languages['LanguagesKnown']."</br>";
								}
								?></td>
							  </tr>
							</tbody>
						</table>
					</div>
					<div class="tab-pane" id="my_preferences" >
						<table class="table" id="preferences">
							<thead>
							  <tr>
								<th>My Preferences</th>
								<th style="text-align:right"><button type="button"  class="btn btn-info btn-sm" data-toggle="modal" data-target="#contactmod" >Edit</button></th>
							  </tr>
							</thead>
							<tbody>
							  <tr>
								<td>Smoking</td>
								<td><?php  echo $row_user['SmokingPreferences'];?></td>
							  </tr>
							  <tr>
								<td>Drinking</td>
								<td><?php  echo $row_user['DrinkingPreferences'];?></td>
							  </tr>
							  <tr>
								<td>Food Habits</td>
								<td><?php  echo $row_user['FoodHabitsPreferences'];?></td>
							  </tr>
							  <tr>
								<td>Major</td>
								<td><?php  
								while($row_user_major_p=mysqli_fetch_array($result_user_major_p)){
									echo $row_user_major_p['Major']."</br>";
								}
								?></td>
							  </tr>
							  <tr>
								<td>Native</td>
								<td><?php  
								while($row_user_native_p=mysqli_fetch_array($result_user_native_p)){
									echo $row_user_native['Native']."</br>";
								}
								?></td>
							  </tr>
							  <tr>
								<td>Languages known</td>
								<td>
								<?php  
								while($row_user_languages_p=mysqli_fetch_array($result_user_languages_p)){
									echo $row_user_languages_p['LanguagesKnown']."</br>";
								}
								?></td>
							  </tr>
							</tbody>
						</table>
						
					</div>
					<div class="tab-pane" id="my_group">
						<table class="table">
							<thead>
							  <tr>
								<th>My Group Details</th>
							   <th style="text-align:right"><button type="button"  class="btn btn-info btn-sm edit_basic">Edit</button></th>
							  </tr>
							</thead>
							<tbody>
							  <tr>
								<td>Group Name</td>
								<td><?php echo $rowgroup['GroupName']; ?></td>
							  </tr>
							  <tr>
								<td>Budget</td>
								<td><?php echo $rowgroup['Budget']; ?></td>
							  </tr>
							  <tr>
								<td>Apartment Name</td>
								<td><?php echo $rowgroup['ApartmentName']; ?></td>
							  </tr>
							  <tr>
								<td>Max Members</td>
								<td><?php echo $rowgroup['MaxMembers']; ?></td>
							  </tr>
							  <tr>
								<td>Vacancies</td>
								<td><?php echo $vacancies; ?></td>
							  </tr>
							  <tr>
								<td>Members</td>
								<td><?php while($row=mysqli_fetch_array($result)){
									echo '<a href=# class="hover" id="'. $row['EmailId'].'">'.$row["FirstName"].' '.$row["LastName"].'</a></br>';
								}
									?>
								</td>
							  </tr>
							</tbody>
						</table>
					</div>
					<!--Data modal to update changes-->
					<div id="basicdataModal" class="modal modal-lg fade">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal">&times;</button>
									<b><h4 id="modal-header" style="float:left;">Basic Information</h4></b>
								</div>
								<div class="modal-body" id="modal_details">
									<form method="post" id="basic_form_update" name="basic_form_update">
									<div class="row">
										<label class="col-sm-3">First Name</label>  
									    <div class="col-sm-6"> <input type="text" name="fname" id="fname" class="form-control" /> </div>
									</div>
									  <br /> 
									<div class="row">									  
									  <label class="col-sm-3">Last Name</label>  
									  <div class="col-sm-6"><input type="text" name="lname" id="lname" class="form-control" /> </div>  
									</div>
									  <br /> 
									<div class="row">
									  <label class="col-sm-3">Gender</label>  
									  <div class="col-sm-6"><select name="gender" id="gender" class="form-control">  
										   <option value="male">Male</option>  
										   <option value="female">Female</option> 
											<option value="other">Other</option>
									  </select> </div> 
									</div>
									  <br /> 
									<div class="row">
									  <label class="col-sm-3">Contact Number</label>  
									  <div class="col-sm-6"><input type="text" name="contactnum" id="contactnum" class="form-control" /> </div> 
									</div>
									  <br /> 
									<div class="row">
									  <label class="col-sm-3">Major</label>  
										<div class="col-sm-6"><select  id="majorself" class="form-control" name="majorself">
											<option value="null"></option>
											<option value="Computer Science">Computer Science</option>
											<option value="Computer Engineering">Computer Engineering</option>
											<option value="Electrical Engineering">Electrical Engineering</option>
											<option value="Industrial Engineering">Industrial Engineering</option>
											<option value="Civil Engineering">Civil Engineering</option>
											<option value="Chemical Engineering">Chemical Engineering</option>
											<option value="Structural Engineering">Structural Engineering</option>
											<option value="Bio-Medical Engineering">Bio-Medical Engineering</option>
											<option value="Mechanical Engineering">Mechanical Engineering</option>
										</select> </div>
									</div>
									  <br />  
									  <input type="hidden" name="employee_id" id="employee_id" />  
									  <input type="submit" name="update" id="update" value="Update" class="btn btn-primary update" />  
									</form>
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
								</div>
							</div>
						</div> 	
					</div>

				</div>
			</div>
		</div>
		<!--Popovers to show members of my group-->
		<script>
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
				</script>
			<script>
				$(document).on('click','.edit_basic' ,function(){
					//var edit_basic=$_SESSION['emailId'];
					var edit_basic='vishram@gmail.com';
					$.ajax({
						url:"fetch.php",
						method: "POST",
						data:{EditBasic:edit_basic},
						dataType:"json",
						success: function(data){
							 $('#fname').val(data.fname); 
							 $('#lname').val(data.lname); 
							 $('#gender').val(data.gender);  
							 $('#contactnum').val(data.contactnum);  
							 $('#majorself').val(data.majorself);    
							 $('#basicdataModal').modal('show');
						}
					});
					
				});
			</script>

	</body>
</html>
