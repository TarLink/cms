<?php include "templates/include/header.php" ?>

      <h1><?php echo $data['pageTitle']?></h1>
	  <div class="panel panel-default form edit-article">
	  <div class="panel-body">
		  <form class="form-horizontal" action="admin.php?operation=<?php echo $data['formAction']?>" method="post">
			<input type="hidden" name="articleId" value="<?php echo $data['article']->id ?>"/>

	<?php if ( isset( $data['errorMessage'] ) ) { ?>
			<div class="alert alert-warning"><?php echo $data['errorMessage'] ?></div>
	<?php } ?>

			<div class="form-group">
				<label class="input-label col-sm-2 right-align" for="title">Article Title</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" name="title" id="title" placeholder="Name of the article" required autofocus maxlength="255" value="<?php echo htmlspecialchars( $data['article']->title )?>" />
				</div>
			</div>
			
			<div class="form-group">
				<label class="input-label col-sm-2 right-align" for="outline">Article outline</label>
				<div class="col-sm-10">
					<textarea name="outline" class="form-control" id="outline" placeholder="Brief description of the article" required maxlength="1000" style="height: 5em;"><?php echo htmlspecialchars( $data['article']->outline )?></textarea>
				</div>
			</div>
			
			<div class="form-group">
				<label class="input-label col-sm-2 right-align" for="content">Article Content</label>
				<div class="col-sm-10">
					<textarea name="content" class="form-control" id="content" placeholder="The HTML content of the article" required maxlength="100000" style="height: 30em;"><?php echo htmlspecialchars( $data['article']->content )?></textarea>
				</div>
			</div>
			  
			<div class="form-group">
				<label class="input-label col-sm-2 right-align" for="publicationDate">Publication Date</label>
				<div class="col-sm-10">
					<input type="date" class="form-control" name="publicationDate" id="publicationDate" placeholder="YYYY-MM-DD" required maxlength="10" value="<?php echo $data['article']->publicationDate ? date( "Y-m-d", $data['article']->publicationDate ) : "" ?>" />
				</div>
			</div> 

			<div class="top-buffer row">
				<div class="col-sm-3"></div>
				<div class="col-xs-6 col-sm-2">
					<button type="submit" name="saveChanges" class="btn btn-default btn-block" >Save Changes</button>
				</div>
				<div class="col-sm-2"></div>
				<div class="col-xs-6 col-sm-2">
					<button type="submit" formnovalidate name="cancel" class="btn btn-default btn-block">Cancel</button>
				</div>
				<div class="col-sm-3"></div>
			</div>

		  </form>
		</div>
		</div>
<?php if ( $data['article']->id ) { ?>
      <p><a href="admin.php?operation=deleteArticle&amp;articleId=<?php echo $data['article']->id ?>" onclick="return confirm('Delete This Article?')">Delete This Article</a></p>
<?php } ?>

<?php include "templates/include/footer.php" ?>

