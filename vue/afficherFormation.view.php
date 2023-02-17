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

<?php
$content = ob_get_clean();
$titre = $formation->getNom();
require "template.view.php";
?>