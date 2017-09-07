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
		if(!empty($_SESSION['username'])){?>
				<script src='https://cloud.tinymce.com/stable/tinymce.min.js?apiKey=5jje6s044e3b2on5vg9l0n2gpmb3qslt8ujqs2bnz4580itb'></script>
				<script>
					tinymce.init({
						branding: false,
						selector:'#content',
						plugins:'image',
						menubar: 'file edit insert view format table tools',
						toolbar: 'undo redo styleselect bold italic alignleft aligncenter alignright bullist numlist outdent indent image',
						
						setup: function (editor) {
							editor.on('change', function (e) {
								editor.save();
							});
						}
					});
				</script>
		<?php }
	?>
	<script src="/use_images.js"></script>
	<link rel="stylesheet" type="text/css" href="style.css" />
  </head>
  <body>
    <div class="container">
		<nav class="navbar navbar-default">
			<div class="container-fluid divider">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href="#">Personal CMS</a>
				</div> 
				<div class="collapse navbar-collapse" id="myNavbar">
					<ul class="nav navbar-nav">
						<li><a href="./">Home</a></li><hr class="hr-menu" />
						<li><a href="/photoshow">Gallery</a></li><hr class="hr-menu" />
						<li><a href="index.php?operation=about">About</a></li><hr class="hr-menu <?php if ($data['pageTitle'] == "Admin Login"){?> hr-menu-last <?php } //do not display last hr if page is login form ?>" hr />
					</ul>
					<?php if( empty($_SESSION['username']) && $data['pageTitle'] != "Admin Login"){//display only if not logged in or the login form not displayed?>
						<ul class="nav navbar-nav navbar-right">
							<li><a href="admin.php"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
						</ul>
					<?php } 
					if(!empty($_SESSION['username'])) { ?>
						<ul class="nav navbar-nav navbar-right">
							<li><a href="admin.php?operation=logout"><span class="glyphicon glyphicon-log-out"></span> Log out</a></li><hr class="hr-menu" />
						</ul>
						<p class="navbar-text navbar-right"><a href="admin.php" id="admin-link">You are logged in as <b><?php echo htmlspecialchars( $_SESSION['username']) ?></b></a></p>
					<?php } ?>
				</div>
			</div>
			
		</nav>
		

     

