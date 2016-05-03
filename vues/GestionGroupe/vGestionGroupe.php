<?php
include("_debut.inc.php");
// OBTENIR LE DÉTAIL DU GROUPE SÉLECTIONNÉ

$lgEtab = obtenirDetailGroupe($connexion, $id);

$id = $lgGroupe ['id'];
$nom = $lgGroupe['nom'];
$identiteResponsable = $lgGroupe['identiteResponsable'];
$adressePostale = $lgGroupe['adressePostale'];
$nombrePersonnes= $lgGroupe['nombrePersonnes'];
$nomPays = $lgGroupe['nomPays'];
$hebergement = $lgGroupe['hebergement'];

echo "
<br>
<table width='60%' cellspacing='0' cellpadding='0' class='tabNonQuadrille'>
   
   <tr class='enTeteTabNonQuad'>
      <td colspan='3'><strong>$nom</strong></td>
   </tr>
   <tr class='ligneTabNonQuad'>
      <td  width='20%'> Id: </td>
      <td>$id</td>
   </tr>
   <tr class='ligneTabNonQuad'>
      <td> Adresse: </td>
      <td>$identiteResponsable</td>
   </tr>
   <tr class='ligneTabNonQuad'>
      <td> Code postal: </td>
      <td>$adressePostale</td>
   </tr>
   <tr class='ligneTabNonQuad'>
      <td> Ville: </td>
      <td>$nombrePersonnes</td>
   </tr>
   <tr class='ligneTabNonQuad'>
      <td> Téléphone: </td>
      <td>$nomPays</td>
   </tr>
   <tr class='ligneTabNonQuad'>
      <td> E-mail: </td>
      <td>$hebergement</td>
   </tr>
   
</table>
<br>
<a href='cGestionGroupes.php'>Retour</a>";

include("_fin.inc.php");

