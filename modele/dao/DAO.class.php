<?php
namespace modele\dao;

interface DAO {

    /**
     * Lire tous les enregistrements d'une table
     * @return tableau-associatif d'objets : un tableau d'instances de la classe métier
     */
    public static function getAll();

    /**
     * Lire un enregistrement d'après une valeur de clef primaire
     * @param $valeurClePrimaire
     * @return objet : une instance de la classe métier
     */
    public static function getOneById($valeurClePrimaire);    
    /**
     * Suppression d'un enregistrement d'après son identifiant
     * @param identifiant métier de l'enregistrement à détruire
     * @return boolean Cette fonction retourne TRUE en cas de succès ou FALSE si une erreur survient.
     */
    public static function delete($idMetier);
    /**
     * Insertion d'un nouvel enregistrement
     * @param $objetMetier objet métier contenant les données nécessaires à l'ajout
     * @return boolean Cette fonction retourne TRUE en cas de succès ou FALSE si une erreur survient.
     */
    public static function insert($objetMetier);

    /**
     * Mise à jour d'un enregistrement d'après son identifiant
     * @param $idMetier identifiant métier de l'objet à modifier
     * @param $objetMetier objet métier modifié
     * @return boolean Cette fonction retourne TRUE en cas de succès ou FALSE si une erreur survient.
     */
    public static function update($idMetier, $objetMetier);

   /**
     * fonction à redéfinir dans chaque classe Dao concrète
     * Permet d'instancier un objet d'après les valeurs d'un enregistrement lu dans la base de données
     * @param tableau-associatif $unEnregistrement liste des valeurs des champs d'un enregistrement
     * @return objet :  instance de la classe métier, initialisée d'après les valeurs de l'enregistrement 
     */
    public static function enregistrementVersObjet($unEnregistrement);

    /**
     * Prépare une liste de paramètres pour une requête SQL UPDATE ou INSERT
     * @param Object $objetMetier
     * @return array : tableau ordonné de valeurs
     */
    public static function objetVersEnregistrement($objetMetier) ;
    
    
}
