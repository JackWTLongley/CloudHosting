<?php
require_once "php/config.php";
 
//variables
$email = $password = "";
$email_err = $password_err = "";
 
//processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    //check if email is empty
    if(empty(trim($_POST["email"]))){
        $email_err = "Please enter username.";
    } else{
        $email = trim($_POST["email"]);
    }
    
    //check if password is empty
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    //validate credentials
    if(empty($email_err) && empty($password_err)){
        //select statement
        $sql = "SELECT email, password FROM users WHERE email = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            //set parameters
            $param_email = $email;
            $hashed_password = "";
            //execute the prepared statement
            mysqli_stmt_bind_param($stmt, "s", $param_email);
          
            //execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                mysqli_stmt_store_result($stmt);
                
                //check if username exists, if yes then verify password
                if(mysqli_stmt_num_rows($stmt) == 1){                    
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $email, $hashed_password);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashed_password)){
                            // Redirect user to welcome page
                            header("location: fileupload.php");
                        } else{
                            // Display an error message if password is not valid
                            $password_err = "The password you entered was not valid.";
                        }
                    }
                } else{
                    // Display an error message if username doesn't exist
                    $email_err = "No account found with that email.";
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Close connection
    mysqli_close($link);
}
?>
 
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Web Hosting!</title>
 	<link href="css/style.css" rel="stylesheet">
  </head>
  <body>
    <div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
			<div class="page-header">
				<h1>EOJ Web Hosting! <small>Simple Web solutions for you.</small></h1>
			</div>
			<h2>Registration Page</h2>
			<p>Enter User Credentials Below or if you already have an account login below.</p>
			<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
                <label>E-mail</label>
                <input type="text" name="email" class="form-control" value="<?php echo $email; ?>">
                <span class="help-block"><?php echo $email_err; ?></span>
            </div>    
            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <label>Password</label>
                <input type="password" name="password" class="form-control">
                <span class="help-block"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Login">
            </div>
            <p>Don't have an account? <a href="Registration.php">Sign up now</a>.</p>
	    <p>Log in using only your email <a href="index.php">Login</a>.</p>
        </form>
  </div>
  </div>
  </div>
  </body>
</html>