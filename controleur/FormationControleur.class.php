<?php
require_once "model/FormationDao.class.php"; 
require_once "./outil/Outils.class.php";
require_once "model/InscritDao.class.php"; 
require_once "model/Inscrit.class.php"; 
require_once "model/RessourceDao.class.php"; 

class FormationsController{
    private $formationDao;
    private $inscritDao;
    private $ressourceDao;

    public function __construct(){
        $this->formationDao = FormationDao::getInstance();
        $this->inscritDao = InscritDao::getInstance();
        $this->ressourceDao = RessourceDao::getInstance();
    }
    function afficherAccueil(){
        require "vue/accueil.view.php";
    }
    function afficherCatalogue(){
        $alert = "";
        $formations=$this->formationDao->findAllFormation();
        foreach($formations as $formation){
            $del = array_search($formation,$formations);
            if($this->inscritDao->verifInscritFormation($_SESSION['login'],$formation->getId())){
                unset($formations[$del]);
            }
        }
        require "vue/afficherCatalogue.view.php";
    }
    function afficherFormation($id){
        $formation=$this->formationDao->findOneFormationById($id);
        $ressources=$this->ressourceDao->findAllRessourceById($id);
        $inscrit=$this->inscritDao->verifInscritFormation($_SESSION['login'],$id);
        require "vue/afficherformation.view.php";
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
                unlink("public/images/".$nomImage);
                header("Location: index.php?action=administrer-formation");
            }    
            else throw new Exception("Impossible de supprimer le formation car des inscrits y font référence");
        }
        else throw new Exception("Vous n'avez pas les droit nécessaires");
    }
    function creerFormationVue(){
        if(Securite::verifAccessAdmin()){
            require "vue/creerformation.view.php";
        }
        else throw new Exception("Vous n'avez pas le droit d'accéder à cette page");
    }
    function creerValidationFormation($nom,$cout,$description){
        if(Securite::verifAccessAdmin()){
            $file = $_FILES['image'];
            $repertoire = "public/images/";
            $nomImageAjoute = Outils::ajouterImage($file,$repertoire);
            $this->formationDao->creerFormation($nom,$cout,$nomImageAjoute,$description,$_SESSION['login']);
            header("Location: index.php?action=administrer-formation");
        }
        else throw new Exception("Vous n'avez pas les droit nécessaires");
    }
    function afficherCardFormations(){
        $formations=$this->formationDao->lireFormations();
        require "vue/cardFormations.view.php";
    }
    function modifierFormationVue($id){ 
        if(Securite::verifAccessAdmin()){
            $formation=$this->formationDao->findOneFormationById($id);
            require "vue/modifierFormation.view.php";
        }
        else throw new Exception("Vous n'avez pas le droit d'accéder à cette page");
    }
    function modifierFormationValidation($id,$nom,$cout,$description,$image){
        if(Securite::verifAccessAdmin()){
            Outils::afficherTableau($_POST,"POST");
            $repertoire = "public/images/";
            $nomImageAjoute = $image;
            $file = $_FILES['image'];
            Outils::afficherTableau($file,"file");
            $repertoire = "public/images/";
            if($_FILES['image']['size'] > 0){
                unlink($repertoire.$nomImageAjoute);
                $nomImageAjoute = Outils::ajouterImage($file,$repertoire);
            }
            
            $formations=$this->formationDao->modifierFormation($id,$nom,$cout,$description,$nomImageAjoute);
            header("Location: index.php?action=administrer-formation");
        }
        else throw new Exception("Vous n'avez pas les droit nécessaires");
    }
    function ajouerterFormationPanier($id){
        $alert="";
        if(!isset($_SESSION['formations'])){
            $_SESSION['formations'] = array();
        }
        if(in_array($id, $_SESSION['formations'])){
            echo $id." est déjà commander<br>";
            throw new Exception("Vous avez déjà commander ce formation");
        }
        else {
            $_SESSION['formations'][]=$id;
        }
        Outils::afficherTableau($_SESSION['formations'],"SESSION['formations']");
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
        $tabFormations=$this->formationDao->findAllFormation();
        $login = $_SESSION['login'];
        require "vue/administrerFormations.view.php";
    }
}
?>