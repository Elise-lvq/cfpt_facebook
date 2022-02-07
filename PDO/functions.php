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
 * Ajoute un nouvel utilisateur avec ses paramètres
 * @param mixed $mdp Mot de passe utilisateur
 * @param mixed $email Email utilisateur
 */
function createUser($img,$comm, $date)
{
  static $ps = null;
  $sql = 'INSERT INTO users (`idUser`, `mdp`,`email`) ';
  $sql .= "VALUES (NULL ,:MDP, :EMAIL)";
  if ($ps == null) {
    $ps = dbConn()->prepare($sql);
  }
  $answer=false;
  try {
    $ps->bindParam(':MDP', $mdp, PDO::PARAM_STR);
    $ps->bindParam(':EMAIL', $email, PDO::PARAM_STR);

    $answer = $ps->execute();
    if($answer){
      $_SESSION['messageCreateUser'] = "Nouvelle Utilisateur créer";
    }else{
      $_SESSION['messageCreateUser'] = "Echec lors de la création";
    }

  } catch (PDOException $e) {
    echo $e->getMessage();
  }
  return $answer;
}

?>