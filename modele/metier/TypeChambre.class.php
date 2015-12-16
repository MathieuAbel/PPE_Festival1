<?php

namespace modele\metier;

class TypeChambre {
    
    private $id;
    private $libelle;
    
    function __construct($id, $libelle) {
        $this->id = $id;
        $this->libelle = $libelle;
    }
    
    function getId() {
        return $this->id;
    }

    function getLibelle() {
        return $this->libelle;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setLibelle($libelle) {
        $this->libelle = $libelle;
    }
    
    public function __toString() {
        $etat = "objet de type : ".get_class($this);
        $etat .= " - identifiant : ".$this->getId();
        $etat .= " - libellé : ".$this->getLibelle();
        
        return $etat;
    }
    
}