
<html>
	<head>
			<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-social.css">
					
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

		<!-- Latest compiled JavaScript -->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
		
		<!--Mobile first. Adapts itself to screen width-->
		<meta name="viewport" content="width=device-width, initial-scale=1">
		
		<!--font-awesome-->
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

	    <link href="Ramya_index_css.css" rel="stylesheet">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.2/css/bootstrap-select.min.css">
	</head>
	<body>
	<?php
include("connection.php");
	//get user major info
	//$sql_user_major="select * from major where EmailId='".$_SESSION["emailId"]."' and Type=1";
	$sql_user_major="select * from major where EmailId='vishram@gmail.com' and Type=1";
	$result_user_major=mysqli_query($conn, $sql_user_major);
	$row_user_major=mysqli_fetch_array($result_user_major);
?>
							<select  id="majorself" class="selectpicker" name="majorself" multiple=multiple>
								
								<option value="Computer Science"
								<?php if($row_user_major['Major']=='Computer Science'){ ?>
								selected="selected"
								<?php	
								}
								?>
								
								>Computer Science</option>
								<option value="Computer Engineering"
								<?php if($row_user_major['Major']=='Computer Engineering'){ ?>
								selected="selected"
								<?php	
								}
								?>
								>Computer Engineering</option>
								<option value="Electrical Engineering"
								<?php if($row_user_major['Major']=='Electrical Engineering'){ ?>
								selected="selected"
								<?php	
								}
								?>
								>Electrical Engineering</option>
								<option value="Industrial Engineering"
								<?php if($row_user_major['Major']=='Industrial Engineering'){ ?>
								selected="selected"
								<?php	
								}
								?>
								>Industrial Engineering</option>
								<option value="Civil Engineering"
								<?php if($row_user_major['Major']=='Civil Engineering'){ ?>
								selected="selected"
								<?php	
								}
								?>
								>Civil Engineering</option>
								<option value="Chemical Engineering"
								<?php if($row_user_major['Major']=='Chemical Engineering'){ ?>
								selected="selected"
								<?php	
								}
								?>
								>Chemical Engineering</option>
								<option value="Structural Engineering"
								<?php if($row_user_major['Major']=='Structural Engineering'){ ?>
								selected="selected"
								<?php	
								}
								?>
								>Structural Engineering</option>
								<option value="Bio-Medical Engineering"
								<?php if($row_user_major['Major']=='Bio-Medical Engineering'){ ?>
								selected="selected"
								<?php	
								}
								?>
								>Bio-Medical Engineering</option>
								<option value="Mechanical Engineering"
								<?php if($row_user_major['Major']=='Mechanical Engineering'){ ?>
								selected="selected"
								<?php	
								}
								?>
								>Mechanical Engineering</option>
							</select>   
	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.2/js/bootstrap-select.min.js"></script>
<script>
			$('#languagesself').selectpicker();
            $('#budgetself').selectpicker();
            $('#roommatesself').selectpicker();
			$('#majorself').selectpicker();
			$('#nativeself').selectpicker();
			$('#languagespreferences').selectpicker();
			$('#smokingpreferences').selectpicker();
			$('#drinkingpreferences').selectpicker();
			$('#majorpreferences').selectpicker();
			$('#nativepreferences').selectpicker();
			$('#foodhabitspreferences').selectpicker();
			$('#smokingself').selectpicker();
			$('#drinkingself').selectpicker();
			$('#foodhabitsself').selectpicker();
		</script>	
		
	</body>
</html>