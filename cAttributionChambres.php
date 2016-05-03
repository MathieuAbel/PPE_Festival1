<?php

use modele\Connexion;
use modele\dao\AttribDAO;
use modele\metier\Attribution;

require_once "_gestionErreurs.inc.php";
require_once "./includes/fonctions.inc.php";

// 1ère étape (donc pas d'action choisie) : affichage du tableau des 
// attributions en lecture seule
if (!isset($_REQUEST['action'])) {
    $_REQUEST['action'] = 'initial';
}

$action = $_REQUEST['action'];

Connexion::connecter();

// Aiguillage selon l'étape
switch ($action) {
    case 'initial':
        $rsEtab = modele\dao\AttribDAO::obtenirIdNomEtablissementsOffrantChambres();
        $nbTypesChambres = modele\dao\AttribDAO::obtenirNbTypesChambres();
        $arrayAttribution = AttribDAO::getAll();
        include("vues/AttributionChambres/vConsulterAttributionChambres.php");
        break;

    case 'demanderModifierAttrib':
        redondance();
        break;

    case 'donnerNbChambres':
        $idEtab = $_REQUEST['idEtab'];
        $idTypeChambre = $_REQUEST['idTypeChambre'];
        $idGroupe = $_REQUEST['idGroupe'];
        $nbChambres = $_REQUEST['nbChambres'];
        AttribDAO::getOneByIdCompo($idEtab, $idTypeChambre, $idGroupe);
//        $idGroupe = AttribDAO::obtenirNomGroupe($idGroupe);
        include("vues/AttributionChambres/vDonnerNbChambresAttributionChambres.php");
        break;

    case 'validerModifierAttrib':
        $idEtab = $_REQUEST['idEtab'];
        $idTypeChambre = $_REQUEST['idTypeChambre'];
        $idGroupe = $_REQUEST['idGroupe'];
        $nbChambres = $_REQUEST['nbChambres'];
        AttribDAO::modifierAttribChamb($idEtab, $idTypeChambre, $idGroupe, $nbChambres);
        $idTypeChambre = modele\dao\AttribDAO::obtenirTypesChambres();
        $nomGroupe = modele\dao\AttribDAO::obtenirGroupesEtab($idEtab);
        redondance();
        break;
}
// Fermeture de la connexion au serveur MySql
$connexion = null;

function redondance() {
    $rsEtab = \modele\dao\AttribDAO::obtenirNomEtablissementsOffrantChambres();
    $rsIdEtab = \modele\dao\AttribDAO::obtenirIdEtablissementsOffrantChambres();
    $rsTypeChambre = \modele\dao\AttribDAO::obtenirIdTypesChambres();
    $nbTypesChambres = \modele\dao\AttribDAO::obtenirNbTypesChambres();
    $rsGroupe = \modele\dao\AttribDAO::obtenirIdNomGroupesAHeberger();
    $nbEtabOffrantChambres = \modele\dao\AttribDAO::obtenirNbEtabOffrantChambres();
    include("vues/AttributionChambres/vModifierAttributionChambres.php");
}
