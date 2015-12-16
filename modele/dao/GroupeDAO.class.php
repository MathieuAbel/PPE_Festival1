<?php

namespace modele\dao;
use modele\Connexion;
use modele\metier\Groupe;
use modele\dao\Dao;
use \PDO;

class GroupeDAO implements Dao {
    
    public static function enregistrementVersObjet($enreg) {
        $retour = new Groupe($enreg['id'], $enreg['nom'], $enreg['identiteResponsable'], $enreg['adressePostale'], $enreg['nombrePersonnes'], $enreg['nomPays'], $enreg['hebergement']);
        return $retour;        
    }

    public static function objetVersEnregistrement($objetMetier) {
        $retour = array(
            $objetMetier->getId(),
            $objetMetier->getNom(),
            $objetMetier->getIdentiteResponsable(),
            $objetMetier->getAdressePostale(),
            $objetMetier->getNombrePersonnes(),
            $objetMetier->getNomPays(),
            $objetMetier->getHebergement(),
        );
        return $retour;
    }

    public static function getAll() {
        $retour = null;
        // Requête textuelle
        $sql = "SELECT * FROM groupe";
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
            $sql = "SELECT * FROM groupe WHERE id = ?";
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
            $sql = "INSERT INTO groupe (id, nom, identiteResponsable, adressePostale, nombrePersonnes, nomPays, hebergement) VALUES (?, ?, ?, ?, ?, ?, ?)";
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
            $sql = "UPDATE groupe SET id = ?, nom = ?, identiteResponsable = ?, adressePostale = ?, nombrePersonnes = ?, nomPays = ?, hebergement = ? WHERE id=".$idMetier;
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
        return FALSE;
    }
}
