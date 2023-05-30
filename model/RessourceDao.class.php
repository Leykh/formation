<?php
require_once "Connexion.class.php";
require_once "Formation.class.php";
require_once "Ressource.class.php";

class RessourceDao extends Connexion {
    private static $_instance = null;
    
    private function __construct() {}
    public static function getInstance() {
        if(is_null(self::$_instance)) {
            self::$_instance = new RessourceDao();  
        }
        return self::$_instance;
    }
    public function findAllRessource(){
        $stmt = $this->getBdd()->prepare(
            "SELECT * FROM formationmodules");
        $nb = $stmt->execute();
        $moduleListBd = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        if(isset($moduleListBd)){
            foreach($moduleListBd as $ressourceBd){
                $ressource = new Ressource($ressourceBd['idmodules'], $ressourceBd['idformation'], $ressourceBd['description'], $ressourceBd['ressource']);
                $ressources[]=$ressource;
            }
            return $ressources;
        }
    }
    function findAllRessourceById($id){
        $stmt = $this->getBdd()->prepare("SELECT * FROM formationmodules WHERE idformation=:id");
        $stmt->bindValue(":id",$id,PDO::PARAM_STR);
        $cpt = $stmt->execute();
        $moduleListBd = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        if(isset($moduleListBd)){
            foreach($moduleListBd as $ressourceBd){
                $ressource = new Ressource($ressourceBd['idmodules'], $ressourceBd['idformation'],  $ressourceBd['description'], $ressourceBd['ressource']);
                $ressources[]=$ressource;
            }
            return isset($ressources) ? $ressources : array(1 => new Ressource (1,$id,"Aucune ressource pour le moment",""));
        }
    }
    function creerRessource($idformation,$description,$ressource){
        $pdo = $this->getBdd();
        $req = "
        INSERT INTO formationmodules (idformation, description, ressource)
        values (:idformation, :description, :ressource)";
        $stmt = $pdo->prepare($req);
        $stmt->bindValue(":idformation",$idformation,PDO::PARAM_INT);
        $stmt->bindValue(":description",$description,PDO::PARAM_STR);
        $stmt->bindValue(":ressource",$ressource,PDO::PARAM_STR);
        $resultat = $stmt->execute();
        $stmt->closeCursor();
    }
    function supprimerRessource($id,$idm){
        $pdo = $this->getBdd();
        $req = "Delete from formationmodules where idformation = :id AND idmodules = :idm";
        $stmt = $pdo->prepare($req);
        $stmt->bindValue(":id",$id,PDO::PARAM_INT);
        $stmt->bindValue(":idm",$idm,PDO::PARAM_INT);
        $resultat = $stmt->execute();
        $stmt->closeCursor();
    }
}
?>