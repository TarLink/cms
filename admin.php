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
$username = isset( $_SESSION['username'] ) ? $_SESSION['username'] : "";

if ( $operation != "login" && $operation != "logout" && !$username ) {
  login();
  exit;
}

switch ( $operation ) {
  case 'login':
    login();
    break;
  case 'logout':
    logout();
    break;
  case 'newArticle':
    newArticle();
    break;
  case 'editArticle':
    editArticle();
    break;
  case 'deleteArticle':
    deleteArticle();
    break;
  default:
    listArticles();
}


function login() {

  $data = array();
  $data['pageTitle'] = "Admin Login";

  if ( isset( $_POST['login'] ) ) {

		// User has posted the login form: attempt to log the user in
		
		//captcha verify that is not a robot
		
		$result = file_get_contents( 'https://www.google.com/recaptcha/api/siteverify', false, stream_context_create( array(
			'http' => array(
				'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
				'method'  => 'POST',
				'content' => http_build_query( array(
					'response' => $_POST['g-recaptcha-response'],
					'secret' => SECRET_CAPTCHA_KEY
				) ),
			),
		) ) );
		$result = json_decode($result);
		
		if ($result->success) {
			$logged_in_flag = false; // somehow a more complex code flow
			if (isset($_POST['username']) && isset($_POST['password'])) {
				
				try {
					$pdo = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD);
					$pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false); //for security purposes
					$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); //enables error output
					
					$stmt=$pdo->prepare("SELECT password FROM members WHERE username = :username LIMIT 1");
					$stmt->bindValue(":username",$_POST['username']);
					$stmt->execute();
					$hash_pwd = $stmt->fetchColumn();
				} catch(PDOException $e){
					error_log("Database error: " . $e->getMessage());
					die("Database error");
				} catch (Exception $e ){
					error_log("General error: " . $e->getMessage());
					die("General error");
				}
				if (isset($hash_pwd) && password_verify($_POST['password'],$hash_pwd)){
					$logged_in_flag = true;
					 
				}

			} 
			
			//Here it is decided if loggin successfull
			
			if ($logged_in_flag == true ){
				// Login successful: Create a session and redirect to the admin homepage
					  $_SESSION['username'] = $_POST['username'];
					  header( "Location: admin.php" );
			}
			else  {

				  // Login failed: display an error message to the user
				  $data['errorMessage'] = "Incorrect username or password. Please try again.";
				  
				  //flag for loading of invisible captcha scripts
				  $attempt_login = true;
				
				  require( TEMPLATE_PATH . "/admin/loginForm.php" );
			}
		} else {
			header("Location: index.php");	// you are an evil robot	
		}
  } else {
	  
		// User has not posted the login form yet
		
		//flag for loading of invisible captcha scripts
		$attempt_login = true;

		// display the form
		require( TEMPLATE_PATH . "/admin/loginForm.php" );
  }

}


function logout() {
  global $session;
  unset( $_SESSION['username'] );
  $session->destroy( session_id() );
  header( "Location: admin.php" );
}


function newArticle() {

  $data = array();
  $data['pageTitle'] = "New Article";
  $data['formAction'] = "newArticle";

  if ( isset( $_POST['saveChanges'] ) ) {

    // User has posted the article edit form: save the new article
    $article = new Article;
    $article->saveFormValues( $_POST );
    $article->insert();
    header( "Location: admin.php?status=changesSaved" );

  } elseif ( isset( $_POST['cancel'] ) ) {

    // User has cancelled their edits: return to the article list
    header( "Location: admin.php" );
  } else {

    // User has not posted the article edit form yet: display the form
    $data['article'] = new Article;
    require( TEMPLATE_PATH . "/admin/editArticle.php" );
  }

}


function editArticle() {

  $data = array();
  $data['pageTitle'] = "Edit Article";
  $data['formAction'] = "editArticle";

  if ( isset( $_POST['saveChanges'] ) ) {

    // User has posted the article edit form: save the article changes

    if ( !$article = Article::getById( (int)$_POST['articleId'] ) ) {
      header( "Location: admin.php?error=articleNotFound" );
      return;
    }

    $article->saveFormValues( $_POST );
    $article->update();
    header( "Location: admin.php?status=changesSaved" );

  } elseif ( isset( $_POST['cancel'] ) ) {

    // User has cancelled their edits: return to the article list
    header( "Location: admin.php" );
  } else {

    // User has not posted the article edit form yet: display the form
    $data['article'] = Article::getById( (int)$_GET['articleId'] );
    require( TEMPLATE_PATH . "/admin/editArticle.php" );
  }

}


function deleteArticle() {

  if ( !$article = Article::getById( (int)$_GET['articleId'] ) ) {
    header( "Location: admin.php?error=articleNotFound" );
    return;
  }

  $article->delete();
  header( "Location: admin.php?status=articleDeleted" );
}


function listArticles() {
  $data = array();
  $data = Article::getArticlesList();
  $data['articles'] = $data['results'];
  $data['totalRows'] = $data['totalRows'];
  $data['pageTitle'] = "All Articles";

  if ( isset( $_GET['error'] ) ) {
    if ( $_GET['error'] == "articleNotFound" ) $data['errorMessage'] = "Error: Article not found.";
  }

  if ( isset( $_GET['status'] ) ) {
    if ( $_GET['status'] == "changesSaved" ) $data['statusMessage'] = "Your changes have been saved.";
    if ( $_GET['status'] == "articleDeleted" ) $data['statusMessage'] = "Article deleted.";
  }

  require( TEMPLATE_PATH . "/admin/listArticles.php" );
}

?>
