<?php

namespace modele\metier;

class Etablissement {
    
    private $id;
    private $nom;
    private $adresseRue;
    private $codePostal;
    private $ville;
    private $tel;
    private $adresseElectronique;
    private $type;
    private $civiliteResponsable;
    private $nomResponsable;
    private $prenomResponsable;
    
    function __construct($id, $nom, $adresseRue, $codePostal, $ville, $tel, $adresseElectronique, $type, $civiliteResponsable, $nomResponsable, $prenomResponsable) {
        $this->id = $id;
        $this->nom = $nom;
        $this->adresseRue = $adresseRue;
        $this->codePostal = $codePostal;
        $this->ville = $ville;
        $this->tel = $tel;
        $this->adresseElectronique = $adresseElectronique;
        $this->type = $type;
        $this->civiliteResponsable = $civiliteResponsable;
        $this->nomResponsable = $nomResponsable;
        $this->prenomResponsable = $prenomResponsable;
    }
    
    function getId() {
        return $this->id;
    }

     function getNom() {
        return $this->nom;
    }

     function getAdresseRue() {
        return $this->adresseRue;
    }

     function getCodePostal() {
        return $this->codePostal;
    }

     function getVille() {
        return $this->ville;
    }

     function getTel() {
        return $this->tel;
    }

     function getAdresseElectronique() {
        return $this->adresseElectronique;
    }

     function getType() {
        return $this->type;
    }

     function getCiviliteResponsable() {
        return $this->civiliteResponsable;
    }

     function getNomResponsable() {
        return $this->nomResponsable;
    }

     function getPrenomResponsable() {
        return $this->prenomResponsable;
    }

     function setId($id) {
        $this->id = $id;
    }

     function setNom($nom) {
        $this->nom = $nom;
    }

     function setAdresseRue($adresseRue) {
        $this->adresseRue = $adresseRue;
    }

     function setCodePostal($codePostal) {
        $this->codePostal = $codePostal;
    }

     function setVille($ville) {
        $this->ville = $ville;
    }

     function setTel($tel) {
        $this->tel = $tel;
    }

     function setAdresseElectronique($adresseElectronique) {
        $this->adresseElectronique = $adresseElectronique;
    }

     function setType($type) {
        $this->type = $type;
    }

     function setCiviliteResonsable($civiliteResonsable) {
        $this->civiliteResonsable = $civiliteResonsable;
    }

     function setNomResponsable($nomResponsable) {
        $this->nomResponsable = $nomResponsable;
    }

     function setPrenomResponsable($prenomResponsable) {
        $this->prenomResponsable = $prenomResponsable;
    }
    
    public function __toString() {
        $etat = "objet de type : ".get_class($this);
        $etat .= " - identifiant : ".$this->getId();
        $etat .= " - nom : ".$this->getNom();
        $etat .= " - adresse de la rue : ".$this->getAdresseRue();
        $etat .= " - code postal : ".$this->getCodePostal();
        $etat .= " - ville : ".$this->getVille();
        $etat .= " - téléphone : ".$this->getTel();
        $etat .= " - adresse électronique : ".$this->getAdresseElectronique();
        $etat .= " - type : ".$this->getType();
        $etat .= " - civilité : ".$this->getCiviliteResponsable();
        $etat .= " - nom du responsable : ".$this->getNomResponsable();
        $etat .= " - prénom du responsable : ".$this->getPrenomResponsable();
        
        return $etat;
    }
    
}

