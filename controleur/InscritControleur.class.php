<?php
require_once "model/FormationDao.class.php"; 
require_once "./outil/Outils.class.php";
require_once "model/InscritDao.class.php"; 
require_once "model/Inscrit.class.php"; 

class InscritControleur {
    private $inscritDao;
    private $formationDao;
    
    public function __construct(){
        $this->inscritDao = InscritDao::getInstance();
        $this->formationDao = FormationDao::getInstance();
    }
    public function verifierInscrit($login,$idFormation){
        return ($this->inscritDao->verifInscritFormation($login,$idFormation) > 0);
    }
    public function validerPanierInscrit(){
        echo date('Y-m-d H:i:s');
        if(isset($_SESSION['formations'])){
            $login = $_SESSION['login'];
            foreach ($_SESSION['formations'] as $idFormation) {
                $inscrit = new Inscrit($idFormation, $login);
                $inscrit = $this->inscritDao->creerInscrit($inscrit);
                $this->formationDao->decrementerNbFormation($idFormation);
            }
            unset($_SESSION['formations']);
            header("Location: index.php?action=lister-inscrit-formation");
        }
        else {
            header("Location: index?action=afficher-catalogue");
        }
    }
    public function listerInscritFormation(){
        $alert="";
        $inscritList = $this->inscritDao->findAllInscritByLogin($_SESSION['login']);
        if(isset($inscritList) && !empty($inscritList)){
            require "vue/listerInscritFormation.view.php";
        }
        else {
            $alert="Vous ne suivez aucune formation";
            require "vue/listerInscritFormation.view.php";
        }
    }
    public function retournerFormationInscrit($idInscrit, $idFormation){
        $this->inscritDao->setDateFin($idInscrit);
        $this->formationDao->incrementerNbFormation($idFormation);
        header("Location: index.php?action=lister-inscrit-formation");
    }
    public function afficherHistoriqueInscrit(){
        $alert="";
        $inscritHistoriqueList = $this->inscritDao->findAllInscritHistoriqueByLogin($_SESSION['login']);
        if(!isset($inscritHistoriqueList) || empty($inscritHistoriqueList)){
            $alert="Votre historique de formation est vide";
        }
        require "vue/afficherHistorique.view.php";
    }
    
}
?>

