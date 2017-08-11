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
				if (isset($_POST['updatepwd_submit']) && !empty($_POST['updatepwd'])) { 
					$pwd = $_POST["updatepwd"]; 
					$sql = "Update user set Password='$pwd' where EmailId='$_SESSION['user']'";
					$result = mysqli_query($conn, $sql);
					if(mysqli_affected_rows($conn)==1)
					{
						header("Location: RS_Login.php"); 
						exit;
					}
				}
		?>
		<!--Login page content-->
		<div class="container">
			<div class="wrapper">
				<form class="form-signin" method="post" name="updatepwd_form" id="updatepwd_form" enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">       
					  <h2 class="form-signin-heading text-info">Create new password</h2>
					  <div class="form-group">
						  <label class="sr-only" for="exampleInputPassword2">Your new password</label>
						  <input type="password" class="form-control" id="exampleInputPassword2" name="updatepwd" placeholder="Your new password" required>										 
					  </div>
					  <div class="form-group">
					  	  <input  class="btn btn-primary btn-block" type="submit" value="Update" name="updatepwd_submit">
					  </div>
					  <div style="display:none;" id="myAlert"> 
						  <div class="alert alert-success alert-dismissible" role="alert" id="myAlert2">Your password has been updated!<a href="RS_Login.html" class="alert-link"> Login</a> with your updated credentials.
							<button type="button" class="close" data-dismiss="alert" aria-label="close">
								<span aria-hidden="true">&times;</span>
							</button>
						  </div>
					  </div>
				</form>
			</div>
		</div>
	</body>
</html>