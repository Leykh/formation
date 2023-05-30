<?php ob_start(); ?>
<br>
<div class="row">
    <div class="col-4">
        <img  style="width:80%; height:auto" src="public/images//<?= $formation->getImage(); ?>">
    </div>
    <div class="col-8">
        <br>
        <h3>Cout : <?= $formation->getCout(); ?> €</h3>
        <br>
        <h3>Description :</h3> 
        <p><?= $formation->getDescription(); ?></p></a>
    </div>
</div>
<?php if(Securite::verifAccessAdmin() || Securite::verifAccessCfa() && $formation->getCreateur() == $_SESSION['login']){ ?>
    <div style='padding: 1em 1em 1em 1em;'>
        <a href="index.php?action=creer-ressource&id=<?php echo $formation->getid(); ?>" class="btn btn-primary">Ajouter une ressource</a>
    </div>
<?php } ?>
<?php if(Securite::isConnected() && $inscrit){ ?>
    <?php $ressources = $formation->getListeRessource(); $count=1; foreach($ressources as $ressource) { ?>
        <div class="col-4">
            <h4 scope="row"><?php echo $count; ?></h4>
            <p><?php echo $ressource->getDescription(); ?>
            <a style = text-decoration:none href="../public/ressources/<?= $ressource->getIdFormation(); ?>/<?= $ressource->getRessource(); ?>"><?php echo $ressource->getRessource(); ?></a></p>
          </div>
            <?php $count+=1; } ?>
    <?php } ?>
<?php
$content = ob_get_clean();
$titre = $formation->getNom();
require "template.view.php";
?>