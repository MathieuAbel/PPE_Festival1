<?php

include("_debut.inc.php");
require_once(__DIR__."/../../includes/fonctions.inc.php");

echo "
<br>
<table width='60%' cellspacing='0' cellpadding='0' class='tabNonQuadrille'>
   
   <tr class='enTeteTabNonQuad'>
      <td colspan='3'><strong>".$lgGroupe->getNom()."</strong></td>
   </tr>
   <tr class='ligneTabNonQuad'>
      <td  width='20%'> Id: </td>
      <td>".$lgGroupe->getId()."</td>
   </tr>
   <tr class='ligneTabNonQuad'>
      <td> nom: </td>
      <td>".$lgGroupe->getNom()."</td>
   </tr>
   <tr class='ligneTabNonQuad'>
      <td> identite responsable: </td>
      <td>".$lgGroupe->getIdentiteResponsable()."</td>
   </tr>
   <tr class='ligneTabNonQuad'>
      <td> adresse postale: </td>
      <td>".$lgGroupe->getAdressePostale()."</td>
   </tr>
   <tr class='ligneTabNonQuad'>
      <td> nombre personnes: </td>
      <td>".$lgGroupe->getNombrePersonnes()."</td>
   </tr>
   <tr class='ligneTabNonQuad'>
      <td> nom pays: </td>
      <td>".$lgGroupe->getNomPays()."</td>
   </tr>
   <tr class='ligneTabNonQuad'>
      <td> hebergement: </td>
      <td>".$lgGroupe->getHebergement()."</td>
   </tr>
   
</table>
<br>
<a href='cGestionGroupes.php'>Retour</a>";

include("_fin.inc.php");

