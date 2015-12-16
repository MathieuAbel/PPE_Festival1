<?php

include("_debut.inc.php");

// SUPPRIMER LE GROUPE SÉLECTIONNÉ

$id = $_REQUEST['id'];  // Non obligatoire mais plus propre
$lgGroupe = obtenirDetailGroupe($connexion, $id);
$nom = $lgGroupe['nom'];
echo "
<br><center>Voulez-vous vraiment supprimer le groupe $nom ?
<h3><br>
<a href='cGestionGroupes.php?action=validerSupprimerGroupe&id=$id'>Oui</a>
&nbsp; &nbsp; &nbsp; &nbsp;
<a href='cGestionGroupes.php?'>Non</a></h3>
</center>";

include("_fin.inc.php");

