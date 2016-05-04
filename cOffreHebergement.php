<?php

use modele\dao\OffreDAO;
use modele\dao\TypeChambreDAO;
use modele\dao\EtabDAO;
use modele\Connexion;

require_once "gestionDonnees/_connexion.inc.php";
require_once "gestionDonnees/_gestionBaseFonctionsCommunes.inc.php";

require_once "_gestionErreurs.inc.php";
require_once "./includes/fonctions.inc.php";

// 1ère étape (donc pas d'action choisie) : affichage du tableau des offres en 
// lecture seule
if (!isset($_REQUEST['action'])) {
    $_REQUEST['action'] = 'initial';
}

$action = $_REQUEST['action'];

// Aiguillage selon l'étape   
switch ($action) {
    case 'initial' :
        $nbEtab = OffreDAO::obtenirNbEtab();
        $nbTypesChambres = OffreDAO::obtenirNbTypesChambres();
        $arrayEtab = EtabDAO::getAll();
        $arrayTypeChambre = TypeChambreDAO::getAll();
        $unEtab = OffreDAO::obtenirIdNomEtablissements();

//        $rsTypeChambre = TypeChambreDAO::all();
        include("vues/OffreHebergement/vConsulterOffreHebergement.php");
        break;

    case 'demanderModifierOffre':

        $idEtab = $_REQUEST['idEtab'];
        $nbTypesChambres = OffreDAO::obtenirNbTypesChambres();
        $arrayEtab = EtabDAO::getAll();
        $arrayTypeChambre = TypeChambreDAO::getAll();
        $lgEtab = OffreDAO::obtenirDetailEtablissement($idEtab);
        include("vues/OffreHebergement/vModifierOffreHebergement.php");
        break;

    case 'validerModifierOffre':
        
        $idEtab = $_REQUEST['idEtab'];
        $idTypeChambre = $_REQUEST['idTypeChambre'];
        $nbChambres = $_REQUEST['nbChambres'];
        $nbLignes = $_REQUEST['nbLignes'];
        $arrayEtab = EtabDAO::getAll();
        $nbEtab = OffreDAO::obtenirNbEtab();
        $arrayTypeChambre = TypeChambreDAO::getAll();
        $nbTypesChambres = OffreDAO::obtenirNbTypesChambres();
        $lgEtab = OffreDAO::obtenirDetailEtablissement($idEtab);
        $err = false;
        for ($i = 0; $i < $nbLignes; $i = $i + 1) {
            // Si la valeur saisie n'est pas numérique ou est inférieure aux 
            // attributions déjà effectuées pour cet établissement et ce type de
            // chambre, la modification n'est pas effectuée
            $entier = estEntier($nbChambres[$i]);
            $modifCorrecte = OffreDAO::estModifOffreCorrecte($idEtab, $idTypeChambre[$i], $nbChambres[$i]);
            if (!$entier || !$modifCorrecte) {
                $err = true;
            } else {
                OffreDAO::modifierOffreHebergement($idEtab, $idTypeChambre[$i], $nbChambres[$i]);
            }
        }
        if ($err) {
            ajouterErreur("Valeurs non entières ou inférieures aux attributions effectuées");
            include("vues/OffreHebergement/vModifierOffreHebergement.php");
        } else {
            include("vues/OffreHebergement/vConsulterOffreHebergement.php");
        }
        break;
}

// Fermeture de la connexion au serveur MySql
$connexion = null;

