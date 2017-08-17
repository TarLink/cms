<?php include "templates/include/header.php" ?>
	<div class="panel panel-default form">
	<div class="panel-body">
      <form class="form-horizontal"  action="admin.php?operation=login" method="post" >
		
			<input  type="hidden" name="login" value="true" />
			
				<?php if ( isset( $data['errorMessage'] ) ) { ?>
					<div class="alert alert-warning"><?php echo $data['errorMessage'] ?></div>
				<?php } ?>
			
		
		<div class="form-group">
	
			<label class="input-label col-sm-2" for="username">Username</label>
			<div class="col-sm-10">
				<input type="text"  name="username" class="form-control " id="username" placeholder="Your admin username" required autofocus maxlength="20" />
			</div>
		
		</div>
		<div class="form-group">
		
			<label class="input-label col-sm-2" for="password">Password</label>
			<div class="col-sm-10">
				<input type="password"   name="password" class="form-control " id="password" placeholder="Your admin password" required maxlength="20" />
			</div>
	
		</div>
				
			
          <button type="submit" name="login" class="btn btn-default" >Login</button>
       
		
      </form>
	  </div>
	</div>

<?php include "templates/include/footer.php" ?>

