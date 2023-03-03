<?php
    if(isset($_GET['cookie-accept'])){
        setcookie('cookie-accept','true', time() + 3600); 
        header("Location: index.php");
    }
    require_once "outil/Securite.class.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/style.css" type="text/css" media="screen" />
    <title><?php echo $titre ?></title>
</head>
<body >
<div class="container">
    <h1 class="relief">CAFOMA</h1>
    <h1 class="relief"><h1>
</div>
    <div class="container">
        <div class="row">
            <div class="col-11">
                <ul class="nav">
                    <li class="nav-item">
                        <a class="nav-link active" href="index.php">Accueil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?action=afficher-catalogue">Catalogue</a> <?php ?>
                    </li>
                    <?php if(Securite::isConnected()){ ?>
                        <li class="nav-item">
                            <a class="nav-link" href="index.php?action=afficher-panier">Panier</a> 
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="index.php?action=lister-inscrit-formation">Mes formations</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="index.php?action=afficher-profil">Profil</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="index.php?action=afficher-historique-inscrit">Historique</a>
                        </li>
                    <?php } ?>    
                    <?php if(!Securite::isConnected()){ // si non connecté ?>
                        <?php if(Securite::autoriserCookie()){ ?>
                            <li class="nav-item">
                                <a class="nav-link" href="index.php?action=creer-abonne">Créer compte</a>
                            </li>
                        <?php } ?>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?action=android">application android</a>
                    </li>
                    <?php } ?>
                    <?php if(Securite::verifAccessAdmin()){ ?>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?action=administrer-formation">Administration formation</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?action=administrer-utilisateur">Administrer utilisateur</a>
                    </li>
                    <?php } ?>
                </ul>
            </div>
            <div class="col-1 text-right">
                <?php if(Securite::autoriserCookie()){ ?>
                    <?php if(Securite::isConnected()){ ?>
                        <a class="nav-link text-center" href="index.php?action=logout">logout</a>
                    <?php } else { ?>
                        <a class="nav-link text-center" href="index.php?action=login">login</a>
                    <?php } ?>
                <?php } ?>
            </div>
       </div>
    </div>            
            
    <div class="container">
        <h2><?php echo $titre ?></h2>
        <?php echo $content ?>
    </div>
   
    <div class="container">

        <footer>
            <h6>Copyright perroquet - Tous droits réservés</h6>
            <p class="text-center">
                <a href="index.php?action=mentions-legales">Mentions légales</a>
                <a href="index.php?action=cookies">Cookies</a>
                <a href="index.php?action=donnees-personnelles">Données personnelles</a>
            </p>
        </footer>
    </div>
    
    <?php if(!isset($_COOKIE['cookie-accept'])){ ?>
    <div class="banniere">
        <div class="text-banniere">
            <p>
                Notre site utilise un cookies de session pour l'authentification et d'autres fonctions pour utiliser nos services.<br>
                Voire notre <a href="index.php?action=cookies">politique en matiére de cookie</a><br>
                Voire notre <a href="index.php?action=donnees-personnelles">politique relatif aux données personnelles</a>
            </p>
        </div>
        <div class="button-banniere">
            <a href="?cookie-accept">OK, j'accepte</a>
        </div>
    </div>
    <?php } ?>
</body>
</html>