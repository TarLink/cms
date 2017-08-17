<?php include "templates/include/header.php" ?>

      <h1 class="view-article" ><?php echo htmlspecialchars( $data['article']->title )?></h1>
      <div class="view-article" id="outline"><?php echo htmlspecialchars( $data['article']->outline )?></div>
      <div class="view-article" ><?php echo $data['article']->content?></div>
      <p class="pub-date">Published on <?php echo date('j F Y', $data['article']->publicationDate)?></p>

      <p><a href="./">Return to Homepage</a></p>

<?php include "templates/include/footer.php" ?>

