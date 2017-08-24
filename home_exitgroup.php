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
		$query="select * from user where EmailId='vishram@gmail.com'";
		$result=mysqli_query($conn, $query);
		$row=mysqli_fetch_array($result);
		if(isset($_POST['Update'])){
			$fName=$_POST['fName'];
			$lName=$_POST['lName'];
			//$query_update="update user set FirstName='".$fName."' and LastName='".$lName."' where EmailId='".$_SESSION['user']."'";
			$query_update="update user set FirstName='".$fName."', LastName='".$lName."' where EmailId='vishram@gmail.com'";
			if(!mysqli_query($conn, $query_update)){
				echo "user update failed";
				echo mysqli_error($conn);
			}
			else
				echo "update successful";
		}
	?>
	<body>
		<form method="post" enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>"> 
			FirstName: <input type="text" name="fName" value="<?php echo $row['FirstName'];?>"><br />
			LastName: <input type="text" name="lName" value="<?php echo $row['LastName'];?>"><br />
			<input type="submit" value="Update" name="Update">
		</form>
	</body>

</html>