<?php

require( "config.php" );

require( CLASS_PATH . "/SecureSessionHandler.php" );

//for a more secure php session
$session = new SecureSessionHandler( SESSION_KEY );

ini_set('session.save_handler', 'files');
session_set_save_handler($session, true);
session_save_path(__DIR__ . SESSION_FOLDER );

$session->start();

if ( ! $session->isValid(5)) {
    $session->destroy( session_id() );
}

$operation = isset( $_GET['operation'] ) ? $_GET['operation'] : "";

switch ( $operation ) {
  case 'archive':
    archive();
    break;
  case 'viewArticle':
    viewArticle();
    break;
  case 'about':
	about();
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

function about(){
	$data['pageTitle'] = "About";
	require( TEMPLATE_PATH . "/about.php" );	
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
