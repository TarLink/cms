<?php include "templates/include/header.php" ?>

      <div id="admin_header">
        <h2>Header Admin</h2>
        <p>You are logged in as <b><?php echo htmlspecialchars( $_SESSION['username']) ?></b>. <a href="admin.php?operation=logout"?>Log out</a></p>
      </div>

      <h1><?php echo $data['pageTitle']?></h1>

      <form action="admin.php?operation=<?php echo $data['formAction']?>" method="post">
        <input type="hidden" name="articleId" value="<?php echo $data['article']->id ?>"/>

<?php if ( isset( $data['errorMessage'] ) ) { ?>
        <div class="error_message"><?php echo $data['errorMessage'] ?></div>
<?php } ?>

        <ul>

          <li>
            <label for="title">Article Title</label>
            <input type="text" name="title" id="title" placeholder="Name of the article" required autofocus maxlength="255" value="<?php echo htmlspecialchars( $data['article']->title )?>" />
          </li>

          <li>
            <label for="outline">Article outline</label>
            <textarea name="outline" id="outline" placeholder="Brief description of the article" required maxlength="1000" style="height: 5em;"><?php echo htmlspecialchars( $data['article']->outline )?></textarea>
          </li>

          <li>
            <label for="content">Article Content</label>
            <textarea name="content" id="content" placeholder="The HTML content of the article" required maxlength="100000" style="height: 30em;"><?php echo htmlspecialchars( $data['article']->content )?></textarea>
          </li>

          <li>
            <label for="publicationDate">Publication Date</label>
            <input type="date" name="publicationDate" id="publicationDate" placeholder="YYYY-MM-DD" required maxlength="10" value="<?php echo $data['article']->publicationDate ? date( "Y-m-d", $data['article']->publicationDate ) : "" ?>" />
          </li>


        </ul>

        <div class="buttons">
          <input type="submit" name="saveChanges" value="Save Changes" />
          <input type="submit" formnovalidate name="cancel" value="Cancel" />
        </div>

      </form>

<?php if ( $data['article']->id ) { ?>
      <p><a href="admin.php?operation=deleteArticle&amp;articleId=<?php echo $data['article']->id ?>" onclick="return confirm('Delete This Article?')">Delete This Article</a></p>
<?php } ?>

<?php include "templates/include/footer.php" ?>

