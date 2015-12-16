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
            
            require_once("../includes/fonctions.inc.php");
//            require_once("../modele/dao/AttribDAO.class.php");
//            require_once("../modele/dao/DAO.class.php");
//            require_once("../modele/dao/EtabDAO.class.php");
//            require_once("../modele/dao/GroupeDAO.class.php");
//            require_once("../modele/dao/OffreDAO.class.php");
//            require_once("../modele/dao/TypeChambreDAO.class.php");
//            require_once("../modele/Connexion.class.php");
            
            $pdo = Connexion::connecter();
            
            // Test d'AttributionDao
            echo "<h3>Test d'EtabDAO</h3>";

            // Attribution : test de sélection de toutes les attributions
            echo "<p>Produit : test de sélection de toutes les établissements</p>";
            $lesEtabs = EtabDAO::getAll();
            var_dump($lesEtabs);
        ?>
    </body>
</html