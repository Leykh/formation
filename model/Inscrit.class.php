<?php

class Inscrit implements JsonSerializable{
    private $idInscrit;
    private $idFormation;
    private $login;
    private $dateDebut;
    private $dateFin;
    private $titreFormation;
    function __construct($idFormation, $login) {
        $this->idFormation= $idFormation;
        $this->login = $login;
        $this->dateDebut = date('Y-m-d H:i:s');
    }
    public function __toString() {
        return $this->idInscrit." ".$this->idFormation." ".$this->login." ".$this->dateDebut." ".$this->titreFormation." ".$this->dateFin." "."<br>";
    }
    public function jsonSerialize() {
        return [
            'idFormation' => $this->idFormation
        ];
    }
    
    function getIdInscrit() { return $this->idInscrit; }
    public function setIdInscrit($idInscrit): void { $this->idInscrit = $idInscrit; }

    function getNomFormation() { return $this->titreFormation; }
    public function setNomFormation($titreFormation): void { $this->titreFormation = $titreFormation; }

    function getidFormation() { return $this->idFormation; }
    function setIdFormation($idFormation): void { $this->idFormation = $idFormation; }

    function getLogin() { return $this->login; }
    function setLogin($login): void { $this->login = $login; }

    function getDateDebut() { return $this->dateDebut; }
    function setDateDebut($dateDebut): void { $this->dateDebut = $dateDebut; }

    function getDateFin() { return $this->dateFin; }
    function setDateFin($dateFin): void { $this->dateFin = $dateFin; }
}
?>
