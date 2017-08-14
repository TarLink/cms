<?php include "templates/include/header.php" ?>

      <ul id="headlines">

<?php foreach ( $data['articles'] as $article ) { ?>

        <li>
          <h2>
            <span class="pubDate"><?php echo date('j F', $article->publicationDate)?></span><a href=".?operation=viewArticle&amp;articleId=<?php echo $article->id?>"><?php echo htmlspecialchars( $article->title )?></a>
          </h2>
          <p class="summary"><?php echo htmlspecialchars( $article->summary )?></p>
        </li>

<?php } ?>

      </ul>

      <p><a href="./?operation=archive">Article Archive</a></p>

<?php include "templates/include/footer.php" ?>

