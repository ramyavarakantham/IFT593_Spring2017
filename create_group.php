
<html>
<body>
	<?php
	include("connection.php");
	if(isset($_POST['submit'])&& isset($_POST['groupname'])&& isset($_POST['maxmembers'])){
		$err_duplicategroup="";
		echo "</br>here</br>";
		$aptname=$budget="";
		$groupname = $_POST['groupname'];
		if(isset($_POST['aptname']))
		{
			$aptname=$_POST['aptname'];
		}
		if(isset($_POST['budget']))
		{
			$budget=$_POST['budget'];
		}
		$maxmembers=$_POST['maxmembers'];
		$sql_usergroup = "insert into user_group values ('$groupname', '$aptname', '$budget', '$maxmembers', 0)";
		$result_usergroup = mysqli_query($conn, $sql_usergroup);
		if(mysqli_affected_rows($conn)==1)
		{
			echo "inserted into user_group</br>"; 
			$sql_user="update user set user_groupname='$groupname' where EmailId='abc@yahoo.cods'";
			$result_user = mysqli_query($conn, $sql_user);
			if(mysqli_affected_rows($conn)==1)
			{
				echo "updated user</br>";
				//$_SESSION["groupname"] = $groupname;
				$notification_content="You have created a group named " .$groupname. "</br>";
				echo $notification_content;
				$sql_notification="insert into notifications values ('abc@yahoo.cods', '$notification_content', 0)";
				$result_notification = mysqli_query($conn, $sql_notification);
				if(mysqli_affected_rows($conn)==1)
				{
					echo "notification sent to user";
				}
				else
				{
					echo("</br>Error description: " . mysqli_error($conn));
				}
			}
		}
		else{
			$err_duplicategroup="set";
		}
	}
	?>

	<form method="post" name="test" enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
	<span><?php echo ((isset($err_duplicategroup) && $err_duplicategroup != '') ? 'Duplicate group exists</br>': '');?></span>
	<!--uncomment below-->
	<!--<span><?php //echo ((isset($err_duplicategroup) && $err_duplicategroup != '') ? '<div class="alert alert-danger alert-dismissible">Uh oh!This group name is already taken, please use a different one.<button type="button" class="close" data-dismiss="alert" aria-label="close"><span aria-hidden="true">&times;</span></button></div>' : ''); ?> </span>-->
		GroupName: <input type="text" name="groupname" required><br>
		ApartmentName: <input type="text" name="aptname"><br>
		Budget: <select name="budget">
		  <option value="100">100</option>
		  <option value="200-250">200-250</option>
		   <option value="300">300</option>
		 </select>
		MaxMembers: <select name="maxmembers" required>
		  <option value="1">1</option>
		  <option value="2">2</option>
		   <option value="1">3</option>
		  <option value="2">4</option>
		 </select>
		<input type="submit" name="submit">
	</form>

</body>
</html>