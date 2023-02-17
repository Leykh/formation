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
        //afficherTableau($inscritList, "inscritList");
        if(isset($inscritList) && !empty($inscritList)){
            require "vue/listerInscritFormation.view.php";
        }
        else {
            $alert="Vous n'avez pas de formation en attente de retour";
            require "vue/listerInscritFormation.view.php";
        }
    }
    public function retournerFormationInscrit($idInscrit, $idFormation){
        //echo "retourFormationInscrit idInscrit = ".$idInscrit."<br>";
        $this->inscritDao->setDateFin($idInscrit);
        $this->formationDao->incrementerNbFormation($idFormation);
        header("Location: index.php?action=lister-inscrit-formation");
    }
    public function afficherHistoriqueInscrit(){
        //echo "retourFormationInscrit idInscrit = ".$idInscrit."<br>";
        $alert="";
        $inscritHistoriqueList = $this->inscritDao->findAllInscritHistoriqueByLogin($_SESSION['login']);
        if(!isset($inscritHistoriqueList) || empty($inscritHistoriqueList)){
            $alert="Votre historique de formation inscrité est vide";
        }
        require "vue/afficherHistorique.view.php";
    }
    
}

