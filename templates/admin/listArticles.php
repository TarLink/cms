<?php include "templates/include/header.php" ?>

      <div id="admin_header">
        <h2>Header Admin</h2>
        <p>You are logged in as <b><?php echo htmlspecialchars( $_SESSION['username']) ?></b>. <a href="admin.php?operation=logout"?>Log out</a></p>
      </div>

      <h1>All Articles</h1>

<?php if ( isset( $data['errorMessage'] ) ) { ?>
		<div class="alert alert-warning"><?php echo $data['errorMessage'] ?></div>
<?php } ?>


<?php if ( isset( $data['statusMessage'] ) ) { ?>
        <div class="alert alert-info"><?php echo $data['statusMessage'] ?></div>
<?php } ?>

    <table class="table table-bordered table-striped table-hover">
        <tr>
          <th>Publication Date</th>
          <th>Article</th>
        </tr>

<?php foreach ( $data['articles'] as $article ) { ?>

        <tr onclick="location='admin.php?operation=editArticle&amp;articleId=<?php echo $article->id?>'">
          <td><?php echo date('j M Y', $article->publicationDate)?></td>
          <td>
            <?php echo $article->title?>
          </td>
        </tr>

<?php } ?>

    </table>

      <p><?php echo $data['totalRows']?> article<?php echo ( $data['totalRows'] != 1 ) ? 's' : '' ?> in total.</p>

      <p><a href="admin.php?operation=newArticle">Add a New Article</a></p>

<?php include "templates/include/footer.php" ?>

