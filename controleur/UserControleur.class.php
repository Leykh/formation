<?php
require_once "model/UsersDao.class.php";
require_once "outil/Securite.class.php";

class UserControleur {
    private $userDao;
    private $inscritDao;
    
    public function __construct(){
        $this->userDao = UsersDao::getInstance();
        $this->inscritDao = InscritDao::getInstance();
    }
    function accepterCookie(){
        require "vue/afficherCookieConsent.view.php";
    }
    function creerCompteAbonne(){
        $alert = "";
        require "vue/creerAbonne.view.php";
    }
    function creerAbonneValidation($login,$mail,$password,$mentions,$perso){
        $alert = "";
        if(!$mentions || !$perso){
            $alert = "Vous devez valider les cases à cocher pour pouvoir créer un compte abonné"; 
            require "vue/creerAbonne.view.php";
        }
        else {
            $cle = uniqid();
            $this->sendMailAbonne($login, $mail,$cle);
            $hash = password_hash($password, PASSWORD_DEFAULT);
            echo "hash=".$hash."<br>";
            $user=new User($login, $hash, $mail, "abonne","profils/profil.png", 0);
            $this->userDao->creerAbonne($user, $cle);
            header("Location: index.php?action=login");
        }
    }
    private function sendMailAbonne($login,$mail,$cle){
        $urlVerification = "http://localhost/formation/index.php?action=valider-abonne&login=".$login."&cle=".$cle;
        $sujet = "Création du compte sur le site Alcatar";
        $message = "Pour valider votre compte veuillez cliquer sur le lien suivant ".$urlVerification;
        Outils::sendMail($mail,$sujet,$message);
    }
    function recevoirMailAbonneValidation($login,$cle){
        $state = $this->userDao->validerAbonne($login,$cle);
        if($state == false)
            throw new Exception ("Le lien est incorrecte, votre compte n'est pas validé");
        $alert="";
        require "vue/login.view.php";
    }
    function login(){
        $alert="";
        if(!Securite::isConnected()){
            require "vue/login.view.php";
        }
        else header("Location: index.php?action=afficher-profil");
    }
    function loginValidation($login,$password){
        $alert="";
        if(!$this->userDao->isExistLoginUser($login)){
            throw new Exception("Le login n'existe pas");
        }
        else {
            if(isset($login) && !empty($login)
                     && isset($password) && !empty($password))        
            {
                if($this->userDao->isAbonneValide($login)){
                    echo "user valide";
                    echo "password=".$password."<br>";
                    $passwdHashbd = $this->userDao->getPasswdHashUser($login);
                    echo "passwdHash bd=".$passwdHashbd."<br>";
                    if(password_verify($password, $passwdHashbd)){
                        echo "password_verify OK";  
                        $_SESSION['login'] = $login; 
                        $_SESSION['role'] = $this->userDao->getRoleByLogin($login);
                        header("Location: index.php?action=afficher-profil");
                    }
                    else {
                        $alert = "Mot de passe invalide";
                        require "vue/login.view.php";
                    }
                }
                else {
                    $alert = "Vous devez valider votre compte via votre mail";
                    require "vue/login.view.php";
                }
            } else {
                $alert = "Saisir un nom d'utilisateur et un mot de passe";
                require "vue/login.view.php";
            }
        }
    }
    function afficherProfil(){
        $user = $this->userDao->findUserByLogin($_SESSION['login']);
        require "vue/afficherProfil.view.php";
    }
    function supprimerCompteAbonne(){
        if($_SESSION['role'] == 'abonne'){
            if(!$this->inscritDao->isExistInscritByLogin($_SESSION['login'])){
                $user = $this->userDao->supprimerUser($_SESSION['login']);
                session_unset(); 
                echo "session_unset() ";
                require "vue/accueil.view.php";
            }
            else {
                throw new Exception("Impossible de supprimer votre compte car des inscrits y font référence");
            }
        }
        else {
            require "vue/afficherProfil.view.php";
        }
    }
    function logout(){
        if(Securite::isConnected()){
            unset($_SESSION['role']);
            unset($_SESSION['nom']);
            header("Location: index.php");
        }
        else throw new Exception("Vous n'êtes pas connecté, vous ne pouvez vous délogger");
    }
    function administrerUtilisateur(){
        if(Securite::verifAccessAdmin()){
            $users = $this->userDao->findAllUser();
            require "vue/administrerUtilisateur.view.php";
        }
        else throw new Exception("Vous n'avez pas le droit d'accéder à cette page");
    }
    function supprimerUser($login){
        if(Securite::verifAccessAdmin()){
            if(!$this->inscritDao->isExistInscritByLogin($login)){
                $this->userDao->supprimerUser($login);
                header("Location: index.php?action=administrer-utilisateur");
            }
            else {
                throw new Exception("Impossible de supprimer votre compte car des inscrits y font référence");
            }
        }
        else throw new Exception("Vous n'avez pas le droit d'accéder à cette page");
    }
    function formulaireModifierUser($login){
        if(Securite::verifAccessAdmin()){
            $user = $this->userDao->findUserByLogin($login);
        require "vue/modifierUtilisateur.view.php";
        }
    }
    function modifierUserValidation($old_login, $login,$mail,$role,$valide,$password,$image){
        $this->userDao->modifierUser($old_login,$login,$password,$mail,$role,$valide,$image);
    }
}

