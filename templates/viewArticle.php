<?php include "templates/include/header.php" ?>

      <h1 style="width: 75%;"><?php echo htmlspecialchars( $data['article']->title )?></h1>
      <div style="width: 75%; font-style: italic;"><?php echo htmlspecialchars( $data['article']->outline )?></div>
      <div style="width: 75%;"><?php echo $data['article']->content?></div>
      <p class="pubDate">Published on <?php echo date('j F Y', $data['article']->publicationDate)?></p>

      <p><a href="./">Return to Homepage</a></p>

<?php include "templates/include/footer.php" ?>

