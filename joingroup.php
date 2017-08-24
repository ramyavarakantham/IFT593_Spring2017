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
include("connection.php");
$sql_usergroup = "SELECT * FROM user_group WHERE GroupName = 'working'";
$result_usergroup = mysqli_query($conn, $sql_usergroup);
$row=mysqli_fetch_array($result_usergroup);
//budget
//echo "</br>user_group data: budget " .$row['Budget'];
$budget=$row['Budget'];
$sql_user="select * from user where user_groupname='working'";
$result_user=mysqli_query($conn, $sql_user);
$membercount=mysqli_num_rows($result_user);
//echo $membercount;
//members
//echo "</br>members: ";

//vacancies
echo "vacancies: ";
$vacancies=$row['MaxMembers']-$membercount;
echo $vacancies;

echo "</br>apartment name: ";
echo $row['ApartmentName'];
?>

<form method="post" name="joingroup" enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
  Budget:<?php echo((isset($budget)) ?$budget:''); ?>
  Members:<?php while($row_user=mysqli_fetch_array($result_user)){
	 echo $row_user['FirstName'];?>
  <input type="button" name="view" id="<?php echo $row_user['EmailId'];?>" class="btn btn-info view_data" />"
  <?php 
  }
  ?>
	  
			

<div id="dataModal" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4>Employee details</h4>
			</div>
			<div class="modal-body" id="employee_detail">
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div> 	
</div>

<script>
$(document).ready(function(){
	$('.view_data').click(function(){
		var employee_id=$(this).attr("id");
		$.ajax({
			url:"select.php",
			method: "post",
			data:{EmailId: employee_id},
			success: function(data){
				$('#employee_detail').html(data);
				$('#dataModal').modal("show");
			}
		});
		$('#dataModal').modal("show");
	});
});
</script>


</body>
</html>
