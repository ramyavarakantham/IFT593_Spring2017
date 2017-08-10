<?php
	include("connection.php");
	$emailErr = $pwderr = $fNameErr = $lNameErr = $genderErr  = $budgetErr  = $roommateErr  ="";
	
	if(empty($_POST['email']))
	{
		$emailErr = "Invalid email format";
		die(header("location:RS_Signup_Page.php?loginFailed=true&reason=password"));
	}
	else{
		if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                  $emailErr = "Invalid email format"; 
               }
		else{
			$email=$_POST['email'];
		}
	}
	
	if(empty($_POST['password']))
	{
		$pwderr = "Password is required";
	}
	else{
		$pwd=$_POST['password'];
	}
	
	if(empty($_POST['firstname']))
	{
		$fNameErr = "Firstname is required";
	}
	else{
		$fName=$_POST['firstname'];
	}
	
	if(empty($_POST['lastname']))
	{
		$lNameErr = "Lastname is required";
	}
	else{
		$lName=$_POST['lastname'];
	}
	
	if(empty($_POST['gender']))
	{
		$genderErr = "Gender is required";
	}
	else{
		$gender=$_POST['gender'];
	}
	
	if(empty($_POST['budgetself']))
	{
		$budgetErr = "Budget is required";
	}
	else{
		$budgetself=$_POST['budgetself'];
	}
	
	if(empty($_POST['roommatesself']))
	{
		$roommateErr = "NoOfRoommates is required";
	}
	else{
		$roommatesself=$_POST['roommatesself'];
	}
	
	
	$smokingself=$_POST['smokingself'];
	$drinkingself=$_POST['drinkingself'];
	$foodhabitsself=$_POST['foodhabitsself'];
	$smokingpreferences=$_POST['smokingpreferences'];
	$drinkingpreferences=$_POST['drinkingpreferences'];
	$foodhabitspreferences=$_POST['foodhabitspreferences'];
	$contactnum=$_POST['contactnum'];
	
	$majorself=$_POST['majorself'];
	$sqlmajorself="insert into major (emailid, major, type) values('$email','$majorself','1')";
	if(!mysqli_query($conn,$sqlmajorself)){
		echo "insertion failed";
	}
	else {
		echo "inserted into major type 1";
	}
	if(isset($_POST['majorpreferences'])&&is_array($_POST['majorpreferences'])){
	
		foreach ($_POST['majorpreferences'] as $value)
		{
			$sqlmajorpref="insert into major (emailid, major, type) values('$email','$value','2')";
			if(!mysqli_query($conn,$sqlmajorpref)){
				echo "insertion failed";
			}
			else {
				echo "inserted into major type 2";
			}
		}
	}
	
	$nativeself=$_POST['nativeself'];
	$sqlnativeself="insert into native (emailid, native, type) values('$email','$nativeself','1')";
	if(!mysqli_query($conn,$sqlnativeself)){
		echo "insertion failed";
	}
	else {
		echo "inserted into native type 1";
	}
	if(isset($_POST['nativepreferences'])&&is_array($_POST['nativepreferences'])){
	
		foreach ($_POST['nativepreferences'] as $value)
		{
			$sqlnativepref="insert into native (emailid, native, type) values('$email','$value','2')";
			if(!mysqli_query($conn,$sqlnativepref)){
				echo "insertion failed";
			}
			else {
				echo "inserted into native type 2";
			}
		}
	}
	if(isset($_POST['languagesself'])&&is_array($_POST['languagesself'])){
	
		foreach ($_POST['languagesself'] as $value)
		{
			$sqllanguageself="insert into languagesknown (emailid, languagesknown, type) values('$email','$value','1')";
			if(!mysqli_query($conn,$sqllanguageself)){
				echo "insertion failed";
			}
			else {
				echo "inserted into languages type 1";
			}
		}
	}
	else{
		$sqllanguageself="insert into languagesknown (emailid, languagesknown, type) values('$email','null','1')";
			if(!mysqli_query($conn,$sqllanguageself)){
				echo "insertion failed";
			}
			else {
				echo "inserted into languages type 1";
			}
	}
	if(isset($_POST['languagespreferences'])&&is_array($_POST['languagespreferences'])){
	
		foreach ($_POST['languagespreferences'] as $value)
		{
			$sqllanguagepref="insert into languagesknown (emailid, languagesknown, type) values('$email','$value','2')";
			if(!mysqli_query($conn,$sqllanguagepref)){
				echo "insertion failed";
			}
			else {
				echo "inserted into languages type 2";
			}
		}
	}
	
	
	$sqluser="insert into user(emailid, password, firstname, lastname, gender, smokingself, drinkingself, foodhabitsself, budget, noofroommates, smokingpreferences, drinkingpreferences, foodhabitspreferences, contactnumber)
	values('$email', '$pwd', '$fName', '$lName','$gender', '$smokingself', '$drinkingself', '$foodhabitsself', '$budgetself', '$roommatesself', '$smokingpreferences', '$drinkingpreferences', '$foodhabitspreferences', '$contactnum')";
	if(!mysqli_query($conn,$sqluser)){
		echo("Error description: " . mysqli_error($conn));
	}
	else {
		echo "inserted into user";
	}

	header ("refresh:10; url=RS_Signup_Page.html");

?>