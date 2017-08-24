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
	<?php
		include("connection.php");
		SESSION_START();
	?>
	<body>
		
			<div class="container">       
			  <table class="table">
				<thead>
				  <tr>
					<th>Unread<div style="float:right;"><span class="text-info">* latest first</span></div></th>
				  </tr>
				</thead>
				<tbody>
					<?php 
						//unread notifications
						//$query="select * from notifications where EmailId='".$_SESSION['emailId']."' and Type=1";
						$query_unread="select * from notifications where EmailId='kanna@yahoo.com' and Type=1";
						$result_unread=mysqli_query($conn, $query_unread);
						if(mysqli_affected_rows($conn)==0){
							?>
							<tr><td><?php echo "You have no unread notifications";?></td></tr>
						<?php 
						}else
						{
							while($row_unread=mysqli_fetch_array($result_unread)){
								?>
							<tr><td><?php echo $row_unread['Notification_content'];?></td></tr>
							<?php
							}
						}
					?>			  
				</tbody>
			  </table>
			  
			  </br></br>
			  
			  <table class="table">
				<thead>
				  <tr>
					<th>Read<div style="float:right;"><span class="text-info">* latest first</span></div></th>
				  </tr>
				</thead>
				<tbody>
					<?php 
						//read notifications
						//$query="select * from notifications where EmailId='".$_SESSION['emailId']."' and Type=0";
						$query_read="select * from notifications where EmailId='kanna@yahoo.com' and Type=0";
						$result_read=mysqli_query($conn, $query_read);
						if(mysqli_affected_rows($conn)==0){
							?>
							<tr><td><?php echo " ";?></td></tr>
						<?php 
						}else
						{
							while($row_read=mysqli_fetch_array($result_read)){
								?>
							<tr><td><?php echo $row_read['Notification_content'];?></td></tr>
							<?php
							}
						}
						
						//change unread to read
						//$query_change="update notifications set type=0 where type=1 and EmailId='".$_SESSION['emailId']."'";
						$query_change="update notifications set type=0 where type=1 and EmailId='kanna@yahoo.com'";
						if(!mysqli_query($conn, $query_change)){
							echo "update change failed";
							echo mysqli_error($conn);
						}
						else{
							//echo "update made to notifications";
						}
					?>			  
				</tbody>
			  </table>
			  
			</div>
				
		
	</body>

</html>