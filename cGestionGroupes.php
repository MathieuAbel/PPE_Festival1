<?php

include("_gestionErreurs.inc.php");
include("gestionDonnees/_connexion.inc.php");
include("gestionDonnees/_gestionBaseFonctionsCommunes.inc.php");


// 1ère étape (donc pas d'action choisie) : affichage du tableau des 
// établissements 
if (!isset($_REQUEST['action'])) {
    $_REQUEST['action'] = 'initial';
}

$action = $_REQUEST['action'];

// Aiguillage selon l'étape
switch ($action) {
    case 'initial' :
        include("vues/GestionGroupe/vObtenirGroupes.php");
        break;

    case 'detailGroupe':
        $id = $_REQUEST['id'];
        include("vues/GestionGroupe/vObtenirDetailGroupe.php");
        break;

    case 'demanderSupprimerGroupe':
        $id = $_REQUEST['id'];
        include("vues/GestionGroupe/vSupprimerGroupe.php");
        break;

    case 'demanderCreerGroupes':
        include("vues/GestionGroupe/vCreerModifierGroupe.php");
        break;

    case 'demanderModifierGroupe':
        $id = $_REQUEST['id'];
        include("vues/GestionGroupe/vCreerModifierGroupe.php");
        break;

    case 'validerSupprimerGroupe':
        $id = $_REQUEST['id'];
        supprimerGroupe($connexion, $id);
        include("vues/GestionGroupe/vObtenirGroupes.php");
        break;

    case 'validerCreerGroupe':case 'validerModifierGroupe':
        $id = $_REQUEST ['id'];
        $nom = $_REQUEST['nom'];
        $identiteResponsable = $_REQUEST['identiteResponsable'];
        $adressePostale = $_REQUEST['adressePostale'];
        $nombrePersonnes= $_REQUEST['nombrePersonnes'];
        $nomPays = $_REQUEST['nomPays'];
        $hebergement = $_REQUEST['hebergement'];

        if ($action == 'validerCreerGroupe') {
            verifierDonneesGroupeC($connexion, $id, $nom, $identiteResponsable, $adressePostale, $nombrePersonnes, $nomPays, $hebergement);
            if (nbErreurs() == 0) {
                creerModifierGroupe($connexion, 'C', $id, $nom, $identiteResponsable, $adressePostale, $nombrePersonnes, $nomPays, $hebergement);
                include("vues/GestionGroupe/vObtenirGroupes.php");
            } else {
                include("vues/GestionGroupe/vCreerModifierGroupe.php");
            }
        } else {
            verifierDonneesGroupeM($connexion, $id, $nom, $identiteResponsable, $adressePostale, $nombrePersonnes, $nomPays, $hebergement);
            if (nbErreurs() == 0) {
                creerModifierGroupe($connexion, 'M', $id, $nom, $identiteResponsable, $adressePostale, $nombrePersonnes, $nomPays, $hebergement);
                include("vues/GestionGroupe/vObtenirGroupes.php");
            } else {
                include("vues/GestionGroupe/vCreerModifierGroupe.php");
            }
        }
        break;
}

// Fermeture de la connexion au serveur MySql
$connexion = null;

function verifierDonneesGroupeC($connexion, $id, $nom, $identiteResponsable, $adressePostale, $nombrePersonnes, $nomPays, $hebergement) {
    if ($id == "" || $nom == "" || $nombrePersonnes == "" || $nomPays == "" || $hebergement == "") {
        ajouterErreur('Chaque champ suivi du caractère * est obligatoire');
    }
    if ($id != "") {
        // Si l'id est constitué d'autres caractères que de lettres non accentuées 
        // et de chiffres, une erreur est générée
        if (!estChiffresOuEtLettres($id)) {
            ajouterErreur
                    ("L'identifiant doit comporter uniquement des lettres non accentuées et des chiffres");
        } else {
            if (estUnIdGroupe($connexion, $id)) {
                ajouterErreur("L'établissement $id existe déjà");
            }
        }
    }
    if ($nom != "" && estUnNomGroupe($connexion, 'C', $id, $nom)) {
        ajouterErreur("L'établissement $nom existe déjà");
    }
    
}

function verifierDonneesGroupeM($connexion, $id, $nom, $identiteResponsable, $adressePostale, $nombrePersonnes, $nomPays, $hebergement) {
    if ($id == "" || $nom == "" || $nombrePersonnes == "" || $nomPays == "" || $hebergement == "") {
        ajouterErreur('Chaque champ suivi du caractère * est obligatoire');
    }
    if ($nom != "" && estUnNomGroupe($connexion, 'M', $id, $nom)) {
        ajouterErreur("L'établissement $nom existe déjà");
    }
    
}




?>

