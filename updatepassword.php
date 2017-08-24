<html>
	<head>
		 <meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<!-- The above 3 meta tags *must* come first in the head; any other head 
			 content must come *after* these tags -->
		<title>Ristorante Con Fusion: About Us</title>
		  <!-- Bootstrap -->
		  <!-- Latest compiled and minified CSS -->
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
			
		<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
		  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->

	</head>
	<body>
		<?php
				include("connection.php");
				SESSION_START();
				if (isset($_POST['submit']) && !empty($_POST['curr_pwd']) && !empty($_POST['new_pwd']) && !empty($_POST['retype_pwd'])) { 
				
					//set vars
					$curr_pwd=$_POST['curr_pwd'];
					$new_pwd=$_POST['new_pwd'];
					$retype_pwd=$_POST['retype_pwd'];
					$msg='';
					
					//check if pwds match
							if($_POST['new_pwd']!=$_POST['retype_pwd'])
							{
								echo "Passwords do not match";
								exit;
							}
							else
							{
							//check if curr pwd is correct pwd
							
							//$email=$_SESSION['emailId'];
							$email='vishram@gmail.com';
							
							//get pwd from user
							$sql = "SELECT Password FROM user WHERE EmailId = '$email'";
							$result = mysqli_query($conn, $sql);
							$row = mysqli_fetch_row($result);
							
							//check against hashed pwd
							if (password_verify($pwd, $row[0])){
								
								$pwd = $_POST["new_pwd"]; 
								$hashedPassword = password_hash($pwd, PASSWORD_DEFAULT);
								//$sql = "Update user set Password='".$hashedPassword."' where EmailId='".$_SESSION['emailId']."'";
								$sql = "Update user set Password='".$hashedPassword."' where EmailId='vishram@gmail.com'";
								$result = mysqli_query($conn, $sql);
								if(mysqli_affected_rows($conn)==1)
								{
									$msg="Your password has been updated"; 
									exit;
								}
								else{
									$msg="There was an error encountered in updating your password";
									exit;
								}
							}
							else{
								$msg="Current password is incorrect. If you have forgotten you password, please use this link to reset it";
								exit;
							}					
					}
				}
		?>
		<!--Update page content-->
		<div class="container">
			<div class="wrapper">
				<form class="form-signin" method="post" name="updatepwd_form" id="updatepwd_form" enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">       
					  <h2 class="form-signin-heading text-info">Update Password</h2>
					  <div class="form-group">
						  <label class="sr-only" for="password">Current password</label>
						  <input type="password" class="form-control" id="curr_pwd" name="curr_pwd" placeholder="Current password" required>										 
					  </div>
					  <div class="form-group">
						  <label class="sr-only" for="password">New password</label>
						  <input type="password" class="form-control" id="new_pwd" name="new_pwd" placeholder="New password" required>										 
					  </div>
					  <div class="form-group">
						  <label class="sr-only" for="retype_password">Retype new password</label>
						  <input type="password" class="form-control" id="retype_password" name="retype_password" placeholder="Retype new password" required>										 
					  </div>
					  <div class="form-group">
						  <a href="#" style="float:left;"><b>Back</b></a>
						  <div class="col-md-3"></div>
					  	  <input  class="btn btn-primary" type="submit" value="Update" name="updatepwd_submit" >
					  </div>
					  <span><?php echo ((isset($msg) && $msg != '') ? '<div class="alert alert-danger alert-dismissible">'.$msg.'<button type="button" class="close" data-dismiss="alert" aria-label="close"><span aria-hidden="true">&times;</span></button></div>' : ''); ?> </span>
				</form>
			</div>
		</div>
	</body>
</html>