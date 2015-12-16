<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>test DAO</title>
    </head>
    <body>
        <?php
            use modele\dao\EtabDAO;
            use modele\Connexion;
            use modele\metier\Etablissement;
            
            require_once("../includes/fonctions.inc.php");
//            require_once("../modele/dao/AttribDAO.class.php");
//            require_once("../modele/dao/DAO.class.php");
//            require_once("../modele/dao/EtabDAO.class.php");
//            require_once("../modele/dao/GroupeDAO.class.php");
//            require_once("../modele/dao/OffreDAO.class.php");
//            require_once("../modele/dao/TypeChambreDAO.class.php");
//            require_once("../modele/Connexion.class.php");
            
            $pdo = Connexion::connecter();
            
            // Test d'EtablissementDAO
            echo "<h3>Test d'EtabDAO</h3>";

            // Etablissement : test de sélection de toutes les attributions
            echo "<p>Etablissement : test de sélection de toutes les établissements</p>";
            $lesEtabs = EtabDAO::getAll();
            var_dump($lesEtabs);
            
            // Etablissement : test de sélection d'une seul attribution
            echo "<p>Etablissement : test de sélection d'une seul attribution</p>";
            $unEtab = EtabDAO::getOneById('0350773A');
            var_dump($unEtab);
            
            // Etablissement : test d'insérer un nouvelle établissement
            echo "<p>Etablissement : test d'insérer un nouvelle établissement</p>";
            $objetEtab = new Etablissement('42565', 'La Joliverie', '42 rue de la Jol',  '44000', 'Nantes', '0258657890', 'machin@truc.bidule', 0, 'Monsieur', 'Jean', 'PAULE');
            $ok = EtabDAO::insert($objetEtab);
            var_dump($ok);
            
            // Etablissement : test de modifier un établissement
            echo "<p>Etablissement : test de modifier un établissement</p>";
            $ObjetEtab2 = new Etablissement('42565', 'La Joliverie', '42 rue de la joliverie',  '44000', 'Saint-Sebastien-Sur-Loire', '0258657890', 'machin@truc.bidule', 0, 'Monsieur', 'Jean', 'PAUL');
            $ok2 = EtabDAO::update('42565', $ObjetEtab2);
            var_dump($ok2);
            
            // Etablissement : test de supprimer un établissement
            echo "<p>Etablissement : test de supprimer un établissement</p>";
            $ok3 = EtabDAO::delete('42565');
            var_dump($ok3);
        ?>
    </body>
</html
