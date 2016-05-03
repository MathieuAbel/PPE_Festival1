<?php

// FONCTIONS DE GESTION DES ÉTABLISSEMENTS


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


function obtenirDetailGroupe($connexion, $id) {
    $req = "SELECT * FROM Groupe WHERE id=?";
    $stmt = $connexion->prepare($req);
    $stmt->execute(array($id));
    return $stmt->fetch(PDO::FETCH_ASSOC);
}
function supprimerGroupe($connexion, $id) {
    $req = "DELETE FROM Attribution WHERE idGroupe=?;";
    $req2 = "DELETE FROM Groupe WHERE id=?";
    $stmt = $connexion->prepare($req);
    $stmt2 = $connexion->prepare($req2);
    $ok = $stmt->execute(array($id));
    $ok += $stmt2->execute(array($id));
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


function estUnIdEtablissement($connexion, $id) {
//    global $connexion;
    $req = "SELECT COUNT(*) FROM Etablissement WHERE id=?";
    $stmt = $connexion->prepare($req);
    $stmt->execute(array($id));
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




function obtenirDetailTypeChambre($connexion, $id) {
    $req = "SELECT * FROM TypeChambre WHERE id=?";
    $stmt = $connexion->prepare($req);
    $stmt->execute(array($id));
    return $stmt;
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


// Retourne le nombre de chambres offertes pour l'id étab et l'id type chambre 
// transmis


// Retourne false si le nombre de chambres transmis est inférieur au nombre de 
// chambres occupées pour l'établissement et le type de chambre transmis 
// Retourne true dans le cas contraire

// FONCTIONS RELATIVES AUX ATTRIBUTIONS
// Teste la présence d'attributions pour l'établissement transmis    



// Teste la présence d'attributions pour le type de chambre transmis 


// Retourne le nombre de chambres occupées pour l'id étab et l'id type chambre
// transmis

