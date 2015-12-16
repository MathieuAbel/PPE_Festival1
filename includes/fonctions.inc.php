<?php
/**
 * __autoload
 * @param string $classe : charge une classe à la demande
 */
/**
//function __autoload($classe) {
//    $suffixe = substr($classe, 0, 2);
//    switch ($suffixe) {
//        case "C_" :
//            $chemin = "./controleur/";
//            break;
//        case "M_" :
//            $sousSuffixe = substr($classe, 2, 3);
//            switch ($sousSuffixe) {
//                case "Dao" :
//                    $chemin = "./modele/dao/";
//                    break;
//                default :
//                    $chemin = "./modele/metier/";
//                    break;                   
//            }
//            break;
//        case "V_" :
//            $chemin = "./vue/";
//            break;
//        default :
//            $chemin = "./includes/classes/";
//            break;
//    }
//    $chemin = $chemin . $classe . '.class.php';
//    if (file_exists($chemin)) {
//        require_once($chemin);
//    } else {
//        exit('Pb autoload : Le fichier <b>' . $chemin . '</b> n\'existe pas.');
//    }
//}
*/
/**
 * Charge un fichier de classe qualifiée par un espace de noms
 * @param type $className
 * @throws Exception
 */
function __autoload($className) {
    $fileName  = __DIR__.'/../';
//    $fileName = __DIR__."/";
    $fileName  .= str_replace('\\', DIRECTORY_SEPARATOR, $className).'.class.php';
    if (file_exists($fileName)) {
        require_once($fileName);
//    } else {
//        throw new Exception('Pb autoload : Le fichier ' . $fileName . ' n\'existe pas.');
    }
    
}