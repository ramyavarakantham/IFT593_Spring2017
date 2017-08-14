<?php
if(isset($_POST["emailid"])){
	$output='';
	include("connection.php");
	//get data from user table-name, gender
	$query="select * from user where EmailId='".$_POST['emailid']."'";
	$result= mysqli_query($conn, $query);
	//get user major
	$querymajor="select * from major where EmailId='".$_POST['emailid']."' and Type=1";
	$resultmajor=mysqli_query($conn, $querymajor);
	$rowmajor=mysqli_fetch_array($resultmajor);
	//get user native
	$querynative="select * from native where EmailId='".$_POST['emailid']."' and Type=1";
	$resultnative=mysqli_query($conn, $querynative);
	$rownative=mysqli_fetch_array($resultnative);
	while($row=mysqli_fetch_array($result))
	{
		$output = '
					<p><label>Name: </label>'.$row["FirstName"].' '.$row["LastName"].'</p>
					<p><label>Gender: </label>'.$row["Gender"].'</p>
					<p><label>Major: </label>'.$rowmajor["Major"].'</p>
					<p><label>Native: </label>'.$rownative["Native"].'</p>
		
		';
	}
	echo $output;
	
}
?>