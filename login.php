<?php
include("connection.php");
$sql = "SELECT * FROM user";
if($result = mysqli_query($conn, $sql)){
	echo "query processed";
    if(mysqli_num_rows($result) > 0){
		echo "mpre than one record processed";
		 while($row = mysqli_fetch_array($result)){
				echo "fetch each processed";
				//case sensitive
                echo $row['EmailId'];
                echo $row['FirstName'];
                echo $row['LastName'];

        }
	}
}
?>
