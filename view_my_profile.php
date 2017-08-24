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
					<div class="tab-pane active" id="my_details" >
						<table class="table">
							<thead>
							  <tr>
								<th>Basic Information</th>
							   <th style="text-align:right"><button type="button"  class="btn btn-info btn-sm edit_basic" >Edit</button></th>
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
						<table class="table" id="additional">
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
					<div class="tab-pane" id="my_group" >
						<div id="mygroup_details"></div>
					</div>
					<!--Data modal to update changes-->
					<div id="dataModal" class="modal modal-lg fade">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal">&times;</button>
									<b><h4 id="modal-header" style="float:left;"></h4></b>
								</div>
								<div class="modal-body" id="modal_details">
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
								</div>
							</div>
						</div> 	
					</div>
					<?php
					if(isset($_GET['message'])){
						$message = $_GET['message'];
						echo '<div class="alert alert-danger alert-dismissible">'.$message.'<button type="button" class="close" data-dismiss="alert" aria-label="close"><span aria-hidden="true">&times;</span></button></div>';
					}
					?>
				</div>
			</div>
		</div>
		<!--JS and AJAX to edit basic details-->
		<script>
			$(document).ready(function(){
				$('.edit_basic').click(function(){
					//var email=$_SESSION["emailId"];
					var email= "vishram@gmail.com";
					$.ajax({
						url:"select.php",
						method: "post",
						data:{EditBasic: email},
						success: function(data){
							var data = $.parseJSON(data);
							$('#modal_details').html(data.content);
							$('#modal-header').html('Basic Information');
							$('#dataModal').modal("show");
						}
					});	
					$('#dataModal').modal("show");
				});
			});
		</script>
		<!--JS and AJAX to edit additional details-->
		<script>
			$(document).ready(function(){
				$('.edit_additional').click(function(){
					//var email=$_SESSION["emailId"];
					var email= "vishram@gmail.com";
					$.ajax({
						url:"select.php",
						method: "post",
						data:{EditAdditional: email},
						success: function(data){
							var data = $.parseJSON(data);
							$('#modal_details').html(data.content);
							$('#modal-header').html('Additional Information');
							$('#dataModal').modal("show");
						}
					});	
					$('#dataModal').modal("show");
				});
			});
		</script>
		<!--JS and AJAX to view my group details-->
		<script>
			$(document).ready(function(){
				$('.view_my_group').click(function(){
					//var my_group_name=$_SESSION["groupname"];
					var group= "working";
					$.ajax({
						url:"select.php",
						method: "post",
						data:{MyGroup: group},
						success: function(data){
							$('#mygroup_details').html(data);	
						}
					});	
				});
			});
		</script>
	</body>
</html>
