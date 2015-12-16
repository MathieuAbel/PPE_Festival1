<?php

namespace modele\metier;

class Offre {
    
    private $idEtab;
    private $idTypeChambre;
    private $nombreChambres;
    
    function __construct($idEtab, $idTypeChambre, $nombreChambres) {
        $this->idEtab = $idEtab;
        $this->idTypeChambre = $idTypeChambre;
        $this->nombreChambres = $nombreChambres;
    }
    
    function getIdEtab() {
        return $this->idEtab;
    }

    function getIdTypeChambre() {
        return $this->idTypeChambre;
    }

    function getNombreChambres() {
        return $this->nombreChambres;
    }

    function setIdEtab($idEtab) {
        $this->idEtab = $idEtab;
    }

    function setIdTypeChambre($idTypeChambre) {
        $this->idTypeChambre = $idTypeChambre;
    }

    function setNombreChambres($nombreChambres) {
        $this->nombreChambres = $nombreChambres;
    }
    
    public function __toString() {
        $etat = "objet de type : ".get_class($this);
        $etat .= " - identifiant établissement : ".$this->getIdEtab();
        $etat .= " - identifiant du type de chambre : ".$this->getIdTypeChambre();
        $etat .= " - nombre de chambre : ".$this->getNombreChambres();
        
        return $etat;
    }
    
}