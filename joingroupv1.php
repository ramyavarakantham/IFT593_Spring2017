<html>
	<head>
			<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
			<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css">
			<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-social.css">	
			<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
			<!-- Latest compiled JavaScript -->
			<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
			<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
			<script src="http://netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
	</head>
	<body>
		<?php
		//connects to db
		include("connection.php");
		//selects all groups from user_group
		$query_group="select * from user_group";
		$result_group=mysqli_query($conn, $query_group);
		while($row_group=mysqli_fetch_array($result_group))
		{
		?>
		</br></br>
		GroupName : <?php echo $row_group['GroupName'];?></br>
		Budget : <?php echo $row_group['Budget'];?></br>
		<?php
		//select members belonging to that group
		$query_user="select * from user where user_groupname='".$row_group['GroupName']."'";
		$result_user=mysqli_query($conn, $query_user);
		$currentcount=mysqli_affected_rows($conn);
		$vacancies=$row_group['MaxMembers']-$currentcount;
		?>
		Vacancies : <?php echo $vacancies;  ?></br>
		
		<!-- buttons to join group from suggested groups-->
		<button type="button" name="view" id="<?php echo $row_group['GroupName'];?>" class="btn btn-info view_data">View Details</button>
		<button type="button" id="join-<?php echo $row_group['GroupName'];?>" class="btn btn-primary join_group">Join group</button>
		<?php
		}
		?>
		</br></br>
		<!--Buttons for my group information-->
		<!--display error msg to user from select.php page-->
		<?php
		if(isset($_GET['message'])){
			$message = $_GET['message'];
			echo '<div class="alert alert-danger alert-dismissible">'.$message.'<button type="button" class="close" data-dismiss="alert" aria-label="close"><span aria-hidden="true">&times;</span></button></div>';
		}
		?>
		
		<!-- button to view group details and exit from the group-->
		<!--<button type="button" name="view_mygroup" id="<?php //echo $_SESSION['groupname'];?>" class="btn btn-info view_data">View Details</button>-->
		<button type="button" name="view_mygroup" id="view_my_group" class="btn btn-info view_my_group">View My Group Details</button>
		<!--<button type="button" name="view_exit" id="<?php //echo $_SESSION['groupname'];?>_exit" class="btn btn-info view_data">Exit Group</button>-->
		<button type="button" name="view_exit" id="view_exit_group" class="btn btn-info view_exit_group">Exit Group</button>
		</br></br>
		
		<!-- button to go to notifications page-->
		<button type="button" name="view_notifications" id="view_notifications" class="btn btn-info view_notifications" >view notifications
		<span class="label label-danger"><?php 
		
		$get_unread_notifications="select * from notifications where type=1 and EmailId='kanna@yahoo.com'";
		mysqli_query($conn, $get_unread_notifications);
		echo mysqli_affected_rows($conn);
		?></span></button>
		
		<br/><br/>
		<!-- button to go to search page, search roommates, groups-->
		<button type="button" name="search_profiles" id="search_profiles" class="btn btn-info search_profiles">Search roommates</button>
		<button type="button" name="search_groups" id="search_groups" class="btn btn-info search_groups">Search groups</button>
		
		
		</br></br>
		<!--Display all users-profile cards-->
		<?php
		//select all from users
		$query_users="select * from user";
		$result_users=mysqli_query($conn, $query_users);
		while($row_users=mysqli_fetch_array($result_users))
		{
		?>
			Name:<?php echo $row_users['FirstName'];?></br>
			Major:<?php 
				$query_major="select * from major where EmailId='".$row_users['EmailId']."' and Type=1";
				$result_major=mysqli_query($conn, $query_major);
				$row_major=mysqli_fetch_array($result_major);
				if($row_major['Major']=='null'){
					echo 'None selected';
				}
				else{
					echo $row_major['Major'];
				}
			?></br>
			Gender:<?php echo $row_users['Gender'];?></br>
			Native:<?php 
				$query_native="select * from native where EmailId='".$row_users['EmailId']."' and Type=1";
				$result_native=mysqli_query($conn, $query_native);
				$row_native=mysqli_fetch_array($result_native);
				if($row_native['Native']=='null'){
					echo 'None selected';
				}
				else{
					echo $row_native['Native'];
				}
			?>
			</br>
			<button type="button" name="view_profile" id="<?php echo $row_users['EmailId'];?>" class="btn btn-info view_profile">View Profile Details</button>
			</br></br>
		<?php
		}
		?>
		
		
		
		
		<!--Modal for view details button of suggested groups & suggested profiles-->
		<div id="dataModal" class="modal modal-lg fade">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 id="member_header"></h4>
					</div>
					<div class="modal-body" id="member_details">
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					</div>
				</div>
			</div> 	
		</div>
		
		<!--alert to display when you have joined a group-->
		<div class="alert alert-success alert-dismissable" id="joinedgroupalert" style="display:none;">
			<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
			<div id="alertmessage"></div>
		</div>
		
		<!--Modal for view my group details button-->
		<div id="dataModal_mygroup" class="modal modal-lg fade">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4>  My Group details<button type="button" class="btn btn-info edit_group" style="float:right;">
							  <span class="glyphicon glyphicon-pencil"></span> Edit
						</button> </h4>
					</div>
					<div class="modal-body" id="mygroup_details">
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					</div>
				</div>
			</div> 	
		</div>

	
		<!--JS to go to search profiles page on click of search roommates button-->
		<script>
			var btn = document.getElementById('search_profiles');
			btn.addEventListener('click', function() {
			  document.location.href = 'search_profiles.php';
			});
		</script>
		
		<!--JS to go to search groups page on click of search groups button-->
		<script>
			var btn = document.getElementById('search_groups');
			btn.addEventListener('click', function() {
			  document.location.href = 'search_groups.php';
			});
		</script>
		
		<!--JS and AJAX to edit my group details-->
		<script>
			$(document).ready(function(){
				$('.edit_group').click(function(){
					//var my_group_name=$_SESSION["groupname"];
					var group= "working";
					$.ajax({
						url:"select.php",
						method: "post",
						data:{EditGroup: group},
						success: function(data){
							var data = $.parseJSON(data);
							$('#mygroup_details').html(data.content);
							$('.edit_group').css('display', 'none');
							$('#dataModal_mygroup').modal("show");
						}
					});	
					$('#dataModal_mygroup').modal("show");
				});
			});
		</script>
		
		<!--alert to display when you join a group-->
		<div class="alert alert-success alert-dismissable" id="joinedgroupalert" style="display:none;">
			<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
			<div id="alertmessage"></div>
		</div>
		
		<!--alert to display when you exit a group-->
		<div class="alert alert-success alert-dismissable" id="exitgroupalert" style="display:none;">
			<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
			<div id="alertmessage_exitgroup"></div>
		</div>
		
		<!--JS and AJAX to load data into group details modal based on selection-->
		<script>
			$(document).ready(function(){
				$('.view_data').click(function(){
					var group_name=$(this).attr("id");
					var header="Group Details";
					$.ajax({
						url:"select.php",
						method: "post",
						data:{GroupName: group_name},
						success: function(data){
							$('#member_details').html(data);
							$('#member_header').html(header);
							$('#dataModal').modal("show");
						}
					});
					$('#dataModal').modal("show");
				});
			});
		</script>

		<!--JS and AJAX to join group based on selection-->
		<script>
			$(document).ready(function(){
				$('.join_group').click(function(){
					var join_group_name=$(this).attr("id");
					var group= join_group_name.substring(5);
					$.ajax({
						url:"select.php",
						method: "post",
						data:{JoinGroup: group},
						success: function(data){
							$('#alertmessage').html(data);	
						}
					});	
					$("#joinedgroupalert").css("display", "");
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
							$('#dataModal_mygroup').modal("show");
						}
					});	
					$('#dataModal_mygroup').modal("show");
				});
			});
		</script>
		
		<!--JS and AJAX to exit my group-->
		<script>
			$(document).ready(function(){
				$('.view_exit_group').click(function(){
					//var my_group_name=$_SESSION["groupname"];
					var group= "working";
					$.ajax({
						url:"select.php",
						method: "post",
						data:{ExitGroup: group},
						success: function(data){
							$('#alertmessage_exitgroup').html(data);	
						}
					});	
					$("#exitgroupalert").css("display", "");
					$("#view_my_group").css("display", "none");
					$("#view_exit_group").css("display", "none");
				});
			});
		</script>
		
		
		<!--JS to go to notifications page on click of view notifications button-->
		<script>
			var btn = document.getElementById('view_notifications');
			btn.addEventListener('click', function() {
			  document.location.href = 'notifications.php';
			});

		</script>
		
		<!--JS and AJAX to load data into profile details modal based on selection-->
		<script>
			$(document).ready(function(){
				$('.view_profile').click(function(){
					var email_id=$(this).attr("id");
					var header="Profile Details";
					$.ajax({
						url:"select.php",
						method: "post",
						data:{EmailId: email_id},
						success: function(data){
							$('#member_details').html(data);
							$('#member_header').html(header);
							$('#dataModal').modal("show");
						}
					});
					$('#dataModal').modal("show");
				});
			});
		</script>
		

	</body>
</html>