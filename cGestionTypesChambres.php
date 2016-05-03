<?php

use modele\Connexion;
use modele\dao\TypeChambreDAO;
use modele\metier\TypeChambre;

include("_gestionErreurs.inc.php");
include("includes/fonctions.inc.php");

// 1ère étape (donc pas d'action choisie) : affichage de l'ensemble des types 
// de chambres
if (!isset($_REQUEST['action'])) {
    $_REQUEST['action'] = 'initial';
}

$action = $_REQUEST['action'];

Connexion::connecter();

// Aiguillage selon l'étape
switch ($action) {
    case 'initial':
        $arrayTypeChambre = TypeChambreDAO::getAll();
        include("vues/GestionTypesChambres/vObtenirTypesChambres.php");
        break;

    case 'demanderSupprimerTypeChambre':
        $id = $_REQUEST['id'];
        $lgTypeChambre = TypeChambreDAO::getOneById($id);
        include("vues/GestionTypesChambres/vSupprimerTypeChambre.php");
        break;

    case 'demanderCreerTypeChambre':
        include("vues/GestionTypesChambres/vCreerModifierTypeChambre.php");
        break;

    case 'demanderModifierTypeChambre':
        $id = $_REQUEST['id'];
        $lgTypeChambre = TypeChambreDAO::getOneById($id);
        include("vues/GestionTypesChambres/vCreerModifierTypeChambre.php");
        break;

    case 'validerSupprimerTypeChambre':
        $id = $_REQUEST['id'];
        TypeChambreDAO::delete($id);
        $arrayTypeChambre = TypeChambreDAO::getAll();
        include("vues/GestionTypesChambres/vObtenirTypesChambres.php");
        break;

    case 'validerCreerTypeChambre':
        $id = $_REQUEST['id'];
        $libelle = $_REQUEST['libelle'];
        TypeChambreDAO::verifierDonneesTypeChambreC($id, $libelle);
        if (nbErreurs() == 0) {
            $objetTypeChambre = new TypeChambre($id, $libelle);
            TypeChambreDAO::insert($objetTypeChambre);
            $arrayTypeChambre = TypeChambreDAO::getAll();
            include("vues/GestionTypesChambres/vObtenirTypesChambres.php");
        } else {
            include("vues/GestionTypesChambres/vCreerModifierTypeChambre.php");
        }
        break;

    case 'validerModifierTypeChambre':
        $id = $_REQUEST['id'];
        $libelle = $_REQUEST['libelle'];
        TypeChambreDAO::verifierDonneesTypeChambreM($id, $libelle);
        if (nbErreurs() == 0) {
            $objetTypeChambre = new TypeChambre($id, $libelle);
            TypeChambreDAO::update($id, $objetTypeChambre);
            $arrayTypeChambre = TypeChambreDAO::getAll();
            include("vues/GestionTypesChambres/vObtenirTypesChambres.php");
        } else {
            include("vues/GestionTypesChambres/vCreerModifierTypeChambre.php");
        }
        break;
}
