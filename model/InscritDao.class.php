<?php
require_once "Connexion.class.php";
require_once "Formation.class.php";
require_once "Inscrit.class.php";
class InscritDao extends Connexion {
    private static $_instance = null;
    
    private function __construct() {}
    public static function getInstance() {
        if(is_null(self::$_instance)) {
            self::$_instance = new InscritDao();  
        }
        return self::$_instance;
    }
    public function findAllInscrit(){
        $stmt = $this->getBdd()->prepare(
            "SELECT * FROM formationinscrits");
        $nb = $stmt->execute();
        $inscritListBd = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        if(isset($inscritListBd)){
            foreach($inscritListBd as $inscritBd){
                $inscrit = new Inscrit($inscritBd['idFormation'], $inscritBd['login']);
                $inscrit->setIdInscrit($inscritBd['idInscrit']);
                $inscrit->setDateDebut($inscritBd['dateDebut']);
                $inscrit->setDateFin($inscritBd['dateFin']);
                $inscrits[]=$inscrit;
            }
            return $inscrits;
        }
    }
    public function findAllInscritByLogin($login){
        $stmt = $this->getBdd()->prepare(
            "SELECT idFormation, login, idInscrit, dateDebut, dateFin, nom "
                . " FROM formationinscrits "
                . " JOIN formations ON formationinscrits.idFormation = formations.id "
                . "WHERE login= :login AND dateFin IS NULL ORDER BY dateFin ASC");
        $stmt->bindValue(":login",$login,PDO::PARAM_STR);
        $nb = $stmt->execute();
        $inscritListBd = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        $inscritList = array();
        foreach($inscritListBd as $inscritBd){
            $inscrit = new Inscrit($inscritBd['idFormation'], $inscritBd['login']);
            $inscrit->setIdInscrit($inscritBd['idInscrit']);
            $inscrit->setDateDebut($inscritBd['dateDebut']);
            $inscrit->setDateFin($inscritBd['dateFin']);
            $inscrit->setNomFormation($inscritBd['nom']);
            $inscritList[]=$inscrit;
        }
        return $inscritList;
    }
    public function findAllInscritHistoriqueByLogin($login){
        $stmt = $this->getBdd()->prepare(
            "SELECT idFormation, login, idInscrit, dateDebut, dateFin, nom "
                . " FROM formationinscrits "
                . " JOIN formations ON formationinscrits.idFormation = formations.id "
                . "WHERE login= :login AND dateFin IS NOT NULL ORDER BY dateFin DESC");
        $stmt->bindValue(":login",$login,PDO::PARAM_INT);
        $nb = $stmt->execute();
        $inscritListBd = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        $inscritList = array();
        foreach($inscritListBd as $inscritBd){
            $inscrit = new Inscrit($inscritBd['idFormation'], $inscritBd['login']);
            $inscrit->setIdInscrit($inscritBd['idInscrit']);
            $inscrit->setDateDebut($inscritBd['dateDebut']);
            $inscrit->setDateFin($inscritBd['dateFin']);
            $inscrit->setNomFormation($inscritBd['nom']);
            $inscritList[]=$inscrit;
        }
        return $inscritList;
    }
    
    public function findOneInscrittById($idInscrit){ 
        $stmt = $this->getBdd()->prepare(
            "SELECT * FROM formationinscrits WHERE idInscrit= :idInscrit");
        $stmt->bindValue(":idInscrit",$idInscrit,PDO::PARAM_INT);
        $nb = $stmt->execute();
        $emprunBd = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt->closeCursor();  
        $inscrit = new Inscrit($emprunBd['idFormation'], $_SESSION['login']);
        $inscrit->setIdInscrit($emprunBd['idInscrit']);
        $inscrit->setDateDebut($emprunBd['dateDebut']);
        $inscrit->setDateFin($emprunBd['dateFin']);
        return $inscrit;
    }
    public function creerInscrit($inscrit){
        echo "creerInscrit inscrit=".$inscrit."<br>";
        $pdo = $this->getBdd();
        $req = "
            INSERT INTO formationinscrits (idFormation, login, dateDebut, dateFin)
            VALUES (:idFormation, :login, :dateDebut, null)";
        $stmt = $pdo->prepare($req);
        $stmt->bindValue(":idFormation",$inscrit->getidFormation(),PDO::PARAM_INT);
        $stmt->bindValue(":login",$inscrit->getLogin(),PDO::PARAM_STR);
        $stmt->bindValue(":dateDebut",$inscrit->getDateDebut(),PDO::PARAM_STR);
        $nb = $stmt->execute();
        $stmt->closeCursor();      
        if($nb > 0){
            return $pdo->lastInsertId();
        }
        return false;
    }
    public function setDateFin($idInscrit) {
        $dateFin = date('Y-m-d H:i:s');
        $pdo = $this->getBdd();
        $req = "
            UPDATE formationinscrits 
            SET dateFin = :dateFin 
            WHERE idInscrit = :idInscrit";
        $stmt = $pdo->prepare($req);
        $stmt->bindValue(":idInscrit",$idInscrit,PDO::PARAM_INT);
        $stmt->bindValue(":dateFin",$dateFin,PDO::PARAM_STR);
        $nb = $stmt->execute();
        echo "dateFin=".$dateFin." nb=".$nb."<br>";
        $stmt->closeCursor();
        return ($nb > 0);
    }
    public function existInscritByidFormation($idFormation){
        $stmt = $this->getBdd()->prepare(
            "SELECT count(idFormation) AS nb FROM formationinscrits WHERE idFormation = :idFormation");
        $stmt->bindValue(":idFormation",$idFormation,PDO::PARAM_INT);
        $stmt->execute();
        $nbFormationInscrit = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt->closeCursor(); 
        return ($nbFormationInscrit['nb'] > 0);
    }
    public function existInscritByLogin($login){
        $stmt = $this->getBdd()->prepare(
            "SELECT count(idInscrit) AS nb FROM formationinscrits WHERE login = :login");
        $stmt->bindValue(":login",$login,PDO::PARAM_STR);
        $stmt->execute();
        $nbInscrit = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt->closeCursor(); 
        return ($nbInscrit['nb'] > 0);
    }
    public function verifInscritFormation($login, $idFormation){
        $stmt = $this->getBdd()->prepare(
            "SELECT count(idFormation) AS nb FROM formationinscrits WHERE idFormation = :idFormation AND login LIKE :login AND dateFin IS NULL");
        $stmt->bindValue(":idFormation",$idFormation,PDO::PARAM_INT);
        $stmt->bindValue(":login",$login,PDO::PARAM_STR);
        $stmt->execute();
        $nbFormationInscrit = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt->closeCursor(); 
        return ($nbFormationInscrit['nb'] > 0);       
    }
}
?>