<?php

namespace modele\dao;

use modele\Connexion;
use modele\metier\Offre;
use modele\dao\DAO;
use \PDO;

class OffreDAO implements DAO {

    public static function enregistrementVersObjet($enreg) {
        $retour = new Offre($enreg['idEtab'], $enreg['idTypeChambre'], $enreg['nombreChambres']);
        return $retour;
    }

    public static function objetVersEnregistrement($objetMetier) {
        $retour = array(
            ':idEtab' => $objetMetier->getIdEtab(),
            ':idTypeChambre' => $objetMetier->getIdTypeChambre(),
            ':nombreChambres' => $objetMetier->getNombreChambres(),
        );
        return $retour;
    }

    public static function getAll() {
        $retour = null;
        // Requête textuelle
        $sql = "SELECT * FROM offre";
        try {
            // préparer la requête PDO
            $queryPrepare = Connexion::connecter()->prepare($sql);
            // exécuter la requête PDO
            if ($queryPrepare->execute()) {
                // si la requête réussit :
                // initialiser le tableau d'objets à retourner
                $retour = array();
                // pour chaque enregistrement retourné par la requête
                while ($enregistrement = $queryPrepare->fetch(PDO::FETCH_ASSOC)) {
                    // construir un objet métier correspondant
                    $unObjetMetier = self::enregistrementVersObjet($enregistrement);
                    // ajouter l'objet au tableau
                    $retour[] = $unObjetMetier;
                }
            }
        } catch (PDOException $e) {
            echo get_class() . ' - ' . __METHOD__ . ' : ' . $e->getMessage();
        }
        return $retour;
    }

    public static function getOneById($valeurClePrimaire) {
        
    }

    public static function getOneByIdCompo($idEtablissement, $idTypeChambre) {
        $retour = null;
        $valeursClePrimaire = array($idEtablissement, $idTypeChambre);
        try {
            // Requête textuelle paramétrée (le paramètre est symbolisé par un ?)
            $sql = "SELECT * FROM offre WHERE idEtab = ? AND idTypeChambre = ?";
            // préparer la requête PDO
            $queryPrepare = Connexion::getPdo()->prepare($sql);
            // exécuter la requête avec les valeurs des paramètres (il n'y en a qu'un ici) dans un tableau
            if ($queryPrepare->execute($valeursClePrimaire)) {
                // si la requête réussit :
                // extraire l'enregistrement retourné par la requête
                $enregistrement = $queryPrepare->fetch(PDO::FETCH_ASSOC);
                // construire l'objet métier correspondant
                $retour = self::enregistrementVersObjet($enregistrement);
            }
        } catch (PDOException $e) {
            echo get_class() . ' - ' . __METHOD__ . ' : ' . $e->getMessage();
        }
        return $retour;
    }

    public static function insert($objetMetier) {
        return FALSE;
    }

    public static function update($idMetier, $objetMetier) {
        
    }

    public static function delete($idMetier) {
        return FALSE;
    }

    public static function obtenirNbEtabOffrantChambres() {
//    global $connexion;
        $req = "SELECT COUNT(DISTINCT idEtab) FROM offre";
        $stmt = Connexion::connecter()->prepare($req);
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    public static function obtenirIdNomEtablissements() {
        $req = "SELECT id, nom FROM etablissement ORDER BY id";
        $stmt = Connexion::connecter()->prepare($req);
        $stmt->execute();
        return $stmt;
    }

    public static function obtenirNbEtab() {
//    global $connexion;
        $req = "SELECT COUNT(*) FROM etablissement";
        $stmt = Connexion::connecter()->prepare($req);
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    public static function obtenirNbTypesChambres() {
        $req = "SELECT count(*) FROM typechambre";
        $stmt = Connexion::connecter()->prepare($req);
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    public static function obtenirDetailEtablissement($id) {
        $req = "SELECT * FROM etablissement WHERE id=?";
        $stmt = Connexion::connecter()->prepare($req);
        $stmt->execute(array($id));
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function obtenirNbOffre($idEtab, $idTypeChambre) {
        $req = "SELECT nombreChambres FROM offre WHERE idEtab=:idEtab AND 
        idTypeChambre=:idTypeCh";
        $stmt = Connexion::connecter()->prepare($req);
        $stmt->bindParam(':idEtab', $idEtab);
        $stmt->bindParam(':idTypeCh', $idTypeChambre);
        $stmt->execute();
        $ok = $stmt->fetchColumn();
        if ($ok) {
            return $ok;
        } else {
            return 0;
        }
    }

    public static function modifierOffreHebergement($idEtab, $idTypeChambre, $nbChambresDemandees) {
        if ($nbChambresDemandees == 0) {
            $req = "DELETE FROM offre WHERE idEtab=:idEtab and idTypeChambre=
           :idTypeCh";
            $stmt = Connexion::connecter()->prepare($req);
            $stmt->bindParam(':idEtab', $idEtab);
            $stmt->bindParam(':idTypeCh', $idTypeChambre);
        } else {
            $req2 = "SELECT nombreChambres FROM offre WHERE idEtab=:idEtab AND 
        idTypeChambre=:idTypeCh";
            $stmt2 = Connexion::connecter()->prepare($req2);
            $stmt2->bindParam(':idEtab', $idEtab);
            $stmt2->bindParam(':idTypeCh', $idTypeChambre);
            $stmt2->execute();
            $lgOffre = $stmt2->fetchColumn();
            if ($lgOffre != 0) {
                $req = "UPDATE offre SET nombreChambres=:nb 
                WHERE idEtab=:idEtab AND idTypeChambre=:idTypeCh";
            } else {
                $req = "INSERT INTO offre VALUES(:idEtab, :idTypeCh, :nb)";
            }
            $stmt = Connexion::connecter()->prepare($req);
            $stmt->bindParam(':idEtab', $idEtab);
            $stmt->bindParam(':idTypeCh', $idTypeChambre);
            $stmt->bindParam(':nb', $nbChambresDemandees);
        }
        $ok = $stmt->execute();
        return $ok;
    }

    public static function obtenirNbOccup($idEtab, $idTypeChambre) {
        $req = "SELECT IFNULL(SUM(nombreChambres), 0) AS totalChambresOccup FROM
        attribution WHERE idEtab=:idEtab AND idTypeChambre=:idTypeCh";
        $stmt = Connexion::connecter()->prepare($req);
        $stmt->bindParam(':idEtab', $idEtab);
        $stmt->bindParam(':idTypeCh', $idTypeChambre);
        $stmt->execute();
        $nb = $stmt->fetchColumn();
        return $nb;
    }

    public static function estModifOffreCorrecte($idEtab, $idTypeChambre, $nombreChambres) {
        $nbOccup = OffreDAO::obtenirNbOccup($idEtab, $idTypeChambre);
        return ($nombreChambres >= $nbOccup);
    }

}
