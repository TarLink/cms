<?php

require( "config.php" );
$operation = isset( $_GET['operation'] ) ? $_GET['operation'] : "";

switch ( $operation ) {
  case 'archive':
    archive();
    break;
  case 'viewArticle':
    viewArticle();
    break;
  default:
    homepage();
}

function archive() {
  $data = array();
  $data = Article::getArticlesList();
  $data['articles'] = $data['results'];
  $data['totalRows'] = $data['totalRows'];
  $data['pageTitle'] = "Article Archive";
  require( TEMPLATE_PATH . "/archive.php" );
}

function viewArticle() {
  if ( !isset($_GET["articleId"]) || !$_GET["articleId"] ) {
    homepage();
    return;
  }

  $data = array();
  $data['article'] = Article::getById( (int)$_GET["articleId"] );
  $data['pageTitle'] = $data['article']->title;
  require( TEMPLATE_PATH . "/viewArticle.php" );
}

function homepage() {
  $data = array();
  $data = Article::getArticlesList( HOMEPAGE_NUM_ARTICLES );
  $data['articles'] = $data['results'];
  $data['totalRows'] = $data['totalRows'];
  $data['pageTitle'] = "Personal CMS";
  require( TEMPLATE_PATH . "/homepage.php" );
}

?>
