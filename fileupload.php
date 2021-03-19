<?php

?>
<!DOCTYPE html>
<html>
<head>
  <title>EOJ HOSTING</title>
<link href="css/style.css" rel="stylesheet">
</head>
<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
			<ul class="nav">
				</li>
	<div>
                                    <a href="login.php" class="btn btn-secondary btn-lg active" role="button" aria-pressed="true">Login</a>
    </div>

<div class="jumbotron text-center">
  <h1>EOJ HOSTING</h1>
  <p>At EOJ HOSTING, you are free to download and upload files to our website</p>
<body>
  <?php
    if (isset($_SESSION['message']) && $_SESSION['message'])
    {
      printf('<b>%s</b>', $_SESSION['message']);
      unset($_SESSION['message']);
    }
  ?>
  <form method="POST" action="upload.php" enctype="multipart/form-data">
    <div>
      <span>Upload a File:</span>
      <input type="file" name="uploadedFile" />
    </div>

    <input type="submit" name="uploadBtn" value="Upload" />
  </form>

			<address>
				 <strong>EOJ HOSTING, Inc.</strong><br /> 795 Folsom Ave, Suite 600<br /> Liverpool, L6 1AA<br /> <abbr title="Phone">TN:</abbr> 07460504646
			</address>
		</div>
	</div>

</body>
</html>
