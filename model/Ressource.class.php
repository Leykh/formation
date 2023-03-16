<?php
class Ressource implements JsonSerializable {
    private $idRessource;
    private $idFormation;
    private $ressource;
    private $description;
    
    function __construct($idRessource, $idFormation,$description,$ressource) {
        $this->idRessource= $idRessource;
        $this->idFormation= $idFormation;
        $this->ressource= $ressource;
        $this->description= $description;
    }

    public function setIdRessource($idRessource): void {
        $this->idRessource = $idRessource;
    }
    function getIdRessource() {
        return $this->idRessource;
    }

    public function setIdFormation($idFormation): void {
        $this->idFormation = $idFormation;
    }
    function getIdFormation() {
        return $this->idFormation;
    }

    public function setRessource($ressource): void {
        $this->ressource = $ressource;
    }
    function getRessource() {
        return $this->ressource;
    }
    
    public function setDescription($description): void {
        $this->description = $description;
    }
    function getDescription() {
        return $this->description;
    }

    public function jsonSerialize() {
        return [
            'idRessource' => $this->idRessource,
            'idFormation' => $this->idFormation,
            'description' => $this->description,
            'ressource' => $this->ressource
        ];
    }

}