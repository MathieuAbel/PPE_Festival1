<?php

namespace modele\metier;

class Attribution {
    
    private $idEtab;
    private $idTypeChambre;
    private $idGroupe;
    private $nombreChambre;
    
    function __construct($idEtab, $idTypeChambre, $idGroupe, $nombreChambre) {
        $this->idEtab = $idEtab;
        $this->idTypeChambre = $idTypeChambre;
        $this->idGroupe = $idGroupe;
        $this->nombreChambre = $nombreChambre;
    }
    
    function getIdEtab() {
        return $this->idEtab;
    }

    function getIdTypeChambre() {
        return $this->idTypeChambre;
    }

    function getIdGroupe() {
        return $this->idGroupe;
    }

    function getNombreChambre() {
        return $this->nombreChambre;
    }

    function setIdEtab($idEtab) {
        $this->idEtab = $idEtab;
    }

    function setIdTypeChambre($idTypeChambre) {
        $this->idTypeChambre = $idTypeChambre;
    }

    function setIdGroupe($idGroupe) {
        $this->idGroupe = $idGroupe;
    }

    function setNombreChambre($nombreChambre) {
        $this->nombreChambre = $nombreChambre;
    }
    
    public function __toString() {
        $etat = "objet de type : ".get_class($this);
        $etat.= " - identifiant établissement : ".$this->getIdEtab();
        $etat.= " - identifiant type de chambre : ".$this->getIdTypeChambre();
        $etat.= " - identifiant groupe : ".$this->getIdGroupe();
        $etat.= " - identifiant nombre de chambre : ".$this->getNombreChambre();
        
        return $etat;
    }
    
}