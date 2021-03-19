<?php
require_once "php/config.php";

//Define variables
$username  = $email = $password = $confirm_password = "";
$username_err = $email_err = $password_err = $confirm_password_err = "";

//processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    
    //validate username
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter a username.";
    } 
    else if (!preg_match("/^[a-zA-Z-']*$/",trim($_POST["username"]))) {
        $username_err = "Only letters allowed";
    }
    else{
        //select statement
        $sql = "SELECT username FROM users WHERE username = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            //set parameters
            $param_username = trim($_POST["username"]);
            //input variables to statement
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            //execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                mysqli_stmt_store_result($stmt);
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $username_err = "This username is already taken.";
                } else{
                    $username = trim($_POST["username"]);
                }
            } else{
                echo "Something went wrong.";
            }
            
            //close
            mysqli_stmt_close($stmt);
        }
    }
    
    //validate email
    if(empty(trim($_POST["email"]))){
        $email_err = "Please enter an email.";
    }else if(!filter_var(trim($_POST["email"]), FILTER_VALIDATE_EMAIL)){
        $email_err = "Invalid email format";
    }else{
        //select statement
        $sql = "SELECT email FROM users WHERE email = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            //set parameters
            $param_email = trim($_POST["email"]);
            //input variables to statement
            mysqli_stmt_bind_param($stmt, "s", $param_email);
            
            //execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                mysqli_stmt_store_result($stmt);
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $username_err = "This email is already taken.";
                } else{
                    $email = trim($_POST["email"]);
                }
            } else{
                echo "Something went wrong.";
            }
            
            //close
            mysqli_stmt_close($stmt);
        }
    }
    
    //make sure password meets character minimum
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password.";
    }elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "Password must have atleast 6 characters.";
    }else{
        $password = trim($_POST["password"]);
    }
    
    //confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm password.";
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }
    
    //check for errors
    if(empty($username_err) && empty($email_err) && empty($password_err) && empty($confirm_password_err)){
        //define insert statement
        $sql = "INSERT INTO users (email, username, password) VALUES (?, ?, ?)";
        if($stmt = mysqli_prepare($link, $sql)){
            //define parameters for query.
            $param_username = $username;
            $param_email = $email;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            //input variables to statement
            mysqli_stmt_bind_param($stmt, "sss", $param_email, $param_username, $param_password);
            //execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                //go to login page
                header("location: Login.php");
            } else{
                echo "Something went wrong. Please try again later.";
            }
            
            //close
            mysqli_stmt_close($stmt);
        }
    }
    //close
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
                <label>Username</label>
                <input type="text" name="username" class="form-control" value="<?php echo $email; ?>">
                <span class="help-block"><?php echo $email_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
                <label>E-Mail</label>
                <input type="text" name="email" class="form-control" value="<?php echo $email; ?>">
                <span class="help-block"><?php echo $email_err; ?></span>
            </div>      
            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <label>Password</label>
                <input type="password" name="password" class="form-control" value="<?php echo $password; ?>">
                <span class="help-block"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                <label>Confirm Password</label>
                <input type="password" name="confirm_password" class="form-control" value="<?php echo $confirm_password; ?>">
                <span class="help-block"><?php echo $confirm_password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <input type="reset" class="btn btn-default" value="Reset">
            </div>
            <p>Already have an account? <a href="login.php">Login here</a>.</p>
        </form>
  </div>
  </div>
  </div>
  </body>
</html>