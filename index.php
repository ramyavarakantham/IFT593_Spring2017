<?php
$servername = "localhost";
$username = "root";
$password = "";

// Create connection
$conn = new mysqli($servername, $username, $password, "roommates");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
echo "Connected successfully";


	$email=$_POST['email'];
	$pwd=$_POST['password'];
	$fName=$_POST['firstname'];
	$lName=$_POST['lastname'];
	$gender=$_POST['gender'];
	$smokingself=$_POST['smokingself'];
	$drinkingself=$_POST['drinkingself'];
	$foodhabitsself=$_POST['foodhabitsself'];
	$budgetself=$_POST['budgetself'];
	$roommatesself=$_POST['roommatesself'];
	$smokingpreferences=$_POST['smokingpreferences'];
	$drinkingpreferences=$_POST['drinkingpreferences'];
	$foodhabitspreferences=$_POST['foodhabitspreferences'];
	$contactnum=$_POST['contactnum'];
	
	
	
	$sql="insert into user(emailid, password, firstname, lastname, gender, smokingself, drinkingself, foodhabitsself, budget, noofroommates, smokingpreferences, drinkingpreferences, foodhabitspreferences, contactnumber)
	values('$email', '$pwd', '$fName', '$lName','$gender', '$smokingself', '$drinkingself', '$foodhabitsself', '$budgetself', '$roommatesself', '$smokingpreferences', '$drinkingpreferences', '$foodhabitspreferences', '$contactnum')";
	if(!mysqli_query($conn,$sql)){
		echo "insertion failed";
	}
	else {
		echo "inserted";
	}
	header ("refresh:10; url=RS_Signup_Page.html");

?>