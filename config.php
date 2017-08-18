<?php
ini_set( "display_errors", true );
date_default_timezone_set( "Europe/Bucharest" );  // http://www.php.net/manual/en/timezones.php
define( "DB_DSN", "mysql:host=localhost;dbname=cms" );
define( "DB_USERNAME", "cms" );
define( "DB_PASSWORD", "cms" );
define( "CLASS_PATH", "classes" );
define( "TEMPLATE_PATH", "templates" );
define( "HOMEPAGE_NUM_ARTICLES", 5 );
define( "ADMIN_USERNAME", "cms" );
define( "ADMIN_PASSWORD", "cms" );
require( CLASS_PATH . "/Article.php" );

define( "MY_SESSION_NAME", "cms" );
define( "SESSION_KEY", "cms" );
define( "SESSION_FOLDER", "/sessions");

function handleException( $exception ) {
  echo "Sorry, a problem occurred. Please try later.";
  error_log( $exception->getMessage() );
}

set_exception_handler( 'handleException' );
?>
