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
      session_start();
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
 * Create
 * 
 * 
 */

/**
 * Crée un nouveau post avec une image
 * @param $img =  image du post
 * @param $comm =  commentaire du post
 * @param $date =  date du post
 * @return $answer
 */
function addPost($imgName,$imgType,$imgContent,$comm)
{
  static $ps = null;
  static $ps2 = null;

  dbConn()->beginTransaction(); 

  $sql = 'INSERT INTO post (`idPost`, `commentaires`,,`datePost`) ';
  $sql .= "VALUES (NULL ,:COMM, :DATEPOST)";

  $sql2 = 'INSERT INTO media (`idMedia`, `nomFichierMedia`,`typeMedia`,`image`) ';
  $sql2 .= "VALUES (NULL ,:NOMIMG , :TYPEIMG, :IMAGE)";

  $sql3 = 'INSERT INTO CONTENIR (`idMedia`, `idPost`)';
  $sql3 .= 'VALUES (:IDMEDIA,:IDPOST);';

  if ($ps == null && $ps2 == null) {
    $ps = dbConn()->prepare($sql);
    $ps2 = dbConn()->prepare($sql2);
    $ps3 = dbConn()()->prepare($sql3);
  }
  $answer=false;
  try {
    $ps->bindParam(':COMM', $comm, PDO::PARAM_STR);
    $ps->bindParam(':DATEPOST', $date, PDO::PARAM_STR);
    $answer = $ps->execute();

    $ps2->bindParam(':NOMIMG',$imgName);
    $ps2->bindParam(':NOMIMG',$imgType, PDO::PARAM_STR);
    $ps2->bindParam(':IMAGE',$imgContent);
    $answer .= $ps2->execute();

    $idPost = "SELECT * FROM post ORDER BY idPost DESC LIMIT 0, 1";
    $idPost = dbConn()->exec($idPost);
    $idMedia = "SELECT * FROM media ORDER BY idMedia DESC LIMIT 0, 1";
    $idMedia = dbConn()->exec($idMedia);
    $ps3->bindParam(':IDMEDIA', $idMedia);
    $ps3->bindParam(':IDPOST',$idPost);
    $answer .= $ps3->execute();

    if($answer){
      $_SESSION['messagePost'] = "Nouveau post publié";
      $echo ="<div class='row'>";
      $echo.="  <div class='col-sm-12'>";
      $echo.="    <div class='panel panel-default text-left'>";
      $echo.="      <div class='panel-body'>";
      $echo.="        <p contenteditable='true'>Status: Feeling Blue</p>";
      $echo.="        <button type='button' class='btn btn-default btn-sm'>";
      $echo.="          <span class='glyphicon glyphicon-thumbs-up'></span> Like";
      $echo .="<img src='".$imgContent."' class='img-circle' height='55' width='55'>";
      $echo.="        </button>";     
      $echo.="      </div>";
      $echo.="    </div>";
      $echo.="  </div>";
      $echo.="</div>";
    }else{
      $_SESSION['messagePost'] = "Echec lors de la publication";
    }

  } catch (PDOException $e) {
    echo $e->getMessage();
  }
  return $echo;
}

function function_alert($message) {
      
    // Display the alert box 
    echo "<script>alert('$message');</script>";
}

?>