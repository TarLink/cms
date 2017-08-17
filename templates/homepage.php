<?php include "templates/include/header.php" ?>
	
      

<?php foreach ( $data['articles'] as $article ) { ?>

        
		<div class="row headlines">
			<div class="col-sm-2">
				<h2>
				<span class="pub-date"><?php echo date('j F', $article->publicationDate)?></span>
				</h2>
			</div>
			<div class="col-sm-10">
				<h2>
				<a href=".?operation=viewArticle&amp;articleId=<?php echo $article->id?>"><?php echo htmlspecialchars( $article->title )?></a>
				</h2>
				<p class="summary"><?php echo htmlspecialchars( $article->outline )?></p>
			</div>
		</div><!--end class="row"-->
    

<?php } ?>

   

      <p><a href="./?operation=archive">Article Archive</a></p>
	  
	
<?php include "templates/include/footer.php" ?>

