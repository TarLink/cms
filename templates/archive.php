<?php include "templates/include/header.php" ?>

      <h1>Article Archive</h1>

<?php foreach ( $data['articles'] as $article ) { ?>

       
		<div class="row headlines">
			    <div class="col-sm-2">
					<h2>
					<span class="pub-date"><?php echo date('j F Y', $article->publicationDate)?></span>
					</h2>
				</div>
				<div class="col-sm-10">
					<h2>
					<a href=".?operation=viewArticle&amp;articleId=<?php echo $article->id?>"><?php echo htmlspecialchars( $article->title )?></a>
					</h2>
				    <p class="summary"><?php echo htmlspecialchars( $article->outline )?></p>
			    </div>
		</div>
  

<?php } ?>

      </ul>

      <p><?php echo $data['totalRows']?> article<?php echo ( $data['totalRows'] != 1 ) ? 's' : '' ?> in total.</p>

      <p><a href="./">Return to Homepage</a></p>

<?php include "templates/include/footer.php" ?>

