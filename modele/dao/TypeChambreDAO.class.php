<?php

namespace modele\dao;

use modele\Connexion;
use modele\metier\TypeChambre;
use modele\dao\Dao;
use \PDO;

class TypeChambreDAO implements Dao {

    public static function enregistrementVersObjet($enreg) {
        $retour = new TypeChambre($enreg['id'], $enreg['libelle']);
        return $retour;
    }

    public static function objetVersEnregistrement($objetMetier) {
        $retour = array(
            $objetMetier->getId(),
            $objetMetier->getLibelle(),
        );
        return $retour;
    }

    public static function getAll() {
        $retour = null;
        // Requête textuelle
        $sql = "SELECT * FROM typechambre";
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
            $sql = "SELECT * FROM typechambre WHERE id = ?";
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
            $sql = "INSERT INTO typechambre (id, libelle) VALUES (?, ?)";
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
            $sql = "UPDATE typechambre SET id = ?, libelle = ? WHERE id='" . $idMetier . "';";
//            $sql2 = "UPDATE attribution SET idTypeChmabre = ?, WHERE id=" . $idMetier;
//            $sql3 = "UPDATE offre SET idTypeChmabre = ?, WHERE id=" . $idMetier;
            // préparer la requête PDO
            $queryPrepare = Connexion::connecter()->prepare($sql);
//            $queryPrepare2 = Connexion::connecter()->prepare($sql2);
//            $queryPrepare3 = Connexion::connecter()->prepare($sql3);
            // exécuter la requête avec les valeurs des paramètres dans un tableau
            if ($queryPrepare->execute($objetRef)/* && $queryPrepare2->execute($objetRef) && $queryPrepare3->execute($objetRef)*/) {
                // si la requête réussit :
                $retour = "DELETE Réussi";
            }
        } catch (PDOException $e) {
            echo get_class() . ' - ' . __METHOD__ . ' : ' . $e->getMessage();
        }
        return $retour;
    }

    public static function delete($idMetier) {
        try {
            // Requête textuelle paramétrée (le paramètre est symbolisé par un ?)
            $sql = "DELETE FROM typechambre WHERE id = ?";
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

    

    public static function obtenirLibelleTypeChambre($id) {
        $req = "SELECT libelle FROM TypeChambre WHERE id = ?";
        $stmt = Connexion::connecter()->prepare($req);
        $stmt->execute(array($id));
        return $stmt->fetchColumn();
    }

    public static function estUnLibelleTypeChambre($mode, $id, $libelle) {
        $libelle = str_replace("'", "''", $libelle);
        // S'il s'agit d'une création, on vérifie juste la non existence du libellé
        // sinon on vérifie la non existence d'un autre type chambre (id!='$id') 
        // ayant le même libelle
        if ($mode == 'C') {
            $req = "SELECT COUNT(*) FROM TypeChambre WHERE libelle=:lib";
            $stmt = Connexion::connecter()->prepare($req);
            $stmt->bindParam(':lib', $libelle);
        } else {
            $req = "SELECT COUNT(*) FROM TypeChambre WHERE libelle=:lib and id <> :id";
            $stmt = Connexion::connecter()->prepare($req);
            $stmt->bindParam(':lib', $libelle);
            $stmt->bindParam(':id', $id);
        }
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    public static function creerModifierTypeChambre($mode, $id, $libelle) {
        $libelle = str_replace("'", "''", $libelle);
        if ($mode == 'C') {
            $req = "INSERT INTO TypeChambre VALUES (:id, :lib)";
        } else {
            $req = "UPDATE TypeChambre SET libelle=:lib WHERE id=:id";
        }
        $stmt = Connexion::connecter()->prepare($req);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':lib', $libelle);
        $ok = $stmt->execute();
        return $ok;
    }

    public static function estUnIdTypeChambre($id) {
        $req = "SELECT COUNT(*) FROM TypeChambre WHERE id=?";
        $stmt = Connexion::connecter()->prepare($req);
        $stmt->execute(array($id));
        return $stmt->fetchColumn();
    }

    public static function supprimerTypeChambre($id) {
        $req = "DELETE FROM TypeChambre WHERE id=?";
        $stmt = Connexion::connecter()->prepare($req);
        $ok = $stmt->execute(array($id));
        return $ok;
    }

    public static function verifierDonneesTypeChambreC($id, $libelle) {
        if ($id == "" || $libelle == "") {
            ajouterErreur('Chaque champ suivi du caractère * est obligatoire');
        }
        if ($id != "") {
            // Si l'id est constitué d'autres caractères que de lettres non accentuées 
            // et de chiffres, une erreur est générée
            if (!estChiffresOuEtLettres($id)) {
                ajouterErreur
                        ("L'identifiant doit comporter uniquement des lettres non accentuées et des chiffres");
            } else {
                if (TypeChambreDAO::estUnIdTypeChambre($id)) {
                    ajouterErreur("Le type de chambre $id existe déjà");
                }
            }
        }
        if ($libelle != "" && TypeChambreDAO::estUnLibelleTypeChambre('C', $id, $libelle)) {
            ajouterErreur("Le type de chambre $libelle existe déjà");
        }
    }

    public static function verifierDonneesTypeChambreM($id, $libelle) {
        if ($libelle == "") {
            ajouterErreur('Chaque champ suivi du caractère * est obligatoire');
        }
        if ($libelle != "" && TypeChambreDAO::estUnLibelleTypeChambre('M', $id, $libelle)) {
            ajouterErreur("Le type de chambre $libelle existe déjà");
        }
    }

}
