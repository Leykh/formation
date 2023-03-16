<?php ob_start(); ?>
<br>
<div class="row">
    <div class="col-4">
        <img  style="width:80%; height:auto" src="public/images/<?= $formation->getImage(); ?>">
    </div>
    <div class="col-8">
        <br>
        <h3>Cout : <?= $formation->getCout(); ?> €</h3>
        <br>
        <h3>Description :</h3> 
        <p><?= $formation->getDescription(); ?></p>
    </div>
</div>
    <?php if(Securite::isConnected() && $inscrit){ ?>
    <?php foreach($ressources as $ressource) { ?>
        <div class="col-4">
            <h4 scope="row"><?php echo $ressource->getIdRessource(); ?></h4>
            <p><?php echo $ressource->getDescription(); ?>
            <a style = text-decoration:none href="public/ressources/<?= $ressource->getIdFormation(); ?>/<?= $ressource->getRessource(); ?>"><?php echo $ressource->getRessource(); ?></a></p>
          </div>
            <?php } ?>
    <?php } ?>

<?php
$content = ob_get_clean();
$titre = $formation->getNom();
require "template.view.php";
?>