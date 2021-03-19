<?php
$success = "";
$error_message = "";
$conn = mysqli_connect("localhost","root","","eoj");
if(!empty($_POST["submit_email"])) {
	$result = mysqli_query($conn,"SELECT * FROM users WHERE email='" . $_POST["email"] . "'");
	$count  = mysqli_num_rows($result);
	if($count>0) {
		// generate OTP
		$otp = rand(100000,999999);
		// Send OTP
		require_once("mail_function.php");
		$mail_status = sendOTP($_POST["email"],$otp);
		
}	
}
?>
<html>
<head>
<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<title>User Login</title>
	<link href="css/style.css" rel="stylesheet">
</head>
<body>
	<div class="page-header">
				<h1>EOJ Web Hosting! <small>Simple Web solutions for you.</small></h1>
			</div>
	<br />
	<br />
	<br />
	<?php
		if(!empty($error_message)) {
	?>
	<div class="message error_message"><?php echo $error_message; ?></div>
	<?php
		}
	?>
		
		<form name="frmUser" method="post" action="">
		<div class="tblLogin">
		<?php 
			if(!empty($success == 1)) { 
		?>
		<div class="tableheader">Enter OTP</div>
		<p>Check your email for the OTP</p>
			
		<div class="tablerow">
			<input type="text" name="otp" placeholder="One Time Password" class="login-input" required>
		</div>
		<div class="tableheader"><input type="submit" name="submit_otp" value="Submit" class="btnSubmit"></div>
		<?php 
			} else if ($success == 2) {
        ?>
		<p>Welcome, You have successfully loggedin!</p>
		<?php
			}
			else {
		?>
		
		<div class="tableheader">Enter Your Login Email</div>
		<div class="tablerow"><input type="text" name="email" placeholder="Email" class="login-input" required></div>
		<div class="tableheader"><input type="submit" name="submit_email" value="Submit" class="btnSubmit"></div>
		<?php 
			}
		?>
	</div>
</form>
</body></html>