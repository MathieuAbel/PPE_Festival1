<?php

include("_debut.inc.php");
use modele\dao\EtabDAO;
require_once(__DIR__."/../../includes/fonctions.inc.php");
use modele\Connexion;

Connexion::connecter();
// SUPPRIMER L'ÉTABLISSEMENT SÉLECTIONNÉ

$id = $_REQUEST['id'];  // Non obligatoire mais plus propre
$lgEtab = EtabDAO::getOneById($id);
$nom = $lgEtab->getNom();
echo "
<br><center>Voulez-vous vraiment supprimer l'établissement ".$lgEtab->getNom()." ?
<h3><br>
<a href='./controleur/cGestionEtablissements.php?action=validerSupprimerEtab&id=".$lgEtab->getId()."'>Oui</a>
&nbsp; &nbsp; &nbsp; &nbsp;
<a href='./controleur/cGestionEtablissements.php?'>Non</a></h3>
</center>";

include("_fin.inc.php");
