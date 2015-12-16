<?php

// FONCTIONS DE GESTION DES ÉTABLISSEMENTS

function obtenirIdNomEtablissements($connexion) {
    $req = "SELECT id, nom FROM Etablissement ORDER BY id";
    $stmt = $connexion->prepare($req);
    $stmt->execute();
    return $stmt;
}
function obtenirIdNomGroupes($connexion) {
    $req = "SELECT id, nom FROM Groupe ORDER BY id";
    $stmt = $connexion->prepare($req);
    $stmt->execute();
    return $stmt;
}
function obtenirIdGroupes($connexion) {
    $req = "SELECT id FROM Groupe ORDER BY id";
    $stmt = $connexion->prepare($req);
    $stmt->execute();
    return $stmt;
}

function obtenirNomGroupes($connexion) {
    $req = "SELECT nom FROM Groupe ORDER BY nom";
    $stmt = $connexion->prepare($req);
    $stmt->execute();
    return $stmt;
}

function obtenirIdentiteResponsable($connexion) {
    $req = "SELECT identiteResponsable FROM Groupe ORDER BY identiteResponsable";
    $stmt = $connexion->prepare($req);
    $stmt->execute();
    return $stmt;
}

function obtenirAdressePostale($connexion) {
    $req = "SELECT adressePostale FROM Groupe ORDER BY adressePostale";
    $stmt = $connexion->prepare($req);
    $stmt->execute();
    return $stmt;
}
function obtenirNombrePersonnes($connexion) {
    $req = "SELECT nombrePersonnes FROM Groupe ORDER BY nombrePersonnes";
    $stmt = $connexion->prepare($req);
    $stmt->execute();
    return $stmt;
}


function obtenirNomPays($connexion) {
    $req = "SELECT nomPays FROM Groupe ORDER BY nomPays";
    $stmt = $connexion->prepare($req);
    $stmt->execute();
    return $stmt;
}

function hebergement($connexion) {
    $req = "SELECT hebergement FROM Groupe ORDER BY hebergement";
    $stmt = $connexion->prepare($req);
    $stmt->execute();
    return $stmt;
}

function obtenirIdNomEtablissementsOffrantChambres($connexion) {
    $req = "SELECT DISTINCT id, nom FROM Etablissement e 
                INNER JOIN Offre o ON e.id = o.idEtab 
                ORDER BY id";
    $stmt = $connexion->prepare($req);
    $stmt->execute();
    return $stmt;
}

function obtenirNomEtablissementsOffrantChambres($connexion) {
    $req = "SELECT DISTINCT nom FROM Etablissement e 
                INNER JOIN Offre o ON e.id = o.idEtab 
                ORDER BY id";
    $stmt = $connexion->prepare($req);
    $stmt->execute();
    return $stmt;
}

function obtenirIdEtablissementsOffrantChambres($connexion) {
    $req = "SELECT DISTINCT id FROM Etablissement e 
                INNER JOIN Offre o ON e.id = o.idEtab 
                ORDER BY id";
    $stmt = $connexion->prepare($req);
    $stmt->execute();
    return $stmt;
}

function obtenirDetailEtablissement($connexion, $id) {
    $req = "SELECT * FROM Etablissement WHERE id=?";
    $stmt = $connexion->prepare($req);
    $stmt->execute(array($id));
    return $stmt->fetch(PDO::FETCH_ASSOC);
}
function obtenirDetailGroupe($connexion, $id) {
    $req = "SELECT * FROM Groupe WHERE id=?";
    $stmt = $connexion->prepare($req);
    $stmt->execute(array($id));
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function supprimerGroupe($connexion, $id) {
    $req = "DELETE FROM Groupe WHERE id=?";
    $stmt = $connexion->prepare($req);
    $ok = $stmt->execute(array($id));
    return $ok;
}
function supprimerEtablissement($connexion, $id) {
    $req = "DELETE FROM Etablissement WHERE id=?";
    $stmt = $connexion->prepare($req);
    $ok = $stmt->execute(array($id));
    return $ok;
}

function creerModifierEtablissement($connexion, $mode, $id, $nom, $adresseRue, $codePostal, $ville, $tel, $adresseElectronique, $type, $civiliteResponsable, $nomResponsable, $prenomResponsable) {
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
        $req = "INSERT INTO Etablissement VALUES (:id, :nom, :rue, :cdp, :ville, :tel, :email, :type, :civ, :nomResp, :prenomResp)";
    } else {
        $req = "UPDATE Etablissement SET nom=:nom, adresseRue=:rue,
           codePostal=:cdp, ville=:ville, tel=:tel,
           adresseElectronique=:email, type=:type,
           civiliteResponsable=:civ, nomResponsable=:nomResp, prenomResponsable=:prenomResp 
           WHERE id=:id";
    }
    $stmt = $connexion->prepare($req);
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
function creerModifierGroupe($connexion, $mode, $id, $nom, $identiteResponsable,$adressePostale, $nombrePersonnes,$nomPays ,$hebergement) {
    
    if ($mode == 'C') {
        $req = "INSERT INTO Groupe VALUES (:id, :nom, :identiteResponsable,:adressePostale, :nombrePersonnes, :nomPays, :hebergement)";
    } else {
        $req = "UPDATE Groupe SET 
           nom=:nom,identiteResponsable=:identiteResponsable,adressePostale=:adressePostale,nombrePersonnes=:nombrePersonnes,nomPays=:nomPays,hebergement=:hebergement 
           WHERE id=:id";
    }
    $stmt = $connexion->prepare($req);
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':nom', $nom);
    $stmt->bindParam(':identiteResponsable', $identiteResponsable);
    $stmt->bindParam(':adressePostale', $adressePostale);
    $stmt->bindParam(':nombrePersonnes', $nombrePersonnes);
    $stmt->bindParam(':nomPays', $nomPays);
    $stmt->bindParam(':hebergement', $hebergement);
    $ok = $stmt->execute();
    return $ok;
}

function estUnIdGroupe($connexion, $id) {
//    global $connexion;
    $req = "SELECT COUNT(*) FROM Groupe WHERE id=?";
    $stmt = $connexion->prepare($req);
    $stmt->execute(array($id));
    return $stmt->fetchColumn();
}
function estUnIdEtablissement($connexion, $id) {
//    global $connexion;
    $req = "SELECT COUNT(*) FROM Etablissement WHERE id=?";
    $stmt = $connexion->prepare($req);
    $stmt->execute(array($id));
    return $stmt->fetchColumn();
}

function estUnNomEtablissement($connexion, $mode, $id, $nom) {
//    global $connexion;
    $nom = str_replace("'", "''", $nom);
    // S'il s'agit d'une création, on vérifie juste la non existence du nom sinon
    // on vérifie la non existence d'un autre établissement (id!='$id') portant 
    // le même nom
    if ($mode == 'C') {
        $req = "SELECT COUNT(*) FROM Etablissement WHERE nom=?";
        $stmt = $connexion->prepare($req);
        $stmt->execute(array($nom));
    } else {
        $req = "SELECT COUNT(*) FROM Etablissement WHERE nom=? AND id<>?";
        $stmt = $connexion->prepare($req);
        $stmt->execute(array($nom, $id));
    }
    return $stmt->fetchColumn();
}

function estUnNomGroupe($connexion, $mode, $id, $nom) {
//    global $connexion;
    $nom = str_replace("'", "''", $nom);
    // S'il s'agit d'une création, on vérifie juste la non existence du nom sinon
    // on vérifie la non existence d'un autre établissement (id!='$id') portant 
    // le même nom
    if ($mode == 'C') {
        $req = "SELECT COUNT(*) FROM Groupe WHERE nom=?";
        $stmt = $connexion->prepare($req);
        $stmt->execute(array($nom));
    } else {
        $req = "SELECT COUNT(*) FROM Groupe WHERE nom=? AND id<>?";
        $stmt = $connexion->prepare($req);
        $stmt->execute(array($nom, $id));
    }
    return $stmt->fetchColumn();
}

function obtenirNbEtab($connexion) {
//    global $connexion;
    $req = "SELECT COUNT(*) FROM Etablissement";
    $stmt = $connexion->prepare($req);
    $stmt->execute();
    return $stmt->fetchColumn();
}

function obtenirNbEtabOffrantChambres($connexion) {
//    global $connexion;
    $req = "SELECT COUNT(DISTINCT idEtab) FROM Offre";
    $stmt = $connexion->prepare($req);
    $stmt->execute();
    return $stmt->fetchColumn();
}

// FONCTIONS DE GESTION DES TYPES DE CHAMBRES

function obtenirTypesChambres($connexion) {
    $req = "SELECT * FROM TypeChambre";
    $stmt = $connexion->prepare($req);
    $stmt->execute();
    return $stmt;
}

function obtenirIdTypesChambres($connexion) {
    $req = "SELECT id FROM TypeChambre";
    $stmt = $connexion->prepare($req);
    $stmt->execute();
    return $stmt;
}

function obtenirLibelleTypesChambres($connexion) {
    $req = "SELECT libelle FROM TypeChambre ORDER BY id";
    $stmt = $connexion->prepare($req);
    $stmt->execute();
    return $stmt;
}

function obtenirLibelleTypeChambre($connexion, $id) {
    $req = "SELECT libelle FROM TypeChambre WHERE id = ?";
    $stmt = $connexion->prepare($req);
    $stmt->execute(array($id));
    return $stmt->fetchColumn();
}

function obtenirNbTypesChambres($connexion) {
    $req = "SELECT count(*) FROM TypeChambre";
    $stmt = $connexion->prepare($req);
    $stmt->execute();
    return $stmt->fetchColumn();
}

function supprimerTypeChambre($connexion, $id) {
    $req = "DELETE FROM TypeChambre WHERE id=?";
    $stmt = $connexion->prepare($req);
    $ok = $stmt->execute(array($id));
    return $ok;
}

function obtenirDetailTypeChambre($connexion, $id) {
    $req = "SELECT * FROM TypeChambre WHERE id=?";
    $stmt = $connexion->prepare($req);
    $stmt->execute(array($id));
    return $stmt;
}

function creerModifierTypeChambre($connexion, $mode, $id, $libelle) {
    $libelle = str_replace("'", "''", $libelle);
    if ($mode == 'C') {
        $req = "INSERT INTO TypeChambre VALUES (:id, :lib)";
    } else {
        $req = "UPDATE TypeChambre SET libelle=:lib WHERE id=:id";
    }
    $stmt = $connexion->prepare($req);
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':lib', $libelle);
    $ok = $stmt->execute();
    return $ok;
}

function estUnIdTypeChambre($connexion, $id) {
    $req = "SELECT COUNT(*) FROM TypeChambre WHERE id=?";
    $stmt = $connexion->prepare($req);
    $stmt->execute(array($id));
    return $stmt->fetchColumn();
}

function estUnLibelleTypeChambre($connexion, $mode, $id, $libelle) {
    $libelle = str_replace("'", "''", $libelle);
    // S'il s'agit d'une création, on vérifie juste la non existence du libellé
    // sinon on vérifie la non existence d'un autre type chambre (id!='$id') 
    // ayant le même libelle
    if ($mode == 'C') {
        $req = "SELECT COUNT(*) FROM TypeChambre WHERE libelle=:lib";
        $stmt = $connexion->prepare($req);
        $stmt->bindParam(':lib', $libelle);
    } else {
        $req = "SELECT COUNT(*) FROM TypeChambre WHERE libelle=:lib and id <> :id";
        $stmt = $connexion->prepare($req);
        $stmt->bindParam(':lib', $libelle);
        $stmt->bindParam(':id', $id);
    }
    $stmt->execute();
    return $stmt->fetchColumn();
}

// FONCTIONS RELATIVES AUX GROUPES

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

// FONCTIONS RELATIVES AUX OFFRES
// Met à jour (suppression, modification ou ajout) l'offre correspondant à l'id
// étab et à l'id type chambre transmis
function modifierOffreHebergement($connexion, $idEtab, $idTypeChambre, $nbChambresDemandees) {
    if ($nbChambresDemandees == 0) {
        $req = "DELETE FROM Offre WHERE idEtab=:idEtab and idTypeChambre=
           :idTypeCh";
        $stmt = $connexion->prepare($req);
        $stmt->bindParam(':idEtab', $idEtab);
        $stmt->bindParam(':idTypeCh', $idTypeChambre);
    } else {
        $req2 = "SELECT nombreChambres FROM Offre WHERE idEtab=:idEtab AND 
        idTypeChambre=:idTypeCh";
        $stmt2 = $connexion->prepare($req2);
        $stmt2->bindParam(':idEtab', $idEtab);
        $stmt2->bindParam(':idTypeCh', $idTypeChambre);
        $stmt2->execute();
        $lgOffre = $stmt2->fetchColumn();
        if ($lgOffre != 0) {
            $req = "UPDATE Offre SET nombreChambres=:nb 
                WHERE idEtab=:idEtab AND idTypeChambre=:idTypeCh";
        } else {
            $req = "INSERT INTO Offre VALUES(:idEtab, :idTypeCh, :nb)";
        }
        $stmt = $connexion->prepare($req);
        $stmt->bindParam(':idEtab', $idEtab);
        $stmt->bindParam(':idTypeCh', $idTypeChambre);
        $stmt->bindParam(':nb', $nbChambresDemandees);
    }
    $ok = $stmt->execute();
    return $ok;
}

// Retourne le nombre de chambres offertes pour l'id étab et l'id type chambre 
// transmis
function obtenirNbOffre($connexion, $idEtab, $idTypeChambre) {
    $req = "SELECT nombreChambres FROM Offre WHERE idEtab=:idEtab AND 
        idTypeChambre=:idTypeCh";
    $stmt = $connexion->prepare($req);
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

// Retourne false si le nombre de chambres transmis est inférieur au nombre de 
// chambres occupées pour l'établissement et le type de chambre transmis 
// Retourne true dans le cas contraire
function estModifOffreCorrecte($connexion, $idEtab, $idTypeChambre, $nombreChambres) {
    $nbOccup = obtenirNbOccup($connexion, $idEtab, $idTypeChambre);
    return ($nombreChambres >= $nbOccup);
}

// FONCTIONS RELATIVES AUX ATTRIBUTIONS
// Teste la présence d'attributions pour l'établissement transmis    
function existeAttributionsEtab($connexion, $id) {
    $req = "SELECT COUNT(*) FROM Attribution WHERE idEtab=?";
    $stmt = $connexion->prepare($req);
    $stmt->execute(array($id));
    return $stmt->fetchColumn();
}


// Teste la présence d'attributions pour le type de chambre transmis 
function existeAttributionsTypeChambre($connexion, $id) {
    $req = "SELECT COUNT(*) FROM Attribution WHERE idTypeChambre=?";
    $stmt = $connexion->prepare($req);
    $stmt->execute(array($id));
    return $stmt->fetchColumn();
}

// Retourne le nombre de chambres occupées pour l'id étab et l'id type chambre
// transmis
function obtenirNbOccup($connexion, $idEtab, $idTypeChambre) {
    $req = "SELECT IFNULL(SUM(nombreChambres), 0) AS totalChambresOccup FROM
        Attribution WHERE idEtab=:idEtab AND idTypeChambre=:idTypeCh";
    $stmt = $connexion->prepare($req);
    $stmt->bindParam(':idEtab', $idEtab);
    $stmt->bindParam(':idTypeCh', $idTypeChambre);
    $stmt->execute();
    $nb = $stmt->fetchColumn();
    return $nb;
}
