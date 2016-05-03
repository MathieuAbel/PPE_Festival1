<?php

// FONCTIONS UTILISÉES UNIQUEMENT DANS LA GESTION DES ATTRIBUTIONS
// Met à jour (suppression, modification ou ajout) l'attribution correspondant à
// l'id étab, à l'id type chambre et à l'id groupe transmis
function modifierAttribChamb($idEtab, $idTypeChambre, $idGroupe, $nbChambres) {
    $req = "SELECT COUNT(*) AS nombreAttribGroupe 
        FROM Attribution 
        WHERE idEtab= :idEtab AND idTypeChambre=:idTypeCh AND idGroupe=:idGroupe";
    $stmt = modele\Connexion::connecter()->prepare($req);
    $stmt->bindParam(':idEtab', $idEtab);
    $stmt->bindParam(':idTypeCh', $idTypeChambre);
    $stmt->bindParam(':idGroupe', $idGroupe);
    $stmt->execute();
    $lgAttrib = $stmt->fetchColumn();
    if ($nbChambres == 0) {
        $req = "DELETE FROM Attribution WHERE idEtab=:idEtab AND 
           idTypeChambre=:idTypeCh AND idGroupe=:idGroupe";
        $stmt = modele\Connexion::connecter()->prepare($req);
    } else {
        if ($lgAttrib != 0) {
            $req = "UPDATE Attribution SET nombreChambres=:nbCh 
                WHERE idEtab=:idEtab AND idTypeChambre=:idTypeCh 
                AND idGroupe=:idGroupe";
        } else {
            $req = "INSERT INTO Attribution VALUES(:idEtab, :idTypeCh, :idGroupe, :nbCh)";
        }
        $stmt = modele\Connexion::connecter()->prepare($req);
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
function obtenirGroupesEtab($id) {
    $req = "SELECT DISTINCT id, nom FROM Groupe 
        INNER JOIN Attribution ON Attribution.idGroupe = Groupe.id 
        WHERE idEtab=?";
    $stmt = modele\Connexion::connecter()->prepare($req);
    $stmt->execute(array($id));
    return $stmt;
}

// Retourne le nombre de chambres libres pour l'établissement et le type de
// chambre en question (retournera 0 si absence d'offre ou si absence de 
// disponibilité)  
function obtenirNbDispo($idEtab, $idTypeChambre) {
    $nbOffre = \modele\dao\AttribDAO::obtenirNbOffre($idEtab, $idTypeChambre);
    if ($nbOffre != 0) {
        // Recherche du nombre de chambres occupées pour l'établissement et le
        // type de chambre en question
        $nbOccup = \modele\dao\AttribDAO::obtenirNbOccup($idEtab, $idTypeChambre);
        // Calcul du nombre de chambres libres
        $nbChLib = $nbOffre - $nbOccup;
        return $nbChLib;
    } else {
        return 0;
    }
}

// Retourne le nombre de chambres occupées par le groupe transmis pour l'id étab
// et l'id type chambre transmis
function obtenirNbOccupGroupe($idEtab, $idTypeChambre, $idGroupe) {
//    global $connexion;
    $req = "SELECT nombreChambres FROM Attribution 
            WHERE idEtab=:idEtab 
              AND idTypeChambre=:idTypeCh 
              AND idGroupe=:idGroupe";

    $stmt = modele\Connexion::connecter()->prepare($req);
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
