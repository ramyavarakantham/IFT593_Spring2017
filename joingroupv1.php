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
		<button type="button" name="view" id="<?php echo $row_group['GroupName'];?>" class="btn btn-info view_data">View Details</button>
		<button type="button" id="join-<?php echo $row_group['GroupName'];?>" class="btn btn-primary join_group">Join group</button>
		<?php
		}
		?>
		<div id="dataModal" class="modal modal-lg fade">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4>Group details</h4>
					</div>
					<div class="modal-body" id="member_details">
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					</div>
				</div>
			</div> 	
		</div>
		<div class="alert alert-success alert-dismissable" id="joinedgroupalert" style="display:none;">
			<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
			<div id="alertmessage"></div>
		</div>
		<script>
			$(document).ready(function(){
				$('.view_data').click(function(){
					var group_name=$(this).attr("id");
					$.ajax({
						url:"select.php",
						method: "post",
						data:{GroupName: group_name},
						success: function(data){
							$('#member_details').html(data);
							$('#dataModal').modal("show");
						}
					});
					$('#dataModal').modal("show");
				});
			});
		</script>	
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
	</body>
</html>