<?php

/**
 * Class to handle articles
 */

class Article
{
  // Properties

  /**
  * @var int The article ID from the database
  */
  public $id = null;

  /**
  * @var int When the article is to be / was published
  */
  public $publicationDate = null;

  /**
  * @var string The title of the article
  */
  public $title = null;

  /**
  * @var string A short outline of the article
  */
  public $outline = null;

  /**
  * @var string The HTML content of the article
  */
  public $content = null;


  /**
  * Sets the object's properties using the values in the supplied array
  *
  * @param assoc The property values
  */

  public function __construct( $info=array() ) {
    if ( isset( $info['id'] ) ) $this->id = (int) $info['id'];
    if ( isset( $info['publicationDate'] ) ) $this->publicationDate = (int) $info['publicationDate'];
    if ( isset( $info['title'] ) ) $this->title = preg_replace ( "/[^\,\.\_\-\'\"\@\!\?\:\$ a-zA-Z0-9()]/", "", $info['title'] );
    if ( isset( $info['outline'] ) ) $this->outline = preg_replace ( "/[^\,\.\_\-\'\"\@\!\?\:\$ a-zA-Z0-9()]/", "", $info['outline'] );
    if ( isset( $info['content'] ) ) $this->content = $info['content'];
  }


  /**
  * Sets the object's properties using the values in the supplied array from the edit form
  *
  * @param assoc The form post values
  */

  public function saveFormValues ( $parameters ) {

    // Save all the parameters
    $this->__construct( $parameters );

    // Parse and save the publication date
    if ( isset($parameters['publicationDate']) ) {
      $publicationDate = explode ( '-', $parameters['publicationDate'] );

      if ( count($publicationDate) == 3 ) {
        list ( $y, $m, $d ) = $publicationDate;
        $this->publicationDate = mktime ( 0, 0, 0, $m, $d, $y );
      }
    }
  }


  /**
  * Returns an Article object matching the article ID
  *
  * @param int The article ID
  * @return Article|false The article object, or false if the record was not found or there was an error
  */

  public static function getById( $id ) {
    $conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
    $sql = "SELECT *, UNIX_TIMESTAMP(publicationDate) AS publicationDate FROM articles WHERE id = :id";
    $stmt = $conn->prepare( $sql );
    $stmt->bindValue( ":id", $id, PDO::PARAM_INT );
    $stmt->execute();
    $row = $stmt->fetch();
    $conn = null;
    if ( $row ) return new Article( $row );
  }


  /**
  * Returns a range  (or all) Articles objects in the DB
  *
  * @param int Optional The number of rows to return (default=all)
  * @param string Optional column by which to order the articles (default="publicationDate DESC")
  * @return Array|false A two-element array : results => array, a list of Article objects; totalRows => Total number of articles
  */

  public static function getArticlesList( $numRows=100000, $order="publicationDate DESC" ) {
    $conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
    $sql = "SELECT SQL_CALC_FOUND_ROWS *, UNIX_TIMESTAMP(publicationDate) AS publicationDate FROM articles
            ORDER BY :order LIMIT :numRows";

    $stmt = $conn->prepare( $sql );
	$stmt->bindValue( ":order", $order, PDO::PARAM_STR);
    $stmt->bindValue( ":numRows", $numRows, PDO::PARAM_INT );
    $stmt->execute();
    $list = array();

    while ( $row = $stmt->fetch() ) {
      $article = new Article( $row );
      $list[] = $article;
    }

    // Get the total number of articles that satisfied the criteria
    $sql = "SELECT FOUND_ROWS() AS totalRows";
    $totalRows = $conn->query( $sql )->fetch();
    $conn = null;
    return ( array ( "results" => $list, "totalRows" => $totalRows[0] ) );
  }


  /**
  * Inserts the current Article object into the database, and sets its ID field.
  */

  public function insert() {
	
    // Does the Article object already have an ID?
    if ( !is_null( $this->id ) ) trigger_error ( "Article::insert(): Attempt to insert an Article object that already has its ID field set (to $this->id).", E_USER_ERROR );

    // Insert the Article
    $conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
	
    $sql = "INSERT INTO articles ( publicationDate, title, outline, content ) VALUES ( FROM_UNIXTIME(:publicationDate), :title, :outline, :content )";
    $stmt = $conn->prepare ( $sql );
    $stmt->bindValue( ":publicationDate", $this->publicationDate, PDO::PARAM_INT );
    $stmt->bindValue( ":title", $this->title, PDO::PARAM_STR );
    $stmt->bindValue( ":outline", $this->outline, PDO::PARAM_STR );
    $stmt->bindValue( ":content", $this->content, PDO::PARAM_STR );
    $stmt->execute();
    $this->id = $conn->lastInsertId();
    $conn = null;
  }


  /**
  * Updates the current Article object in the database.
  */

  public function update() {

    // Does the Article object have an ID?
    if ( is_null( $this->id ) ) trigger_error ( "Article::update(): Attempt to update an Article object that does not have its ID property set.", E_USER_ERROR );
   
    // Update the Article
    $conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
    $sql = "UPDATE articles SET publicationDate=FROM_UNIXTIME(:publDate), title=:title, outline=:outline, content=:content WHERE id = :id";
    $stmt = $conn->prepare ( $sql );
    $stmt->bindValue( ":publDate", $this->publicationDate, PDO::PARAM_INT );
    $stmt->bindValue( ":title", $this->title, PDO::PARAM_STR );
    $stmt->bindValue( ":outline", $this->outline, PDO::PARAM_STR );
    $stmt->bindValue( ":content", $this->content, PDO::PARAM_STR );
    $stmt->bindValue( ":id", $this->id, PDO::PARAM_INT );
    $stmt->execute();
    $conn = null;
  }


  /**
  * Deletes the current Article object from the database.
  */

  public function delete() {

    // Does the Article object have an ID?
    if ( is_null( $this->id ) ) trigger_error ( "Article::delete(): Attempt to delete an Article object that does not have its ID property set.", E_USER_ERROR );

    // Delete the Article
    $conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
    $stmt = $conn->prepare ( "DELETE FROM articles WHERE id = :id LIMIT 1" );
    $stmt->bindValue( ":id", $this->id, PDO::PARAM_INT );
    $stmt->execute();
    $conn = null;
  }

}

?>
