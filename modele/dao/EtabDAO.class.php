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
            ':id' => $objetMetier->getId(),
            ':nom' => $objetMetier->getNom(),
            ':adresseRue' => $objetMetier->getAdresseRue(),
            ':codePostal' => $objetMetier->getCodePostal(),
            ':ville' => $objetMetier->getVille(),
            ':tel' => $objetMetier->getTel(),
            ':adresseElectronique' => $objetMetier->getAdresseElectronique(),
            ':type' => $objetMetier->getType(),
            ':civiliteResponsable' => $objetMetier->getCiviliteResponsable(),
            ':nomResponsable' => $objetMetier->getNomResponsable(),
            ':prenomResponsable' => $objetMetier->getPrenomResponsable()
        );
        return $retour;
    }

    public static function getAll() {
        $retour = null;
        // Requête textuelle
        $sql = "SELECT * FROM Etablissement";
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
            $sql = "SELECT * FROM Etablissement WHERE id = ?";
            // préparer la requête PDO
            $queryPrepare = Connexion::getPdo()->prepare($sql);
            // exécuter la requête avec les valeurs des paramètres (il n'y en a qu'un ici) dans un tableau
            if ($queryPrepare->execute(array($valeurClePrimaire))) {
                // si la requête réussit :
                // extraire l'enregistrement retourné par la requête
                $enregistrement = $queryPrepare->fetch(PDO::FETCH_ASSOC);
                // construire l'objet métier correspondant
                $retour = self::enregistrementVersObjet($enregistrement);
            }
        } catch (PDOException $e) {
            echo get_class() . ' - '.__METHOD__ . ' : '. $e->getMessage();
        }
        return $retour;
    }

    public static function insert($objetMetier) {
        try {
            $objetRef = self::objetVersEnregistrement($objetMetier);
            // Requête textuelle paramétrée (le paramètre est symbolisé par un ?)
            $sql = "INSERT INTO Etablissement (id, nom, adresseRue, codePostal, ville, tel, adresseElectronique, type, civiliteResponsable, nomResponsable, prenomResponsable) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            // préparer la requête PDO
            $queryPrepare = Connexion::getPdo()->prepare($sql);
            // exécuter la requête avec les valeurs des paramètres dans un tableau
            $queryPrepare->execute($objetRef);
            $retour = "INSERT Réussi !";
        } catch (PDOException $e) {
            echo get_class() . ' - '.__METHOD__ . ' : '. $e->getMessage();
        }
        return $retour;
    }
    
    public static function update($idMetier, $objetMetier) {
        try {
            $objetRef = self::objetVersEnregistrement($objetMetier);
            
            // Requête textuelle paramétrée (le paramètre est symbolisé par un ?)
            $sql = "UPDATE Etablissement SET id = ?, nom = ?, adresseRue = ?, codePostal = ?, ville = ?, tel = ?, adresseElectronique = ?, type = ?, civiliteResponsable = ?, nomResponsable = ?, prenomResponsable = ? WHERE id=".$idMetier;
            // préparer la requête PDO
            $queryPrepare = Connexion::getPdo()->prepare($sql);
            // exécuter la requête avec les valeurs des paramètres dans un tableau
            $queryPrepare->execute($objetRef);
            $retour = "UPDATE Réussi !";
        } catch (PDOException $e) {
            echo get_class() . ' - '.__METHOD__ . ' : '. $e->getMessage();
        }
        return $retour;
    }

    public static function delete($idMetier) {
        try {
            // Requête textuelle paramétrée (le paramètre est symbolisé par un ?)
            $sql = "DELETE FROM Etablissement WHERE id = ?";
            // préparer la requête PDO
            $queryPrepare = Connexion::getPdo()->prepare($sql);
            // exécuter la requête avec les valeurs des paramètres (il n'y en a qu'un ici)
            if ($queryPrepare->execute(array($idMetier))) {
                // si la requête réussit :
                $retour = "DELETE Réussi";
            }
        } catch (PDOException $e) {
            echo get_class() . ' - '.__METHOD__ . ' : '. $e->getMessage();
        }
        
        return $retour;
    }

}
