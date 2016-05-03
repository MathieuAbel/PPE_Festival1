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
            $sql = "SELECT * FROM groupe WHERE id = ?";
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
            $sql = "INSERT INTO groupe (id, nom, identiteResponsable, adressePostale, nombrePersonnes, nomPays, hebergement) VALUES (?, ?, ?, ?, ?, ?, ?)";
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
            $sql = "UPDATE groupe SET id = ?, nom = ?, identiteResponsable = ?, adressePostale = ?, nombrePersonnes = ?, nomPays = ?, hebergement = ? WHERE id='". $idMetier ."';";
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
            $sql = "DELETE FROM Attribution WHERE idGroupe=?;";
            $sql2 = "DELETE FROM Groupe WHERE id=?";
            // préparer la requête PDO
            $queryPrepare = Connexion::connecter()->prepare($sql);
            $queryPrepare2 = Connexion::connecter()->prepare($sql2);
            // exécuter la requête avec les valeurs des paramètres (il n'y en a qu'un ici)
            if ($queryPrepare->execute(array($idMetier)) && $queryPrepare2->execute(array($idMetier))) {
                // si la requête réussit :
                $retour = "DELETE Réussi";
            }
        } catch (PDOException $e) {
            echo get_class() . ' - ' . __METHOD__ . ' : ' . $e->getMessage();
        }

        return $retour;
    }

    public static function estUnIdGroupe($id) {
//    global $connexion;
        $connexion = Connexion::connecter();
        $req = "SELECT COUNT(*) FROM Groupe WHERE id=?";
        $stmt = $connexion->prepare($req);
        $stmt->execute(array($id));
        return $stmt->fetchColumn();
    }

    public static function estUnNomGroupe($mode, $id, $nom) {
//    global $connexion;
        $nom = str_replace("'", "''", $nom);
        // S'il s'agit d'une création, on vérifie juste la non existence du nom sinon
        // on vérifie la non existence d'un autre établissement (id!='$id') portant 
        // le même nom
        if ($mode == 'C') {
            $req = "SELECT COUNT(*) FROM Groupe WHERE nom=?";
            $stmt = Connexion::connecter()->prepare($req);
            $stmt->execute(array($nom));
        } else {
            $req = "SELECT COUNT(*) FROM Groupe WHERE nom=? AND id<>?";
            $stmt = Connexion::connecter()->prepare($req);
            $stmt->execute(array($nom, $id));
        }
        return $stmt->fetchColumn();
    }

    public static function verifierDonneesGroupeC($id, $nom, $nombrePersonnes, $nomPays, $hebergement) {

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
                if (GroupeDAO::estUnIdGroupe($id)) {
                    ajouterErreur("L'établissement $id existe déjà");
                }
            }
        }
        if ($nom != "" && GroupeDAO::estUnNomGroupe('C', $id, $nom)) {
            ajouterErreur("L'établissement $nom existe déjà");
        }
    }

    public static function verifierDonneesGroupeM($id, $nom, $nombrePersonnes, $nomPays, $hebergement) {
        if ($id == "" || $nom == "" || $nombrePersonnes == "" || $nomPays == "" || $hebergement == "") {
            ajouterErreur('Chaque champ suivi du caractère * est obligatoire');
        }
        if ($nom != "" && GroupeDAO::estUnNomGroupe('M', $id, $nom)) {
            ajouterErreur("L'établissement $nom existe déjà");
        }
    }

    function obtenirIdNomGroupesAHeberger($connexion) {
        $req = "SELECT id, nom FROM Groupe WHERE hebergement='O' ORDER BY id";
        $stmt = $connexion->prepare($req);
        $stmt->execute();
        return $stmt;
    }

    function obtenirNomGroupe($connexion, $id) {
        $req = "SELECT nom FROM Groupe WHERE id=?";
        $stmt = $connexion->prepare($req);
        $stmt->execute(array($id));
        return $stmt->fetchColumn();
    }

}
