<?php

include("_debut.inc.php");

// AFFICHER L'ENSEMBLE DES ÉTABLISSEMENTS
// CETTE PAGE CONTIENT UN TABLEAU CONSTITUÉ D'1 LIGNE D'EN-TÊTE ET D'1 LIGNE PAR
// ÉTABLISSEMENT

echo "
<br>
<table width='55%' cellspacing='0' cellpadding='0' class='tabNonQuadrille'>

   <tr class='enTeteTabNonQuad'>
      <td colspan='4'><strong>Groupes</strong></td>
   </tr>";

$rsGroupe = obtenirIdNomGroupes($connexion);
//$rsGroupe = mysql_query($req, $connexion);

// BOUCLE SUR LES ÉTABLISSEMENTS
while ($lgGroupe = $rsGroupe->fetch(PDO::FETCH_ASSOC)) {
    $id = $lgGroupe['id'];
    $nom = $lgGroupe['nom'];
    echo "
		<tr class='ligneTabNonQuad'>
         <td width='52%'>$nom</td>
         
         <td width='16%' align='center'> 
         <a href='cGestionGroupes.php?action=detailGroupe&id=$id'>
         Voir détail</a></td>
         
         <td width='16%' align='center'> 
         <a href='cGestionGroupes.php?action=demanderModifierGroupe&id=$id'>
         Modifier</a></td>";

        echo "
            <td width='16%' align='center'> 
            <a href='cGestionGroupes.php?action=demanderSupprimerGroupe&id=$id'>
            Supprimer</a></td>";
    
    echo "
      </tr>";
}
echo "
</table>
<br>
<a href='cGestionGroupes.php?action=demanderCreerGroupes'>
Création d'un Groupe</a >";

include("_fin.inc.php");

