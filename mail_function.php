<?php	
	function sendOTP($email,$otp) {
		require('phpmailer-master/class.phpmailer.php');

		$mail = new PHPMailer();
		$mail->IsSMTP();

		$mail->SMTPDebug = 1;
		$mail->SMTPAuth = TRUE;
		$mail->SMTPSecure = 'ssl'; 
		$mail->Port     = "465";
		$mail->Username = "eojhosting@gmail.com";
		$mail->Password = "eojhosting@99";
		$mail->Host     = "smtp.gmail.com";
		$mail->Mailer   = "smtp";
		$mail->SetFrom("eojhosting@gmail.com");
		$mail->AddAddress($email);
		$mail->Subject = "OTP to Login";
		$mail->IsHTML(true);	
		$mail->Body="Your one time password for logging in is:" .$otp;
		$result = $mail->Send();
		
		if(!$mail->Send()) {
        echo "Mailer Error: " . $mail->ErrorInfo;
     } else {
        echo "Message has been sent";
	header("location: fileupload.php");
     }
		return $result;
	}
?>