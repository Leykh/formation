<?php
class Formation implements JsonSerializable {
    private $id;
    private $nom;
    private $cout;
    private $image;
    private $description;
    private $createur;
    private $listeRessource = array();

    function __construct($id, $nom, $description, $cout, $image,$createur) {
        $this->id = $id;
        $this->nom = $nom;
        $this->description = $description;
        $this->cout = $cout;
        $this->image = $image;
        $this->createur = $createur;
    }
    public function __toString() {
        return "id=".$this->id." nom=".$this->nom." description=".$this->description." cout=".$this->cout." image=".$this->image;
    }

    public function jsonSerialize() {
        return [
            'id' => $this->id,
            'nom' => $this->nom,
            'description' => $this->description,
            'cout' => $this->cout,
            'image' => $this->image
        ];
    }
    public function getId(){return $this->id;}
    public function setId($id){$this->id = $id;}

    public function getNom(){return $this->nom;}
    public function setNom($nom){$this->nom = $nom;}

    public function getImage(){return $this->image;}
    public function setImage($image){$this->image = $image;}
    
    public function getDescription(){return $this->description;}
    public function setDescription($description){$this->description = $description;}

    public function getCout(){return $this->cout;}
    public function setCout($cout){$this->cout = $cout;}

    public function getCreateur(){return $this->createur;}
    public function setCreateur($createur){$this->createur = $createur;}
    
    public function getListeRessource(){return $this->listeRessource;}
    public function setListeRessource($listeRessource){$this->listeRessource = $listeRessource;}
    public function addListeRessource($ressource){array_push($this->listeRessource, $ressource);}
}
?>