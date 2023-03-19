<?php
require_once "./model/FormationDao.class.php"; 
require_once "./model/RessourceDao.class.php"; 

$formationDao = FormationDao::getInstance();
$ressourceDao = RessourceDao::getInstance();

if(isset($_GET["operation"])){
    if($_GET["operation"]=="lister"){
        try{
            $formations=$formationDao-> findAllFormation();
            print("lister#");
            print(json_encode($formations));
            echo(json_encode($formations));
        }catch(PDOException $e){
            print "erreur#".$e->getMessage();
        }
    }
    if($_GET["operation"]=="ressource"){
        try{
        $ressources=$ressourceDao-> findAllRessource();
        print("ressource#");
        print(json_encode($ressources));
        echo(json_encode($ressources));
    }catch(PDOException $e){
        print "erreur#".$e->getMessage();
    }
}
}