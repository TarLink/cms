<!DOCTYPE html>
<html lang="en">
  <head>
	<title><?php echo htmlspecialchars( $data['pageTitle'] )?></title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<?php
	if ( isset($attempt_login) && $attempt_login == true ){?>
		<script src="https://www.google.com/recaptcha/api.js" async defer></script>
		<script>
		   function onSubmit(token) {
			 document.getElementById("login-form").submit();
		   }
		 </script>
	<?php }
	?>
	<link rel="stylesheet" type="text/css" href="style.css" />
  </head>
  <body>
    <div class="container">

     

