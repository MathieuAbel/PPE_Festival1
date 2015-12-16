<?php

include("_debut.inc.php");

use modele\dao\GroupeDAO;
// OBTENIR LE DÉTAIL DE L'ÉTABLISSEMENT SÉLECTIONNÉ

$lgGroupe = obtenirDetailGroupe($connexion, $id);

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
      <td> nom: </td>
      <td>$nom</td>
   </tr>
   <tr class='ligneTabNonQuad'>
      <td> identite responsable: </td>
      <td>$identiteResponsable</td>
   </tr>
   <tr class='ligneTabNonQuad'>
      <td> adresse postale: </td>
      <td>$adressePostale</td>
   </tr>
   <tr class='ligneTabNonQuad'>
      <td> nombre personnes: </td>
      <td>$nombrePersonnes</td>
   </tr>
   <tr class='ligneTabNonQuad'>
      <td> nom pays: </td>
      <td>$nomPays</td>
   </tr>
   <tr class='ligneTabNonQuad'>
      <td> hebergement: </td>
      <td>$hebergement</td>
   </tr>
   
</table>
<br>
<a href='cGestionGroupes.php'>Retour</a>";

include("_fin.inc.php");

