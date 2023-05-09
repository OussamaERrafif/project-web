<?php
//----------------------------------------------------------------------------------------------------------
// Enregistrement :
if($_POST)
{
	if(isset($_POST['id_livre'])) $id_livre = $_POST['id_livre']; else $id_livre = ''; 
	$resultat = $mysqli->query("REPLACE INTO livre (id_livre, titre,auteur,maison_edition,nb_page,nb_exemplaire) VALUES ('$id_livre', '$_POST[titre]', '$_POST[auteur]','$_POST[maison_edition]','$_POST[nb_page]','$_POST[nb_exemplaire]')");
	if(!empty($mysqli->error)) header('location:?page=livre&enregistrement=erreur');
	else  header('location:?page=livre&enregistrement=valide');
}
//----------------------------------------------------------------------------------------------------------
// Suppression
if(isset($_GET['action']) && $_GET['action'] == 'suppression')
{
	$resultat = $mysqli->query("DELETE FROM livre WHERE id_livre=$_GET[id_livre]");
	if(!empty($mysqli->error)) $contenu .= $suppressionErreur;
	else $contenu .= $suppressionValide;
	$_GET['action'] = '';
}
//----------------------------------------------------------------------------------------------------------
// Message
if(isset($_GET['enregistrement']))
{
	if($_GET['enregistrement'] == 'valide')	 $contenu .= $enregistrementValide;
	else $contenu .= $enregistrementErreur;
}
//----------------------------------------------------------------------------------------------------------
// Affichage
	$resultat = $mysqli->query("SELECT * FROM livre");
	$contenu .= '<table class="table">';
	$contenu .= '<tr>';
	while($affichage_champs_abonne = $resultat->fetch_field())
	{
		$contenu .= '<th>' . $affichage_champs_abonne->name . '</th>';
	}
	$contenu .= '<th>modification</th>';
	$contenu .= '<th>suppression</th>';
	$contenu .= '</tr>';
	while($affichage_abonne = $resultat->fetch_assoc())
	{
		$contenu .= '<tr>';
		foreach($affichage_abonne as $indice => $valeur )
		{
			$contenu .= '<td>' . $valeur . '</td>';
		}
		$contenu .= '<td><a href="?page=livre&action=modification&id_livre='.$affichage_abonne['id_livre'].'"><span class="glyphicon glyphicon-pencil"></span></a></td>';
		$contenu .= '<td><a href="?page=livre&action=suppression&id_livre='.$affichage_abonne['id_livre'].'"><span class="glyphicon glyphicon-remove"></span></a></td>';
		$contenu .= '</tr>';
	}
	$contenu .= '</table>';
//----------------------------------------------------------------------------------------------------------
// Ajout/Modif
// Ajout/Modif
$modif = false;
$contenu .= '<form method="post" action="">
 <div class="form-group">';
if(isset($_GET['action']) && $_GET['action'] == 'modification')
{
	$modif = true;
	$resultat = $mysqli->query("SELECT * FROM livre WHERE id_livre = $_GET[id_livre]");
	$livre = $resultat->fetch_assoc();
	$contenu .= '<input type="hidden" name="id_livre" value="' . $livre['id_livre'] . '">'; 
}
$contenu .= '<label for="titre">Titre</label>
	<input type="text" name="titre" id="titre" class="form-control" placeholder="titre"';
	if($modif) $contenu .= " value=\"$livre[titre]\"";
	$contenu .= '><br>';
	
$contenu .= '<label for="auteur">Auteur</label>
	<input type="text" name="auteur" id="auteur" class="form-control" placeholder="auteur"';
	if($modif) $contenu .= " value=\"$livre[auteur]\"";
	$contenu .= '><br>';
$contenu .= '<label for="maison_edition">Maison Edition</label>
	<input type="text" name="maison_edition" id="maison_edition" class="form-control" placeholder="Maison Edition"';
	if($modif) $contenu .= " value=\"$livre[maison_edition]\"";
	$contenu .= '><br>';
$contenu .= '<label for="titre">Nombre page</label>
	<input type="text" name="nb_page" id="nb_page" class="form-control" placeholder="Nombre page"';
	if($modif) $contenu .= " value=\"$livre[nb_page]\"";
	$contenu .= '><br>';
$contenu .= '<label for="titre">Nombre exemplaire</label>
	<input type="text" name="nb_exemplaire" id="titre" class="form-control" placeholder="Nombre exemplaire"';
	if($modif) $contenu .= " value=\"$livre[nb_exemplaire]\"";
$contenu .= '><br>';
$contenu .= '<input type="submit" value="';
	if($modif) $contenu .= 'Modification';
	else $contenu .= 'Ajouter';
$contenu .= '" class="btn btn-default">
</div>
</form>';

