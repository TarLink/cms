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
  $data = Article::getList();
  $data['articles'] = $data['results'];
  $data['totalRows'] = $data['totalRows'];
  $data['pageTitle'] = "Article Archive | Widget News";
  require( TEMPLATE_PATH . "/archive.php" );
}

function viewArticle() {
  if ( !isset($_GET["articleId"]) || !$_GET["articleId"] ) {
    homepage();
    return;
  }

  $data = array();
  $data['article'] = Article::getById( (int)$_GET["articleId"] );
  $data['pageTitle'] = $data['article']->title . " | Widget News";
  require( TEMPLATE_PATH . "/viewArticle.php" );
}

function homepage() {
  $data = array();
  $data = Article::getList( HOMEPAGE_NUM_ARTICLES );
  $data['articles'] = $data['results'];
  $data['totalRows'] = $data['totalRows'];
  $data['pageTitle'] = "Widget News";
  require( TEMPLATE_PATH . "/homepage.php" );
}

?>
