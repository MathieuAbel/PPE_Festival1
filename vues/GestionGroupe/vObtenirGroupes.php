<?php

include("_debut.inc.php");
require_once(__DIR__."/../../includes/fonctions.inc.php");

// AFFICHER L'ENSEMBLE DES ÉTABLISSEMENTS
// CETTE PAGE CONTIENT UN TABLEAU CONSTITUÉ D'1 LIGNE D'EN-TÊTE ET D'1 LIGNE PAR
// ÉTABLISSEMENT
echo "
<br>
<table width='55%' cellspacing='0' cellpadding='0' class='tabNonQuadrille'>

   <tr class='enTeteTabNonQuad'>
      <td colspan='4'><strong>Groupes</strong></td>
   </tr>";

// BOUCLE SUR LES ÉTABLISSEMENTS

for ($i=0; $i<count($arrayGroupe); $i++) {
    $unGroupe = $arrayGroupe[$i];
    
    echo "
		<tr class='ligneTabNonQuad'>
         <td width='52%'>".$unGroupe->getNom()."</td>
         
         <td width='16%' align='center'> 
         <a href='cGestionGroupes.php?action=detailGroupe&id=".$unGroupe->getId()."'>
         Voir détail</a></td>
         
         <td width='16%' align='center'> 
         <a href='cGestionGroupes.php?action=demanderModifierGroupe&id=".$unGroupe->getId()."'>
         Modifier</a></td>";

        echo "
            <td width='16%' align='center'> 
            <a href='cGestionGroupes.php?action=demanderSupprimerGroupe&id=".$unGroupe->getId()."'>
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
