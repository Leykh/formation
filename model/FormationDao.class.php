<?php
require_once "Connexion.class.php";
require_once "Formation.class.php";

class FormationDao extends Connexion {
    private static $_instance = null;
    
    public static function getInstance() {
        if(is_null(self::$_instance)) {
            self::$_instance = new FormationDao();  
        }
        return self::$_instance;
    }
    function findAllFormation(){
        $stmt = $this->getBdd()->prepare("SELECT * FROM formations");
        $stmt->execute();
        $bddFormations = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        foreach($bddFormations as $formation){
            $l=new Formation($formation['id'], $formation['nom'], $formation['description'], $formation['cout'], $formation['image'],$formation['createur']);
            $formations[]=$l;
        }
        return $formations;
    }
    function findOneFormationById($id){
        $stmt = $this->getBdd()->prepare("SELECT * FROM formations WHERE id=:id");
        $stmt->bindValue(":id",$id,PDO::PARAM_STR);
        $cpt = $stmt->execute();
        $formation = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        $l=new Formation($formation['id'], $formation['nom'], $formation['description'], $formation['cout'], $formation['image'],$formation['createur']);
        
        return $l;
    }
    function creerFormation($nom,$cout,$image,$description,$createur){
        $pdo = $this->getBdd();
        $req = "
        INSERT INTO formations (nom, cout, image, description,createur)
        values (:nom, :cout, :image, :description,:createur)";
        $stmt = $pdo->prepare($req);
        $stmt->bindValue(":nom",$nom,PDO::PARAM_STR);
        $stmt->bindValue(":cout",$cout,PDO::PARAM_STR);
        $stmt->bindValue(":image",$image,PDO::PARAM_STR);
        $stmt->bindValue(":description",$description,PDO::PARAM_STR);
        $stmt->bindValue(":createur",$createur,PDO::PARAM_STR);
        $resultat = $stmt->execute();
        $stmt->closeCursor();
        if($resultat > 0){
            echo "formation insérer id=".$pdo->lastInsertId()."<br>";
        }        
    }
    function supprimerFormation($id){
        $pdo = $this->getBdd();
        
        $req = "Delete from formations where id = :idFormation";
        $stmt = $pdo->prepare($req);
        $stmt->bindValue(":idFormation",$id,PDO::PARAM_INT);
        $resultat = $stmt->execute();
        $stmt->closeCursor();
        if($resultat > 0){
            echo "formation supprimer id=".$id."<br>";
        }
    }
    function supprimerAllFormation(){
        $pdo = $this->getBdd();
        $req = "Delete from formations";
        $stmt = $pdo->prepare($req);
        $nbr = $stmt->execute();
        return $nbr;
    }
    function modifierFormation($id,$nom,$cout,$description,$image){
        $pdo = $this->getBdd();
        $req = "
        update formations 
        set nom = :nom, cout = :cout, image = :image, description = :description
        where id = :id";
        $stmt = $pdo->prepare($req);
        $stmt->bindValue(":id",$id,PDO::PARAM_INT);
        $stmt->bindValue(":nom",$nom,PDO::PARAM_STR);
        $stmt->bindValue(":cout",$cout,PDO::PARAM_STR);
        $stmt->bindValue(":image",$image,PDO::PARAM_STR);
        $stmt->bindValue(":description",$description,PDO::PARAM_STR);
        $resultat = $stmt->execute();
        $stmt->closeCursor();

        if($resultat > 0){
            echo "formation modifier id=".$id."<br>";
        }
    }
    function decrementerNbFormation($idFormation){
        $pdo = $this->getBdd();
        $req = "
        update formations 
        set nb = nb - 1
        where id = :id";
        $stmt = $pdo->prepare($req);
        $stmt->bindValue(":id",$idFormation,PDO::PARAM_INT);
        $resultat = $stmt->execute();
        $stmt->closeCursor();       
        if($resultat > 0){
            echo "formation modifier id=".$idFormation."<br>";
        }
    }
    function incrementerNbFormation($idFormation){
        $pdo = $this->getBdd();
        $req = "
        update formations 
        set nb = nb + 1
        where id = :id";
        $stmt = $pdo->prepare($req);
        $stmt->bindValue(":id",$idFormation,PDO::PARAM_INT);
        $resultat = $stmt->execute();
        $stmt->closeCursor();       
        if($resultat > 0){
            echo "formation modifier id=".$idFormation."<br>";
        }
    }
    function findTitreFormationById($idFormation){ 
        $stmt = $this->getBdd()->prepare(
            "SELECT titre FROM formations WHERE id= :idFormation");
        $stmt->bindValue(":idFormation",$idFormation,PDO::PARAM_INT);
        $nb = $stmt->execute();
        $imageBd = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt->closeCursor();  
        return $imageBd['titre'];
    }
    public function findAllFormationByIdCreateur($createur){
        $stmt = $this->getBdd()->prepare(
            "SELECT * FROM formations WHERE createur = :createur");
        $stmt->bindValue(":createur",$createur,PDO::PARAM_INT);
        $nb = $stmt->execute();
        $FormationListBd = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        if(isset($FormationListBd) && !empty($FormationListBd)){
            foreach($FormationListBd as $formationBd){
                $formation = new Formation($formationBd['id'], $formationBd['nom'], $formationBd['description'], $formationBd['cout'], $formationBd['image'],$formationBd['createur']);
                $formations[]=$formation;
            }
            return $formations;
        }
        else {
            return null;
        }
    }
}
?>