<?php
require_once "./model/FormationDao.class.php"; 

$formationDao = FormationDao::getInstance();

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
}
