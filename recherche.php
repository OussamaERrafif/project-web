<?php
//----------------------------------------------------------------------------------------------------------
// Recherche
$contenu .= '<form method="post" action="">';
$contenu .= '<div class="form-group">';
$contenu .= '<label for="recherche">Rechercher un livre :</label>';
$contenu .= '<input type="text" name="recherche" id="recherche" class="form-control" placeholder="Recherche">';
$contenu .= '<input type="submit" value="Rechercher" class="btn btn-default">';
$contenu .= '</div>';
$contenu .= '</form>';

if(isset($_POST['recherche']) && !empty($_POST['recherche'])) {
    $recherche = $_POST['recherche'];
    $resultat = $mysqli->query("SELECT * FROM livre WHERE titre LIKE '%$recherche%' OR auteur LIKE '%$recherche%' OR maison_edition LIKE '%$recherche%'");
    $contenu .= '<h3>Résultats de la recherche :</h3>';
    $contenu .= '<table class="table">';
    $contenu .= '<tr>';
    while($affichage_champs_abonne = $resultat->fetch_field()) {
        $contenu .= '<th>' . $affichage_champs_abonne->name . '</th>';
    }
    $contenu .= '<th>modification</th>';
    $contenu .= '<th>suppression</th>';
    $contenu .= '</tr>';
    while($affichage_abonne = $resultat->fetch_assoc()) {
        $contenu .= '<tr>';
        foreach($affichage_abonne as $indice => $valeur ) {
            $contenu .= '<td>' . $valeur . '</td>';
        }
        $contenu .= '<td><a href="?page=livre&action=modification&id_livre='.$affichage_abonne['id_livre'].'"><span class="glyphicon glyphicon-pencil"></span></a></td>';
        $contenu .= '<td><a href="?page=livre&action=suppression&id_livre='.$affichage_abonne['id_livre'].'"><span class="glyphicon glyphicon-remove"></span></a></td>';
        $contenu .= '</tr>';
    }
    $contenu .= '</table>';
}