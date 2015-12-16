<?php

include("_debut.inc.php");
use modele\dao\EtabDAO;
require_once(__DIR__."/../../includes/fonctions.inc.php");
use modele\Connexion;

// AFFICHER L'ENSEMBLE DES ÉTABLISSEMENTS
// CETTE PAGE CONTIENT UN TABLEAU CONSTITUÉ D'1 LIGNE D'EN-TÊTE ET D'1 LIGNE PAR
// ÉTABLISSEMENT

echo "
<br>
<table width='55%' cellspacing='0' cellpadding='0' class='tabNonQuadrille'>

   <tr class='enTeteTabNonQuad'>
      <td colspan='4'><strong>Etablissements</strong></td>
   </tr>";

Connexion::connecter();
$arrayEtab = EtabDAO::getAll();
//$rsEtab = mysql_query($req, $connexion);

// BOUCLE SUR LES ÉTABLISSEMENTS
for ($i=0; $i<count($arrayEtab); $i++) {
    $unEtab = $arrayEtab[$i];    
    echo "
		<tr class='ligneTabNonQuad'>
         <td width='52%'>".$unEtab->getNom()."</td>
         
         <td width='16%' align='center'> 
         <a href='cGestionEtablissements.php?action=detailEtab&id=".$unEtab->getId()."'>
         Voir détail</a></td>
         
         <td width='16%' align='center'> 
         <a href='cGestionEtablissements.php?action=demanderModifierEtab&id=".$unEtab->getId()."'>
         Modifier</a></td>";

    // S'il existe déjà des attributions pour l'établissement, il faudra
    // d'abord les supprimer avant de pouvoir supprimer l'établissement
    if (!existeAttributionsEtab($connexion, $unEtab->getId())) {
        echo "
            <td width='16%' align='center'> 
            <a href='cGestionEtablissements.php?action=demanderSupprimerEtab&id=".$unEtab->getId()."'>
            Supprimer</a></td>";
    } else {
        echo "
            <td width='16%'>&nbsp; </td>";
    }
    echo "
      </tr>";
}
echo "
</table>
<br>
<a href='cGestionEtablissements.php?action=demanderCreerEtab'>
Création d'un établissement</a >";

include("_fin.inc.php");

Connexion::deconnecter();