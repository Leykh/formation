<?php
require_once "model/FormationDao.class.php"; 
require_once "./outil/Outils.class.php";
require_once "model/InscritDao.class.php"; 
require_once "model/Inscrit.class.php"; 
require_once "model/RessourceDao.class.php"; 

class FormationsController{
    private $formationDao;
    private $inscritDao;

    public function __construct(){
        $this->formationDao = FormationDao::getInstance();
        $this->inscritDao = InscritDao::getInstance();
        $this->ressourceDao = RessourceDao::getInstance();
    }
    function afficherAccueil(){
        $formations = $this->formationDao->findAllFormationLastAdded(3);
        require "vue/accueil.view.php";
    }
    function afficherCatalogue(){
        $alert = "";
        $formations=$this->formationDao->findAllFormation();
        foreach($formations as $formation){
            $del = array_search($formation,$formations);
            if(isset($_SESSION['login']) && $this->inscritDao->verifInscritFormation($_SESSION['login'],$formation->getId())){
                unset($formations[$del]);
            }
        }
        if(isset($_SESSION['formations'])){
            foreach($formations as $formation){
                $id = $formation->getid(); 
                $idverif = array_search($id,$_SESSION['formations']);
                if (array_search($id,$_SESSION['formations']))
                {
                    $del = array_search($formation,$formations);
                    unset($formations[$del]);
                }
            }
        }
        require "vue/afficherCatalogue.view.php";
    }
    function afficherFormation($id){
        $formation=$this->formationDao->findOneFormationById($id);
        if(isset($_SESSION['login'])){
            $inscrit=$this->inscritDao->verifInscritFormation($_SESSION['login'],$id);
        }
        require "./vue/afficherFormation.view.php";
    }
    function afficherPanierInscrit(){
        $alert="";
        if(isset($_SESSION['formations'])){   
            foreach($_SESSION['formations'] as $id){
                $formations[]=$this->formationDao->findOneFormationById($id);
            }
        }
        if(!isset($formations) || empty($formations)){
            $alert="Votre panier est vide, sélectionnez en dans le catalogue";
        }
        require "vue/afficherPanierInscrit.view.php";
    }
    function supprimerFormation($id){ 
        if(Securite::verifAccessAdmin()){           
            if(!$this->inscritDao->existInscritByidFormation($id)){
                $nomImage = $this->formationDao->findOneFormationById($id)->getImage();
                $this->formationDao->supprimerFormation($id);
                unlink("public/images//".$nomImage);
                header("Location: index.php?action=administrer-formation");
            }    
            else throw new Exception("Impossible de supprimer le formation car des inscrits y font référence");
        }
        else throw new Exception("Vous n'avez pas les droit nécessaires");
    }
    function creerFormationVue(){
        if(Securite::verifAccessAdmin() || Securite::verifAccessCfa()){
            require "./vue/creerFormation.view.php";
        }
        else throw new Exception("Vous n'avez pas le droit d'accéder à cette page");
    }
    function creerValidationFormation($nom,$cout,$description){
        if(Securite::verifAccessAdmin() || Securite::verifAccessCfa()){
            $file = $_FILES['image'];
            $repertoire = "public/images//";
            $nomImageAjoute = Outils::ajouterImage($file,$repertoire);
            $this->formationDao->creerFormation($nom,$cout,$nomImageAjoute,$description,$_SESSION['login']);
            header("Location: index.php?action=administrer-formation");
        }
        else throw new Exception("Vous n'avez pas les droit nécessaires");
    }
    function afficherCardFormations(){
        $formations=$this->formationDao->findAllFormation();
        require "vue/cardFormations.view.php";
    }
    function modifierFormationVue($id){ 
        if(Securite::verifAccessAdmin()){
            $formation=$this->formationDao->findOneFormationById($id);
            require "vue/modifierFormation.view.php";
        }
        else if(Securite::verifAccessCfa()){
            $formation=$this->formationDao->findOneFormationById($id);
            if ($formation->getCreateur() == $_SESSION['login']){
                require "vue/modifierFormation.view.php";
            }
        }
        else throw new Exception("Vous n'avez pas le droit d'accéder à cette page");
    }
    function modifierFormationValidation($id,$nom,$cout,$description,$image){
        if(Securite::verifAccessAdmin()){
            Outils::afficherTableau($_POST,"POST");
            $repertoire = "public/images//";
            $nomImageAjoute = $image;
            $file = $_FILES['image'];
            Outils::afficherTableau($file,"file");
            $repertoire = "public/images//";
            if($_FILES['image']['size'] > 0){
                unlink($repertoire.$nomImageAjoute);
                $nomImageAjoute = Outils::ajouterImage($file,$repertoire);
            }
            
            $formations=$this->formationDao->modifierFormation($id,$nom,$cout,$description,$nomImageAjoute);
            header("Location: index.php?action=administrer-formation");
        }
        else throw new Exception("Vous n'avez pas les droit nécessaires");
    }
    function ajouterFormationPanier($id){
        $alert="";
        if(empty($_SESSION['formations'])){
            $_SESSION['formations'] = array();
        }
        if(in_array($id, $_SESSION['formations'])){
            throw new Exception("Vous avez déjà commander cette formation");
        }
        else {
            $_SESSION['formations'][$id]=$id;
        }
        header("Location: index.php?action=afficher-catalogue");
    }
    function supprimerFormationPanier($id){
        $del = array_search($id,$_SESSION['formations']);
        if(isset($del)){
            unset($_SESSION['formations'][$del]);
        }
        header("Location: index.php?action=afficher-panier");
    }
    function administrerFormations(){
        if(Securite::verifAccessAdmin() || Securite::verifAccessCfa()){
            $tabFormations=$this->formationDao->findAllFormation();
                if(isset($_SESSION['login'])){
                    $login = $_SESSION['login'];
                }
            require "vue/administrerFormations.view.php";
        }
    }
    
    function creerRessourceVue($id){
        if(Securite::verifAccessAdmin() || Securite::verifAccessCfa()){
            $formation=$this->formationDao->findOneFormationById($id);
            require "./vue/creerRessource.view.php";
        }
        else throw new Exception("Vous n'avez pas le droit d'accéder à cette page");
    }
    function creerValidationRessource($idformation,$descr){
        if(Securite::verifAccessAdmin() || Securite::verifAccessCfa()){
            $file = $_FILES['ressource'];
            $repertoire = "public/ressources/1//";
            $nomRessourceAjoute = Outils::ajouterImage($file,$repertoire);
            $this->ressourceDao->creerRessource($idformation,$descr,$nomRessourceAjoute);
            header("Location: index.php?action=lister-inscrit-formation".$idformation);
        }
        else throw new Exception("Vous n'avez pas les droit nécessaires");
    }
}
?>