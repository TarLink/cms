DROP TABLE IF EXISTS articles;
CREATE TABLE articles
(
  id              smallint unsigned NOT NULL auto_increment,
  publicationDate date NOT NULL,                              # When the article was published
  title           varchar(255) NOT NULL,                      # Full title of the article
  outline         text NOT NULL,                              # A short summary of the article
  content         mediumtext NOT NULL,                        # The HTML content of the article

  PRIMARY KEY     (id)
);

DROP TABLE IF EXISTS members;
CREATE TABLE members
(
  id              smallint unsigned NOT NULL auto_increment,
  username        varchar(30) NOT NULL,                 
  email           varchar(50) NOT NULL,                     
  password        varchar(255) NOT NULL, 					  #the php hash length may change over time (see manual)                      
  PRIMARY KEY     (id)
)ENGINE = InnoDB;
