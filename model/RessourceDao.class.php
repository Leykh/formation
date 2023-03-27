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
}
?>