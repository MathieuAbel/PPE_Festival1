<?php

namespace modele\dao;

use modele\Connexion;
use modele\metier\Etablissement;
use modele\dao\DAO;
use \PDO;

class EtabDAO implements DAO {

    public static function enregistrementVersObjet($enreg) {
        $retour = new Etablissement($enreg['id'], $enreg['nom'], $enreg['adresseRue'], $enreg['codePostal'], $enreg['ville'], $enreg['tel'], $enreg['adresseElectronique'], $enreg['type'], $enreg['civiliteResponsable'], $enreg['nomResponsable'], $enreg['prenomResponsable']);
        return $retour;
    }

    public static function objetVersEnregistrement($objetMetier) {
        $retour = array(
            $objetMetier->getId(),
            $objetMetier->getNom(),
            $objetMetier->getAdresseRue(),
            $objetMetier->getCodePostal(),
            $objetMetier->getVille(),
            $objetMetier->getTel(),
            $objetMetier->getAdresseElectronique(),
            $objetMetier->getType(),
            $objetMetier->getCiviliteResponsable(),
            $objetMetier->getNomResponsable(),
            $objetMetier->getPrenomResponsable()
        );
        return $retour;
    }

    public static function getAll() {
        $retour = null;
        // Requête textuelle
        $sql = "SELECT * FROM etablissement";
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
        $retour = null;
        try {
            // Requête textuelle paramétrée (le paramètre est symbolisé par un ?)
            $sql = "SELECT * FROM etablissement WHERE id = ?";
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

    public static function insert($objetMetier) {
        try {
            $objetRef = self::objetVersEnregistrement($objetMetier);
            // Requête textuelle paramétrée (le paramètre est symbolisé par un ?)
            $sql = "INSERT INTO etablissement (id, nom, adresseRue, codePostal, ville, tel, adresseElectronique, type, civiliteResponsable, nomResponsable, prenomResponsable) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
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
            $sql = "UPDATE etablissement SET id = ?, nom = ?, adresseRue = ?, codePostal = ?, ville = ?, tel = ?, adresseElectronique = ?, type = ?, civiliteResponsable = ?, nomResponsable = ?, prenomResponsable = ? WHERE id='". $idMetier ."';";
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

    public static function supprimerEtablissement($id) {
        $req = "DELETE FROM etablissement WHERE id=?";
        $stmt = Connexion::connecter()->prepare($req);
        $ok = $stmt->execute(array($id));
        return $ok;
    }

    public static function delete($idMetier) {
        try {
            // Requête textuelle paramétrée (le paramètre est symbolisé par un ?)
            $sql = "DELETE FROM etablissement WHERE id = ?";
            // préparer la requête PDO
            $queryPrepare = Connexion::getPdo()->prepare($sql);
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

    public static function estUnNomEtablissement($mode, $id, $nom) {
//    global $connexion;
        $nom = str_replace("'", "''", $nom);
        $connexion = Connexion::connecter();
        // S'il s'agit d'une création, on vérifie juste la non existence du nom sinon
        // on vérifie la non existence d'un autre établissement (id!='$id') portant 
        // le même nom
        if ($mode == 'C') {
            $req = "SELECT COUNT(*) FROM etablissement WHERE nom=?";
            $stmt = $connexion->prepare($req);
            $stmt->execute(array($nom));
        } else {
            $req = "SELECT COUNT(*) FROM etablissement WHERE nom=? AND id<>?";
            $stmt = $connexion->prepare($req);
            $stmt->execute(array($nom, $id));
        }
        return $stmt->fetchColumn();
    }

    public static function estUnIdEtablissement($id) {
//    global $connexion;
        $connexion = Connexion::connecter();
        $req = "SELECT COUNT(*) FROM etablissement WHERE id=?";
        $stmt = $connexion->prepare($req);
        $stmt->execute(array($id));
        return $stmt->fetchColumn();
    }

    public static function creerModifierEtablissement($mode, $id, $nom, $adresseRue, $codePostal, $ville, $tel, $adresseElectronique, $type, $civiliteResponsable, $nomResponsable, $prenomResponsable) {
        /* INUTILE Avec requêtes préparées
          $nom = addslashes($nom);
          $adresseRue = str_replace("'", "''", $adresseRue);
          $ville = str_replace("'", "''", $ville);
          $adresseElectronique = str_replace("'", "''", $adresseElectronique);
          $nomResponsable = str_replace("'", "''", $nomResponsable);
          $prenomResponsable = str_replace("'", "''", $prenomResponsable);
         * 
         */
        if ($mode == 'C') {
            $req = "INSERT INTO etablissement VALUES (:id, :nom, :rue, :cdp, :ville, :tel, :email, :type, :civ, :nomResp, :prenomResp)";
        } else {
            $req = "UPDATE etablissement SET nom=:nom, adresseRue=:rue,
           codePostal=:cdp, ville=:ville, tel=:tel,
           adresseElectronique=:email, type=:type,
           civiliteResponsable=:civ, nomResponsable=:nomResp, prenomResponsable=:prenomResp 
           WHERE id=:id";
        }
        $stmt = Connexion::connecter()->prepare($req);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':nom', $nom);
        $stmt->bindParam(':rue', $adresseRue);
        $stmt->bindParam(':cdp', $codePostal);
        $stmt->bindParam(':ville', $ville);
        $stmt->bindParam(':tel', $tel);
        $stmt->bindParam(':email', $adresseElectronique);
        $stmt->bindParam(':type', $type);
        $stmt->bindParam(':civ', $civiliteResponsable);
        $stmt->bindParam(':nomResp', $nomResponsable);
        $stmt->bindParam(':prenomResp', $prenomResponsable);
        $ok = $stmt->execute();
        return $ok;
    }

    function obtenirNbEtab() {
//    global $connexion;
        $req = "SELECT COUNT(*) FROM etablissement";
        $stmt = Connexion::connecter()->prepare($req);
        $stmt->execute();
        return $stmt->fetchColumn();
    }

}
