<?php
/*
  Date       : Novembre 2021
  Auteur     : Elise Leveque
  Sujet      : Librairie de fonctions php

  CRUD original : Monsieur P.Bonvin
 */
require "db_var.php";
/**
 * Connecteur de la base de données du .
 * Le script meurt (die) si la connexion n'est pas possible.
 * @staticvar PDO $dbc
 * @return \PDO
 */
function dbConn()
{
  static $dbc = null;

  // Première visite de la fonction
  if ($dbc == null) {
    // Essaie le code ci-dessous
    try {
      $dbc = new PDO('mysql:host=' . HOST . ';dbname=' . DBNAME, USER, PWD, array(
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
        PDO::ATTR_PERSISTENT => true,
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
      ));
    }
    // Si une exception est arrivée
    catch (Exception $e) {
      echo 'Erreur : ' . $e->getMessage() . '<br />';
      echo 'N° : ' . $e->getCode();
      // Quitte le script et meurt
      die('Could not connect to MySQL');
    }
  }
  // Pas d'erreur, retourne un connecteur
  return $dbc;
}

/**
 * 
 * 
 * Insert
 * 
 * 
 */

/**
 * Ajouter un nouveau post
 *
 * @param string $comm
 * @param string $imgName Le nom de l'image du post
 * @param string $imgType Le type de l'image
 * @param string $imgContent Le contenu de l'image en base64
 * @return mixed idPost, autrement False
 */
function addNewPost($comm, $imgName,$imgType,$imgContent)
{
  $bd = dbConn();
  $bd->beginTransaction();
  $idPost = addPost($comm);
  if ($idPost == -1){
    $bd->rollBack();
    return false;
  }
  $idMedia = addMedia($imgName,$imgType,$imgContent);
  if ($idMedia == -1){
    $bd->rollBack();
    return false;
  }

  if (addContenir($idPost,$idMedia) == false){
    $bd->rollBack();
    return false;
  }

  $bd->commit();
  return $idPost;
}
/**
 * Crée un nouveau post avec une image
 * @param string $imgName Le nom de l'image du post
 * @param string $imgType Le type de l'image
 * @param string $imgContent Le contenu de l'image en base64
 * @return int L'identifiant unique du média, -1 si erreur
 */
function addMedia($imgName,$imgType,$imgContent)
{
  try {  
      $bd = dbConn();
      $requete = $bd->prepare("INSERT INTO media (`nom`,`type`,`image`) VALUES (:NOMIMG , :TYPEIMG, :IMAGE);");
      
      $requete->execute(
          array(
              ':NOMIMG' => $imgName,
              ':TYPEIMG' => $imgType,
              ':IMAGE' => $imgContent
          )
      );
      return $bd->lastInsertId();
    } catch (Exception $e) {
      echo 'Exception reçue : ',  $e->getMessage(), "\n";
  }
  // Fail
  return -1;
}

function addContenir($idPost,$idMedia){

  try {  
    $bd = dbConn();
    $requete = $bd->prepare("INSERT INTO contenir (`idMedia`, `idPost`) VALUES (:IDMEDIA,:IDPOST)");
    $requete->execute(
        array(
            ':IDMEDIA' => $idMedia,
            ':IDPOST' => $idPost
        )
    );
    // Done
    return true;
  } catch (Exception $e) {
        echo 'Exception reçue : ',  $e->getMessage(), "\n";
  }
  // Fail
  return false;
}

/**
 * Insérer un post 
 *
 * @param string $comm Le commentaire du post
 * @return int l'identifiant unique du post. -1 si erreur
 */
function addPost($comm)
{
  $sql = 'INSERT INTO post (`commentaire`,`date`) ';
  $sql .= "VALUES (:COMM, :DATEPOST)";

  $requete = dbConn()->prepare($sql);
  try {
    $date = date("y-m-d");
    $requete->execute(
      array(
          ':COMM' => $comm,
          ':DATEPOST' => $date
      )
    );
    return dbConn()->lastInsertId();
  } catch (Exception $e) {
    echo 'Exception reçue : ',  $e->getMessage(), "\n";
  }
  return -1;
}

/**
 * 
 * 
 * Select
 * 
 * 
 */
/**
 * Montrer les medias d'un post
 *
 * @param int $idPost L'id du post
 * @return array tout les medias rélié au post
 */
function afficherImg($idPost)
{
    try {
        $arr = array();
        $bd = dbConn();
        $requete = $bd->prepare('SELECT media.image, media.type FROM contenir JOIN media ON media.idmedia = contenir.idMedia 
        JOIN post ON post.idPost = contenir.idPost WHERE post.idPost = :idpost', array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $requete->execute(
            array(
                ':idpost' => $idPost,
            )
        );
        $requete->bindColumn(1, $data, PDO::PARAM_LOB);
        $requete->bindColumn(2, $mime);

        while ($data = $requete->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT)) {
            array_push($arr, $data);
        }

        return $arr;
    } catch (Exception $e) {
        echo 'Exception reçue : ',  $e->getMessage(), "\n";
    }
}

/**
 * Montrer tout les posts
 *
 * @return array tout les posts
 */
function afficherPost()
{
    try {
        $bd = dbConn();
        $requete = $bd->prepare('SELECT * FROM post');
        $requete->execute();
        return $requete->fetchAll();
    } catch (Exception $e) {
        echo 'Exception reçue : ',  $e->getMessage(), "\n";
    }
}



/*function function_alert($message) {
      
    // Display the alert box 
    echo "<script>alert('$message');</script>";
}*/



?>