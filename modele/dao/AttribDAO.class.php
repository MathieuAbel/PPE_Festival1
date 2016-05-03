<?php

namespace modele\dao;

use modele\Connexion;
use modele\metier\Attribution;
use \PDO;

class AttribDAO implements Dao {

    public static function enregistrementVersObjet($enreg) {
        $retour = new Attribution($enreg['idEtab'], $enreg['idTypeChambre'], $enreg['idGroupe'], $enreg['nombreChambres']);
        return $retour;
    }

    public static function objetVersEnregistrement($objetMetier) {
        $retour = array(
            $objetMetier->getIdEtab(),
            $objetMetier->getIdTypeChambre(),
            $objetMetier->getIdGroupe(),
            $objetMetier->getNombreChambres(),
        );
        return $retour;
    }

    public static function getAll() {
        $retour = null;
        // Requête textuelle
        $sql = "SELECT * FROM Attribution";
        try {
            // préparer la requête PDO
            $queryPrepare = Connexion::getPdo()->prepare($sql);
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
        $retour = null;
        try {
            // Requête textuelle paramétrée (le paramètre est symbolisé par un ?)
            $sql = "SELECT * FROM Attribution WHERE idEtab = ?";
            // préparer la requête PDO
            $queryPrepare = Connexion::connecter()->prepare($sql);
            // exécuter la requête avec les valeurs des paramètres (il n'y en a qu'un ici) dans un tableau
            if ($queryPrepare->execute(array($valeurClePrimaire))) {
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

    public static function getOneByIdCompo($idEtablissement, $idTypeChambre, $idGroupe) {
        $retour = null;
        $valeursClePrimaire = array($idEtablissement, $idTypeChambre, $idGroupe);
        try {
            // Requête textuelle paramétrée (le paramètre est symbolisé par un ?)
            $sql = "SELECT * FROM Attribution WHERE idEtab = ? AND idTypeChambre = ? AND idGroupe = ?";
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
        try {
            $objetRef = self::objetVersEnregistrement($objetMetier);
            // Requête textuelle paramétrée (le paramètre est symbolisé par un ?)
            $sql = "INSERT INTO Attribution (idEtab, idTypeChambre, idGroupe, nombreChambres ) VALUES (?, ?, ?, ?)";
            // préparer la requête PDO
            $queryPrepare = Connexion::connecter()->prepare($sql);
            // exécuter la requête avec les valeurs des paramètres dans un tableau
            $queryPrepare->execute($objetRef);
            $retour = "INSERT Réussi !";
        } catch (PDOException $e) {
            echo get_class() . ' - ' . __METHOD__ . ' : ' . $e->getMessage();
        }
        return $retour;
    }

    public static function update($idMetier, $objetMetier) {
        try {
            $objetRef = self::objetVersEnregistrement($objetMetier);

            // Requête textuelle paramétrée (le paramètre est symbolisé par un ?)
            $sql = "UPDATE Attribution SET idEtab=?, idTypeChambre=?, idGroupe=?, nombreChambres=?  WHERE idEtab=" . $idMetier;
            // préparer la requête PDO
            $queryPrepare = Connexion::connecter()->prepare($sql);
            // exécuter la requête avec les valeurs des paramètres dans un tableau
            $queryPrepare->execute($objetRef);
            $retour = "UPDATE Réussi !";
        } catch (PDOException $e) {
            echo get_class() . ' - ' . __METHOD__ . ' : ' . $e->getMessage();
        }
        return $retour;
    }

    public static function delete($idMetier) {
        try {
            // Requête textuelle paramétrée (le paramètre est symbolisé par un ?)
            $sql = "DELETE FROM Attribution WHERE idEtab=?;";

            // préparer la requête PDO
            $queryPrepare = Connexion::connecter()->prepare($sql);

            // exécuter la requête avec les valeurs des paramètres (il n'y en a qu'un ici)
            if ($queryPrepare->execute(array($idMetier))) {
                // si la requête réussit :
                $retour = "DELETE Réussi";
            }
        } catch (PDOException $e) {
            echo get_class() . ' - ' . __METHOD__ . ' : ' . $e->getMessage();
        }

        return $retour;
    }

    public static function existeAttributionsEtab($id) {
        $req = "SELECT COUNT(*) FROM Attribution WHERE idEtab=?";
        $stmt = Connexion::connecter()->prepare($req);
        $stmt->execute(array($id));
        return $stmt->fetchColumn();
    }

    public static function existeAttributionsTypeChambre($id) {
        $connexion = Connexion::connecter();
        $req = "SELECT COUNT(*) FROM Attribution WHERE idTypeChambre=?";
        $stmt = $connexion->prepare($req);
        $stmt->execute(array($id));
        return $stmt->fetchColumn();
    }

    public static function obtenirNbEtabOffrantChambres() {
//    global $connexion;
        $req = "SELECT COUNT(DISTINCT idEtab) FROM Offre";
        $stmt = Connexion::connecter()->prepare($req);
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    public static function obtenirIdNomEtablissementsOffrantChambres() {
        $req = "SELECT DISTINCT id, nom FROM Etablissement e 
                INNER JOIN Offre o ON e.id = o.idEtab 
                ORDER BY id";
        $stmt = Connexion::connecter()->prepare($req);
        $stmt->execute();
        return $stmt;
    }

    public static function obtenirIdTypesChambres() {
        $req = "SELECT id FROM TypeChambre";
        $stmt = Connexion::connecter()->prepare($req);
        $stmt->execute();
        return $stmt;
    }

    public static function obtenirNbOccupGroupe($idEtab, $idTypeChambre, $idGroupe) {
//    global $connexion;
        $req = "SELECT nombreChambres FROM Attribution 
            WHERE idEtab=:idEtab 
              AND idTypeChambre=:idTypeCh 
              AND idGroupe=:idGroupe";

        $stmt = Connexion::connecter()->prepare($req);
        $stmt->bindParam(':idEtab', $idEtab);
        $stmt->bindParam(':idTypeCh', $idTypeChambre);
        $stmt->bindParam(':idGroupe', $idGroupe);
        $stmt->execute();
        $ok = $stmt->fetchColumn();
        if ($ok) {
            return $ok;
        } else {
            return 0;
        }
    }

    public static function obtenirNbTypesChambres() {
        $req = "SELECT count(*) FROM TypeChambre";
        $stmt = Connexion::connecter()->prepare($req);
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    public static function obtenirNbOffre($idEtab, $idTypeChambre) {
        $req = "SELECT nombreChambres FROM Offre WHERE idEtab=:idEtab AND 
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

    public static function obtenirNbOccup($idEtab, $idTypeChambre) {
        $req = "SELECT IFNULL(SUM(nombreChambres), 0) AS totalChambresOccup FROM
        Attribution WHERE idEtab=:idEtab AND idTypeChambre=:idTypeCh";
        $stmt = Connexion::connecter()->prepare($req);
        $stmt->bindParam(':idEtab', $idEtab);
        $stmt->bindParam(':idTypeCh', $idTypeChambre);
        $stmt->execute();
        $nb = $stmt->fetchColumn();
        return $nb;
    }

    public static function obtenirNbDispo($idEtab, $idTypeChambre) {
        $nbOffre = AttribDAO::obtenirNbOffre($idEtab, $idTypeChambre);
        if ($nbOffre != 0) {
            // Recherche du nombre de chambres occupées pour l'établissement et le
            // type de chambre en question
            $nbOccup = AttribDAO::obtenirNbOccup($idEtab, $idTypeChambre);
            // Calcul du nombre de chambres libres
            $nbChLib = $nbOffre - $nbOccup;
            return $nbChLib;
        } else {
            return 0;
        }
    }

    public static function obtenirTypesChambres() {
        $req = "SELECT * FROM TypeChambre";
        $stmt = Connexion::connecter()->prepare($req);
        $stmt->execute();
        return $stmt;
    }

    public static function obtenirNomEtablissementsOffrantChambres() {
        $req = "SELECT DISTINCT nom FROM Etablissement e 
                INNER JOIN Offre o ON e.id = o.idEtab 
                ORDER BY id";
        $stmt = Connexion::connecter()->prepare($req);
        $stmt->execute();
        return $stmt;
    }

    public static function obtenirIdEtablissementsOffrantChambres() {
        $req = "SELECT DISTINCT id FROM Etablissement e 
                INNER JOIN Offre o ON e.id = o.idEtab 
                ORDER BY id";
        $stmt = Connexion::connecter()->prepare($req);
        $stmt->execute();
        return $stmt;
    }

    public static function obtenirIdNomGroupesAHeberger() {
        $req = "SELECT id, nom FROM Groupe WHERE hebergement='O' ORDER BY id";
        $stmt = Connexion::connecter()->prepare($req);
        $stmt->execute();
        return $stmt;
    }

    public static function obtenirNomGroupe($id) {
        $req = "SELECT nom FROM Groupe WHERE id=?";
        $stmt = Connexion::connecter()->prepare($req);
        $stmt->execute(array($id));
        return $stmt->fetchColumn();
    }

    // Méthode pour configurer L'attribution 

    public static function modifierAttribChamb($idEtab, $idTypeChambre, $idGroupe, $nbChambres) {
        $req = "SELECT COUNT(*) AS nombreAttribGroupe 
        FROM Attribution 
        WHERE idEtab= :idEtab AND idTypeChambre=:idTypeCh AND idGroupe=:idGroupe";
        $stmt = Connexion::connecter()->prepare($req);
        $stmt->bindParam(':idEtab', $idEtab);
        $stmt->bindParam(':idTypeCh', $idTypeChambre);
        $stmt->bindParam(':idGroupe', $idGroupe);
        $stmt->execute();
        $lgAttrib = $stmt->fetchColumn();
        if ($nbChambres == 0) {
            $req = "DELETE FROM Attribution WHERE idEtab=:idEtab AND 
           idTypeChambre=:idTypeCh AND idGroupe=:idGroupe";
            $stmt = Connexion::connecter()->prepare($req);
        } else {
            if ($lgAttrib != 0) {
                $req = "UPDATE Attribution SET nombreChambres=:nbCh 
                WHERE idEtab=:idEtab AND idTypeChambre=:idTypeCh 
                AND idGroupe=:idGroupe";
            } else {
                $req = "INSERT INTO Attribution VALUES(:idEtab, :idTypeCh, :idGroupe, :nbCh)";
            }
            $stmt = Connexion::connecter()->prepare($req);
            $stmt->bindParam(':nbCh', $nbChambres);
        }
        $stmt->bindParam(':idEtab', $idEtab);
        $stmt->bindParam(':idTypeCh', $idTypeChambre);
        $stmt->bindParam(':idGroupe', $idGroupe);

        $ok = $stmt->execute();
        return $ok;
    }

// Retourne la requête permettant d'obtenir les id et noms des groupes 
// affectés dans l'établissement transmis
    public static function obtenirGroupesEtab($id) {
        $req = "SELECT DISTINCT id, nom FROM Groupe 
        INNER JOIN Attribution ON Attribution.idGroupe = Groupe.id 
        WHERE idEtab=?";
        $stmt = Connexion::connecter()->prepare($req);
        $stmt->execute(array($id));
        return $stmt;
    }

}
