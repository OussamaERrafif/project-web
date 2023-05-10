<?php
// Connexion à la BDD.
$mysqli = new mysqli("localhost", "root", "", "bibliotheque");
if ($mysqli->connect_error) die('Un problème est survenu lors de la tentative de connexion à la BDD : ' . $mysqli->connect_error);
//------------------------------------------------------------------------------------------
// Initialisation variables.
$contenu = '';

$suppressionErreur = '<div class="alert alert-danger">La suppression n\'est pas autorisé tant qu\'il y a une relation associé dans la table <a href="?page=emprunt">emprunt</a></div>'; 
$suppressionValide = '<div class="alert alert-success">L\'élément a bien été supprimé</div>';

$enregistrementErreur = '<div class="alert alert-danger">L\'enregistrement n\'est pas autorisé tant qu\'il y a une relation associé dans la table <a href="?page=emprunt">emprunt</a></div>'; 
$enregistrementValide = '<div class="alert alert-success">L\'élément a bien été enregistré</div>';
//------------------------------------------------------------------------------------------