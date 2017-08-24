<?php
if(isset($_POST['forgotPass'])){
	include ("connection.php");
	SESSION_START();
			
			$email_fp = $_POST['email'];
			$sql_fp = "SELECT * FROM user WHERE EmailId = '$email_fp'";
			$result_fp = mysqli_query($conn, $sql_fp);
			$rowcount=mysqli_num_rows($result_fp);
			if($rowcount==1)
			{
				echo "user exists";
				$success_fp="user exists";
				$token = md5(uniqid(rand(),true));
				$url="http://localhost:8080/config/";
				$body="<html><body><p>Someone requested that the password be reset.</p>
				<p>If this was a mistake, just ignore this email and nothing will happen.</p>
				<p>To reset your password, visit the following address: <a href='".$url."resetPassword.php?token=$token&email=$email_fp'>".$url."resetPassword.php?token=$token&email=$email_fp</a></p></body></html>";
				echo $url. "</br>";
				echo $body;
				$to= 'ramya.ams6@gmail.com';
				$subject= 'Reset Password: Find my roommates';
				//$message= 'message';
				$headers= 'From: vramya.rv@gmail.com';
				$headers .= "MIME-Version: 1.0\r\n";
				$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
				if(mail($to, $subject, $body, $headers))
					echo "email sent";
				else
					echo 'email sending failed';
				//mail($email_fp, "Reset Password: Find my roommates", $body, "From: vramya.rv@gmail.com\r\n");
				$update_user_token="update user set resetToken='".$token."' where EmailId='".$email_fp."'";
				if(!mysqli_query($conn, $update_user_token))
				{
					echo "user token  not updated</br>";
				}
				else{
					echo "user token updated</br>";
				}
				
				//echo $token;
				
				//header("Location: create_new_password.php"); 
				//exit;
			}
			else{
				echo "user does not exist";
				$err_fp="user does not exist";

			}
		
}
?>
<html>
	<body>
		<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post">
			<input type="email" name="email">
			<input type="submit" name="forgotPass" value="submit">
		</form>
	</body>
</html>