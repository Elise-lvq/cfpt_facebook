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

function addMedia($imgName,$imgType,$imgContent)
{
  try {  
      $bd = dbConn();
      $requete = $bd->prepare("INSERT INTO media (`idMedia`, `nomFichierMedia`,`typeMedia`,`image`) VALUES (NULL ,:NOMIMG , :TYPEIMG, :IMAGE);");
      
      $requete->execute(
          array(
              ':NOMIMG' => $imgName,
              ':TYPEIMG' => $imgType,
              ':IMAGE' => $imgContent
          )
      );
      function_alert("Media bien ajouté");
  } catch (Exception $e) {
      echo 'Exception reçue : ',  $e->getMessage(), "\n";
  }
}

function findPost(){
  try{
    $idPost = dbConn()->prepare("SELECT idPost FROM post ORDER BY idPost DESC LIMIT 0, 1");
    $idPost->execute();
    function_alert("Post id trouvé");
    return $idPost;
  } catch (Exception $e) {
      echo 'Exception reçue : ',  $e->getMessage(), "\n";
  }
  
}

function findMedia(){
  try{
    $idMedia =dbConn()->prepare( "SELECT idMedia FROM media ORDER BY idMedia DESC LIMIT 0, 1");
    $idMedia ->execute();
    function_alert("Media id trouvé");
    return $idMedia;
  } catch (Exception $e) {
      echo 'Exception reçue : ',  $e->getMessage(), "\n";
  }
  
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
    function_alert("Contenir bien ajouté");
} catch (Exception $e) {
    echo 'Exception reçue : ',  $e->getMessage(), "\n";
}
}

function addPost($comm)
{
  static $ps = null; 

  $sql = 'INSERT INTO post (`idPost`, `commentaires`,`datePost`) ';
  $sql .= "VALUES (NULL ,:COMM, :DATEPOST)";

  if ($ps == null) {
    $ps = dbConn()->prepare($sql);
  }
  try {
    $date = date("y-m-d");
    $ps->execute(
      array(
          ':COMM' => $comm,
          ':DATEPOST' => $date
      )
  );

    
    

    $echo  = "null";

    
    function_alert("Nouveau post publié");
    $echo ="<div class='row'>";
    $echo.="  <div class='col-sm-12'>";
    $echo.="    <div class='panel panel-default text-left'>";
    $echo.="      <div class='panel-body'>";
    $echo.="        <p contenteditable='true'>Status: ".$comm."</p>";
    $echo.="        <button type='button' class='btn btn-default btn-sm'>";
    $echo.="          <span class='glyphicon glyphicon-thumbs-up'></span> Like";
    //$echo .="<img src='". ."' class='img-circle' height='55' width='55'>";
    $echo.="        </button>";     
    $echo.="      </div>";
    $echo.="    </div>";
    $echo.="  </div>";
    $echo.="</div>";
    

  } catch (Exception $e) {
    echo 'Exception reçue : ',  $e->getMessage(), "\n";
  }
  return $echo;
}

function function_alert($message) {
      
    // Display the alert box 
    echo "<script>alert('$message');</script>";
}



?>