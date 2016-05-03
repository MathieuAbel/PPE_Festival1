<?php

use modele\Connexion;
use modele\dao\GroupeDAO;
use modele\metier\Groupe;

require_once "_gestionErreurs.inc.php";
require_once "./includes/fonctions.inc.php";

// 1ère étape (donc pas d'action choisie) : affichage du tableau des 
// établissements 
if (!isset($_REQUEST['action'])) {
    $_REQUEST['action'] = 'initial';
}

$action = $_REQUEST['action'];

Connexion::connecter();

// Aiguillage selon l'étape
switch ($action) {
    case 'initial' :
        $arrayGroupe = GroupeDAO::getAll();
        include("vues/GestionGroupe/vObtenirGroupes.php");
        break;

    case 'detailGroupe':
        $id = $_REQUEST['id'];
        $lgGroupe = GroupeDAO::getOneById($id);
        include("vues/GestionGroupe/vObtenirDetailGroupe.php");
        break;

    case 'demanderSupprimerGroupe':
        $id = $_REQUEST['id'];
        $lgGroupe = GroupeDAO::getOneById($id);
        include("vues/GestionGroupe/vSupprimerGroupe.php");
        break;

    case 'demanderCreerGroupes':
        include("vues/GestionGroupe/vCreerModifierGroupe.php");
        break;

    case 'demanderModifierGroupe':
        $id = $_REQUEST['id'];
        $lgGroupe = GroupeDAO::getOneById($id);
        include("vues/GestionGroupe/vCreerModifierGroupe.php");
        break;

    case 'validerSupprimerGroupe':
        $id = $_REQUEST['id'];
        GroupeDAO::delete($id);
        $arrayGroupe = GroupeDAO::getAll();
        include("vues/GestionGroupe/vObtenirGroupes.php");
        break;

    case 'validerCreerGroupe':case 'validerModifierGroupe':
        $id = $_REQUEST ['id'];
        $nom = $_REQUEST['nom'];
        $identiteResponsable = $_REQUEST['identiteResponsable'];
        $adressePostale = $_REQUEST['adressePostale'];
        $nombrePersonnes = $_REQUEST['nombrePersonnes'];
        $nomPays = $_REQUEST['nomPays'];
        $hebergement = $_REQUEST['hebergement'];

        if ($action == 'validerCreerGroupe') {
            GroupeDAO::verifierDonneesGroupeC($id, $nom, $nombrePersonnes, $nomPays, $hebergement);
            if (nbErreurs() == 0) {
                $objetMetier = new Groupe($id, $nom, $identiteResponsable, $adressePostale, $nombrePersonnes, $nomPays, $hebergement);
                GroupeDAO::insert($objetMetier);
                $arrayGroupe = GroupeDAO::getAll();
                include("vues/GestionGroupe/vObtenirGroupes.php");
            } else {
                include("vues/GestionGroupe/vCreerModifierGroupe.php");
            }
        } else {
            GroupeDAO::verifierDonneesGroupeM($id, $nom, $nombrePersonnes, $nomPays, $hebergement);
            if (nbErreurs() == 0) {
                $objetGroupe = new Groupe($id, $nom, $identiteResponsable, $adressePostale, $nombrePersonnes, $nomPays, $hebergement);
                GroupeDAO::update($id, $objetGroupe);
                $arrayGroupe = GroupeDAO::getAll();
                include("vues/GestionGroupe/vObtenirGroupes.php");
            } else {
                include("vues/GestionGroupe/vCreerModifierGroupe.php");
            }
        }
        break;
}
