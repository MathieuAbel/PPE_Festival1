<?php

namespace modele\metier;

class Groupe {
    
    private $id;
    private $nom;
    private $identiteResponsable;
    private $adressePostale;
    private $nombrePersonnes;
    private $nomPays;
    private $hebergement;
    
    function __construct($id, $nom, $identiteResponsable, $adressePostale, $nombrePersonnes, $nomPays, $hebergement) {
        $this->id = $id;
        $this->nom = $nom;
        $this->identiteResponsable = $identiteResponsable;
        $this->adressePostale = $adressePostale;
        $this->nombrePersonnes = $nombrePersonnes;
        $this->nomPays = $nomPays;
        $this->hebergement = $hebergement;
    }
    
    function getId() {
        return $this->id;
    }

    function getNom() {
        return $this->nom;
    }

    function getIdentiteResponsable() {
        return $this->identiteResponsable;
    }

    function getAdressePostale() {
        return $this->adressePostale;
    }

    function getNombrePersonnes() {
        return $this->nombrePersonnes;
    }

    function getNomPays() {
        return $this->nomPays;
    }

    function getHebergement() {
        return $this->hebergement;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setNom($nom) {
        $this->nom = $nom;
    }

    function setIdentiteResponsable($identiteResponsable) {
        $this->identiteResponsable = $identiteResponsable;
    }

    function setAdressePostale($adressePostale) {
        $this->adressePostale = $adressePostale;
    }

    function setNombrePersonnes($nombrePersonnes) {
        $this->nombrePersonnes = $nombrePersonnes;
    }

    function setNomPays($nomPays) {
        $this->nomPays = $nomPays;
    }

    function setHebergement($hebergement) {
        $this->hebergement = $hebergement;
    }
    
    public function __toString() {
        $etat = "objet de type : ".get_class($this);
        $etat .= " - identifiant : ".$this->getId();
        $etat .= " - nom : ".$this->getNom();
        $etat .= " - identité du responsable : ".$this->getIdentiteResponsable();
        $etat .= " - adresse postal : ".$this->getAdressePostale();
        $etat .= " - nombre de personne : ".$this->getNombrePersonnes();
        $etat .= " - nom du pays : ".$this->getNomPays();
        $etat .= " - hébergement : ".$this->getHebergement();
        
        return $etat;
    }
    
}