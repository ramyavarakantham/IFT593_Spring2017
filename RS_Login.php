<html lang="en">

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
	<script>
		function showAlert(){
		if($("#myAlert").find("div#myAlert2").length==0){
		$("#myAlert").append("div#myAlert2");
		}
		$("#myAlert").css("display", "");
		}
	</script>
</head>
<body>
	<?php
		session_start();
		include ("connection.php");
		$err="";
		if (isset($_POST['login']) && !empty($_POST['emailid']) && !empty($_POST['pwd'])) {
			$email = $_POST["emailid"];    
			$pwd = $_POST["pwd"]; 
			$sql = "SELECT Password FROM user WHERE EmailId = '$email'";
			$result = mysqli_query($conn, $sql);
			$row = mysqli_fetch_row($result);
			if ($row[0] === $pwd){
				//Match - Case sensitive
				echo 1;
				// Set session variables
				$_SESSION["user"] = $email;
				header("Location: login.php"); 
				exit;
			} else {
				//No Match
				echo 0;  
				$err="Invalid emailid or password";
			}
		}
	?>
    <!--Login page content-->
    <div class="container">
        <div class="wrapper">
            <form class="form-signin" method="post" name="login_form" id="login" enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">       
                  <h2 class="form-signin-heading text-info">Find my roommates</h2>
				  	<span><?php echo ((isset($err) && $err != '') ? '<div class="alert alert-danger alert-dismissible">Invalid emailid and password<button type="button" class="close" data-dismiss="alert" aria-label="close"><span aria-hidden="true">&times;</span></button></div>' : ''); ?> </span>
                  <div class="form-group">
                      <label class="sr-only" for="exampleInputEmail2">Email address</label>
                      <input type="email" class="form-control" id="exampleInputEmail2" placeholder="Email address" name="emailid" required>				 
                  </div>
                  <div class="form-group">
                      <label class="sr-only" for="exampleInputPassword2">Password</label>
                      <input type="password" class="form-control" id="exampleInputPassword2" placeholder="Password" name="pwd" required>
                      <div class="help-block text-right"><a id="Forgotpassword">Forgot password?</a></div>											 
                  </div>
                  <div class="form-group">
					  <input  class="btn btn-primary btn-block" type="submit" value="Submit" name="login">
					  <p style="padding:0.5px;"></p>
					  <div class="help-block text-right"><a href="RS_Signup_Page.html">New here?</a></div>	
                  </div>
            </form>
        </div>
    </div>
    <!--Forgot password content-->
     <div id="Forgotpasswordmodal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-md">
        <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h3 class="text-info">Forgot password?</h3>
                </div>
                <div class="modal-body">
                    <fieldset id="modalcontent">
						<h4>Don't worry, we got your back!</h4>
                        <div class="form-group">
                            <input class="form-control input-md" placeholder="Enter your registered email address here" name="email" type="email" required>
                        </div>
                            &nbsp;&nbsp;<input class="btn btn-md btn-primary" value="Send Activation Link" type="submit" onclick="showAlert();">
                    </fieldset>
                    <p style="padding:0.5px;"></p>
					<div style="display:none;" id="myAlert">
						<div class="alert alert-warning alert-dismissible" role="alert" id="myAlert1">Please enter the registered email address. If not yet registered, please <a href="RS_Signup_Page.html" class="alert-link">sign up</a> here.
							<button type="button" class="close" data-dismiss="alert" aria-label="close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="alert alert-success alert-dismissible" role="alert" id="myAlert2">We're glad you're back! Please use this link to <a href="create_new_password.html" class="alert-link"> create a new password</a>.
							<button type="button" class="close" data-dismiss="alert" aria-label="close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
					</div>
                </div>
            </div>
        </div>
    </div>
	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>

	<script src="http://netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function(){
            $("#Forgotpassword").click(function(){
                $("#Forgotpasswordmodal").modal();
            });
        });
    </script>
</body>
</html>