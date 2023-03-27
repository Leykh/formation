<?php
require_once "./model/FormationDao.class.php"; 
require_once "./model/RessourceDao.class.php"; 
require_once "./model/UsersDao.class.php"; 
require_once "./model/InscritDao.class.php"; 
require_once "./outil/Outils.class.php"; 

$formationDao = FormationDao::getInstance();
$ressourceDao = RessourceDao::getInstance();
$userDao = UsersDao::getInstance();
$inscritDao = InscritDao::getInstance();

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
    if($_GET["operation"]=="mdp"){
        try{
            $login = $_GET["login"];
            $password = $_GET["password"];
            $passwdHashbd = $userDao->getPasswdHashUser($login);
            $formationUndefined[] = array('id' => '-1','nom' => 'undefined','description' => 'undefined','cout' => '-1', 'image' => 'undefined');
            print("mdp#");
            if(password_verify($password, $passwdHashbd)){
            $inscriptions = $inscritDao->findAllInscritByLogin($login);
                foreach($inscriptions as $inscrit){
                    $formation = $formationDao->findOneFormationById($inscrit->getidFormation());
                    $formations[] = $formation;
                    }
                if(!isset($formations)){ 
                    $arr = array('login' => $login, 'verif' => 'vrai','formations' => $formationUndefined);
                    print(json_encode($arr));
                }
                else{ 
                $arr = array('login' => $login, 'verif' => 'vrai','formations' => $formations);
                print(json_encode($arr));
                }
            }
            else {
                $arr = array('login' => $login, 'verif' => 'faux','formations' => $formationUndefined);
                print(json_encode($arr));
            }
        }catch(PDOException $e){
            print "erreur#".$e->getMessage();
        }
    }
}
?>