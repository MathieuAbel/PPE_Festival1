<?php

include("_debut.inc.php");
require_once(__DIR__."/../../includes/fonctions.inc.php");

// SUPPRIMER LE GROUPE SÉLECTIONNÉ

echo "
<br><center>Voulez-vous vraiment supprimer le groupe ".$lgGroupe->getNom()." ?
<h3><br>
<a href='cGestionGroupes.php?action=validerSupprimerGroupe&id=".$lgGroupe->getId()."'>Oui</a>
&nbsp; &nbsp; &nbsp; &nbsp;
<a href='cGestionGroupes.php?'>Non</a></h3>
</center>";

include("_fin.inc.php");

