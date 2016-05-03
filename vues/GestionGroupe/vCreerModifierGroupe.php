<?php

include("_debut.inc.php");
require_once(__DIR__."/../../includes/fonctions.inc.php");

// CRÉER OU MODIFIER UN GROUPE 
// S'il s'agit d'une création et qu'on ne "vient" pas de ce formulaire (on 
// "vient" de ce formulaire uniquement s'il y avait une erreur), il faut définir 
// les champs à vide sinon on affichera les valeurs précédemment saisies
if ($action == 'demanderCreerGroupes') {
    
    $id = '';
    $nom = '';
    $identiteResponsable = '';
    $adressePostale = '';
    $nombrePersonnes = '';
    $nomPays = '';
    $hebergement = 'O';
}

// S'il s'agit d'une modification et qu'on ne "vient" pas de ce formulaire, il
// faut récupérer les données sinon on affichera les valeurs précédemment 
// saisies
if ($action == 'demanderModifierGroupe') {
    
    $nom = $lgGroupe->getNom();
    $identiteResponsable = $lgGroupe->getIdentiteResponsable();
    $adressePostale = $lgGroupe->getAdressePostale();
    $nombrePersonnes= $lgGroupe->getNombrePersonnes();
    $nomPays = $lgGroupe->getNomPays();
    $hebergement = $lgGroupe->getHebergement();
  
}

// Initialisations en fonction du mode (création ou modification) 
if ($action == 'demanderCreerGroupes' || $action == 'validerCreerGroupe') {
    $creation = true;
    $message = "Nouveau Groupe";  // Alimentation du message de l'en-tête
    $action = "validerCreerGroupe";
} else {
    $creation = false;
    $message = "$nom ($id)";            // Alimentation du message de l'en-tête
    $action = "validerModifierGroupe";
}

// Déclaration du tableau de l'hebergement
$tabHebergement = array("O", "N");

echo "
<form method='POST' action='cGestionGroupes.php?'>
   <input type='hidden' value='$action' name='action'>
   <br>
   <table width='85%' cellspacing='0' cellpadding='0' class='tabNonQuadrille'>
   
      <tr class='enTeteTabNonQuad'>
         <td colspan='3'><strong>$message</strong></td>
      </tr>";

// En cas de création, l'id est accessible sinon l'id est dans un champ
// caché               
if ($creation) {
    // On utilise les guillemets comme délimiteur de champ dans l'echo afin
    // de ne pas perdre les éventuelles quotes saisies (même si les quotes
    // ne sont pas acceptées dans l'id, on a le souci de ré-afficher l'id
    // tel qu'il a été saisi) 
    echo '
         <tr class="ligneTabNonQuad">
            <td> Id*: </td>
            <td><input type="text" value="' . $id . '" name="id" size ="10" 
            maxlength="8"></td>
         </tr>';
} else {
    echo "
         <tr>
            <td><input type='hidden' value='$id' name='id'></td><td></td>
         </tr>";
}
echo '
      <tr class="ligneTabNonQuad">
         <td> Nom*: </td>
         <td><input type="text" value="' . $nom . '" name="nom" size="50" 
         maxlength="45"></td>
      </tr>
      <tr class="ligneTabNonQuad">
         <td> Identité responsable: </td>
         <td><input type="text" value="' . $identiteResponsable . '" name="identiteResponsable" 
         size="50" maxlength="45"></td>
      </tr>
      <tr class="ligneTabNonQuad">
         <td> adressePostale: </td>
         <td><input type="text" value="' . $adressePostale . '" name="adressePostale" 
         size="40" maxlength="35"></td>
      </tr>
      <tr class="ligneTabNonQuad">
         <td> Nombre de personnes*: </td>
         <td><input type="text" value="' . $nombrePersonnes . '" name="nombrePersonnes" 
         size="7" maxlength="5"></td>
      </tr>
      <tr class="ligneTabNonQuad">
         <td> Nom pays*: </td>
         <td><input type="text" value="' . $nomPays . '" name="nomPays" size="40" 
         maxlength="35"></td>
      </tr>
         </td>
         </tr>
         <tr class=\'ligneTabNonQuad\'>
            <td colspan=\'2\' ><strong>Hebergement:</strong></td>
            
         </tr>
         <tr class=\'ligneTabNonQuad\'>
            <td>  </td>
            <td> <select name=\'hebergement\'>';
for ($i = 0; $i < 2; $i = $i + 1) {
    if ($tabHebergement[$i] == $hebergement) {
        echo "<option selected>$tabHebergement[$i]</option>";
    } else {
        echo "<option>$tabHebergement[$i]</option>";
    }
}
      
     
      
   '</table>';

echo "
   <table align='center' cellspacing='15' cellpadding='0'>
      <tr>
         <td align='right'><input type='submit' value='Valider' name='valider'>
         </td>
         <td align='left'><input type='reset' value='Annuler' name='annuler'>
         </td>
      </tr>
   </table>
   <a href='cGestionGroupes.php'>Retour</a>
</form>";

include("_fin.inc.php");
