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
function createUser($imgName,$imgType,$comm,$date)
{
  static $ps = null;
  static $ps2 = null;
  $sql = 'INSERT INTO post (`idPost`, `commentaires`,`datePost`) ';
  $sql2 = 'INSERT INTO media (`idMedia`, `nomFichierMedia`,`typeMedia`) ';
  $sql .= "VALUES (NULL ,:COMM, :DATEPOST)";
  $sql2 .= "VALUES (NULL ,:NOMIMG , :TYPEIMG)";
  if ($ps == null && $ps2 == null) {
    $ps = dbConn()->prepare($sql);
    $ps2 = dbConn()->prepare($sql2);
  }
  $answer=false;
  try {
    $ps->bindParam(':COMM', $comm, PDO::PARAM_STR);
    $ps->bindParam(':DATEPOST', $date, PDO::PARAM_STR);

    $ps2->bindParam(':NOMIMG',$imgName);
    $ps2->bindParam(':NOMIMG',$imgType, PDO::PARAM_STR);

    $answer = $ps->execute();
    $answer .= $ps2->execute();
    if($answer){
      $_SESSION['messagePost'] = "Nouveau post publié";
    }else{
      $_SESSION['messagePost'] = "Echec lors de la publication";
    }

  } catch (PDOException $e) {
    echo $e->getMessage();
  }
  return $answer;
}

function function_alert($message) {
      
    // Display the alert box 
    echo "<script>alert('$message');</script>";
}
?>