<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>test DAO</title>
    </head>
    <body>
        <?php
            use modele\dao\GroupeDAO;
            use modele\Connexion;
            use modele\metier\Groupe;
            
            require_once("../includes/fonctions.inc.php");
//            require_once("../modele/dao/AttribDAO.class.php");
//            require_once("../modele/dao/DAO.class.php");
//            require_once("../modele/dao/EtabDAO.class.php");
//            require_once("../modele/dao/GroupeDAO.class.php");
//            require_once("../modele/dao/OffreDAO.class.php");
//            require_once("../modele/dao/TypeChambreDAO.class.php");
//            require_once("../modele/Connexion.class.php");
            
            $pdo = Connexion::connecter();
            
            // Test de GroupeDAO
            echo "<h3>Test de GroupeDAO</h3>";

//            // Groupe : test de sélection de tous les groupes
//            echo "<p>Groupe : test de sélection de tous les groupes</p>";
//            $lesGroupes = GroupeDAO::getAll();
//            var_dump($lesGroupes);
            
            // Groupe : test de sélection d'un seul groupe
            echo "<p>Groupe : test de sélection d'un seul groupe</p>";
            $leGroupe = GroupeDAO::getOneById('g011');
            var_dump($leGroupe);
            
//            // Groupe : test d'insérer d'un nouveau groupe
//            echo "<p>Groupe : test de création d'un nouveau groupe</p>";
//            $objetGroupe = new Groupe('g050', 'Groupe Test', '', '', 10, 'Allemagne', 'O');
//            $ok = GroupeDAO::insert($objetGroupe);
//            var_dump($ok);
            
            // Groupe : test de modifier un groupe
            echo "<p>Groupe : test de modification d'un groupe</p>";
            $ObjetGroupe2 = new Groupe('g050', 'Groupe Test Avancé', 'NULL', 'NULL', 10, 'France', 'N');
            $ok2 = GroupeDAO::update('g050', $ObjetGroupe2);
            var_dump($ok2);
//            
//            // Groupe : test de supprimer un groupe
//            echo "<p>Groupe : test de supprimer un groupe</p>";
//            $ok3 = GroupeDAO::delete('');
//            var_dump($ok3);
        ?>
    </body>
</html
