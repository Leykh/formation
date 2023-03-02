<?php
require_once "controleur/FormationControleur.class.php";
require_once "outil/Outils.class.php";
require_once "outil/Securite.class.php";
require_once "controleur/UserControleur.class.php";
require_once "controleur/InscritControleur.class.php";


if (Securite::autoriserCookie()){
    session_start();
    echo Securite::isConnected() ? 'true ' : 'false ';
    $id_session = session_id();
    echo "id_session : ". $id_session;
}
 
$formationController = new FormationsController();
$userControleur = new UserControleur();
$inscritController = new InscritControleur();   

try{
    if(empty($_GET['action']) || !isset($_GET['action'])){
        $formationController->afficherAccueil();
    }
    else switch ($_GET['action']){
        case "afficher-catalogue": $formationController->afficherCatalogue();
        break;
        case "afficher-formation": $formationController->afficherFormation($_GET['id']);
        break;
        case "creer-abonne": $userControleur->creerCompteAbonne();
        break;
        case "creer-abonne-validation": $userControleur->creerAbonneValidation($_POST['login'], $_POST['mail'],$_POST['passwd'], isset($_POST['mentions']),isset($_POST['perso']));
        break;
        case "valider-abonne": $userControleur->recevoirMailAbonneValidation($_GET['login'],$_GET['cle']);
        break;
        case "login": $userControleur->login();
        break;
        case "login-validation": $userControleur->loginValidation($_POST['login'], $_POST['password']);
        break;
        case "afficher-profil": $userControleur->afficherProfil();
        break;
        case "supprimer-abonne": $userControleur->supprimerCompteAbonne();
        break;
        case "logout":  $userControleur->logout();
        break;
        case "afficher-panier":  $formationController->afficherPanierInscrit();
        break;
        case "ajouter-formation-panier":  $formationController->ajouerterFormationPanier($_GET['id']);
        break;
        case "supprimer-formation-panier":  $formationController->supprimerFormationPanier($_GET['id']);
        break; 
        case "valider-panier":  $inscritController->validerPanierInscrit();
        break;
        case "lister-inscrit-formation":  $inscritController->listerInscritFormation();
        break;
        case "retourner-inscrit-formation":  $inscritController->retournerFormationInscrit($_GET['idInscrit'], $_GET['idFormation']);
        break;
        case "afficher-historique-inscrit": $inscritController->afficherHistoriqueInscrit();
        break;
        case "administrer-formation":  $formationController->administrerFormations();
        break;
        case "supprimer-formation":  $formationController->supprimerFormation($_GET['id']);
        break;
        case "modifier-formation": $formationController->modifierFormation($_GET['id']);
        break;
        case "modifier-formation-validation": $formationController->modifierFormationValidation($_POST['id'],$_POST['nom'],$_POST['descr'],$_POST['cout'],$_POST['image']);
        break;
        case "creer-formation": $formationController->creerFormation();
        break;
        case "creer-formation-validation": $formationController->creerValidationFormation($_POST['nom'],$_POST['nb'],$_POST['nbPages'],$_POST['descr']);
        break;
        case "administrer-utilisateur": $userControleur->administrerUtilisateur();
        break;
        case "supprimer-user": $userControleur->supprimerUser($_GET['user']);
        break;//
        case "modifier-user": $userControleur->formulaireModifierUser($_GET['user']); // a creer
        break;
        case "modifier-user-validation": $userControleur->modifierUserValidation($_POST['login'],$_POST['newlogin'],$_POST['mail'],$_POST['role'],$_POST['valide'],$_POST['password'],$_POST['image']);// a creer
            $userControleur->administrerUtilisateur();
        break;
        case "mentions-legales": require "vue/mentionLegale.view.php";
        break;
        case "cookies": require "vue/cookies.view.php";
        break;
        case "donnees-personnelles": require "vue/donneesPersonnelles.view.php";
        break;
        case "afficher-auteur": $AuteurEditeurConroller->lireAuteur($_GET['idAuteur']);
        break;
        case "gerer-auteur": $AuteurEditeurConroller->gererAllAuteur();
        break;
        case "creer-auteur-validation": $AuteurEditeurConroller->creerAuteurValidation();
        break;
        case "gerer-editeur": $AuteurEditeurConroller->gererAllEditeur();
        break;
        case "creer-editeur-validation": $AuteurEditeurConroller->creerEditeurValidation();
        break;
        case "android": require "vue/android.view.php";
        break;
        case "supprimer-cookie": echo "supprimer-cookie";
            session_destroy();
            setcookie('cookie-accept', '', time()-3600, '/', '', false, false);
            header("Location: index.php");
        break;
        default: throw new Exception("La page n'existe pas");
    }
}catch(Exception $e){
    $title = "Erreur";
    $erreurMsg = $e->getMessage();
    require "vue/erreur.view.php";
}
?>