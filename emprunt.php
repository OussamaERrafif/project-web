<?php
//----------------------------------------------------------------------------------------------------------
// Enregistrement :
if($_POST)
{
	$_POST['date_sortie'] = str_replace('/', '-', $_POST['date_sortie']);
	$_POST['date_rendu'] = str_replace('/', '-', $_POST['date_rendu']);
	if(isset($_POST['id_emprunt'])) $id_emprunt = $_POST['id_emprunt']; else $id_emprunt = ''; 

	    // Vérifier le nombre d'emprunts actuels de l'abonné
		$abonneId = $_POST['id_abonne'];
		$resultat = $mysqli->query("SELECT COUNT(*) AS count FROM emprunt WHERE id_abonne = $abonneId");
		$row = $resultat->fetch_assoc();
		$empruntsActuels = $row['count'];
	
		// Vérifier la durée de l'emprunt
		$dateSortie = strtotime($_POST['date_sortie']);
		$dateRendu = strtotime($_POST['date_rendu']);
		$dureeEmprunt = ($dateRendu - $dateSortie) / (60 * 60 * 24); // Calculer la durée en jours
		
		if ($empruntsActuels >= 5 || $dureeEmprunt > 30) {
			header('location:?page=emprunt&enregistrement=erreur');
			exit(); // Arrêter l'exécution du script
		}
	
		$resultat = $mysqli->query("REPLACE INTO emprunt (id_emprunt, id_livre, id_abonne, date_sortie, date_rendu) VALUES ('$id_emprunt', '$_POST[id_livre]', '$_POST[id_abonne]', '$_POST[date_sortie]', '$_POST[date_rendu]')");
		if (!empty($mysqli->error)) header('location:?page=emprunt&enregistrement=erreur');
		else header('location:?page=emprunt&enregistrement=valide');
}


//----------------------------------------------------------------------------------------------------------
// Suppression
if(isset($_GET['action']) && $_GET['action'] == 'suppression')
{
	$resultat = $mysqli->query("DELETE FROM emprunt WHERE id_emprunt=$_GET[id_emprunt]");
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
	$resultat = $mysqli->query("SELECT * FROM emprunt");
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
		$contenu .= '<td><a href="?page=emprunt&action=modification&id_emprunt='.$affichage_abonne['id_emprunt'].'"><span class="glyphicon glyphicon-pencil"></span></a></td>';
		$contenu .= '<td><a href="?page=emprunt&action=suppression&id_emprunt='.$affichage_abonne['id_emprunt'].'"><span class="glyphicon glyphicon-remove"></span></a></td>';
		$contenu .= '</tr>';
	}
	$contenu .= '</table>';
//----------------------------------------------------------------------------------------------------------
// Ajout/Modif
$modif = false;
$contenu .= '<form method="post" action="">	<div class="form-group">';
if(isset($_GET['action']) && $_GET['action'] == 'modification')
{
	$modif = true;
	$resultat = $mysqli->query("SELECT * FROM emprunt WHERE id_emprunt = $_GET[id_emprunt]");
	$emprunt = $resultat->fetch_assoc();
	$contenu .= '<input type="hidden" name="id_emprunt" value="' . $emprunt['id_emprunt'] . '">'; 
}
	$contenu .= '<label for="prenom">Abonne</label><br>	
		<select name="id_abonne">';
		$resultat = $mysqli->query("SELECT * FROM abonne");
		while($abonnes = $resultat->fetch_assoc())
		{ 
			$contenu .= "<option value=\"$abonnes[id_abonne]\"";
			if($modif && $abonnes['id_abonne'] == $emprunt['id_abonne']) $contenu .= ' selected';
			$contenu .= ">$abonnes[id_abonne] - $abonnes[prenom]</option>"; 
		}
		$contenu .= '</select><br><br>
		
	<label for="livre">Livre</label><br>
	<select name="id_livre">';
	$resultat = $mysqli->query("SELECT * FROM livre");
	while($livres = $resultat->fetch_assoc())
	{ 
		$contenu .= "<option value=\"$livres[id_livre]\"";
		if($modif && $livres['id_livre'] == $emprunt['id_livre']) $contenu .= ' selected';
		$contenu .= ">$livres[id_livre] -  $livres[auteur]  | $livres[titre]</option>"; 
	}
	$contenu .= '</select><br><br>';
	
	$contenu .= '
	<label for="dateSortie">Date Sortie</label><br>
	<input type="date" name="date_sortie" id="dateSortie" class="form-control date"';
	if($modif) $contenu .= " value=\"$emprunt[date_sortie]\"";
	$contenu .= '><br><br>';
	
	$contenu .= '<br>
	<label for="dateRendu">Date Rendu</label><br>
	<input type="date" name="date_rendu" id="dateRendu" class="form-control date"';
	if($modif) $contenu .= " value=\"$emprunt[date_rendu]\"";
	$contenu .= '><br><br>';
	
	$contenu .= '<input type="submit" value="';
		if($modif) $contenu .= 'Modification';
		else $contenu .= 'Ajouter';
	$contenu .= '" class="btn btn-default">
</div>
</form>';


