<?php 
ob_start(); 
?>
<div class="container">
    <form method="POST" action="index.php?page=formations&action=modifier-formation-validation" enctype="multipart/form-data">
      <div class="mb-3">
        <label class="form-label" for="nom">Nom : </label>
        <input class="form-control" type="text" id="nom" name="nom" value="<?= $formation->getNom() ?>">
      </div>
      <div class="mb-3">
        <label class="form-label" for="cout">Cout : </label>
        <input class="form-control" type="number" id="cout" name="cout" value="<?= $formation->getCout() ?>">
      </div>
      <div class="mb-3">
        <label class="form-label" for="descr">Description : </label>
        <input class="form-control" type="text" id="descr" name="descr" value="<?= $formation->getDescription() ?>">
      </div>
      <img width="200px" src="public/images/<?php echo $formation->getImage(); ?>">
      <div class="mb-3">
        <label class="form-label" for="image">Image : </label>
        <input class="form-control" type="file" id="image" name="image">
      </div>
        <input type="hidden" name="id" value="<?= $formation->getId() ?>">
        <input type="hidden" name="image" value="<?= $formation->getImage() ?>">
      <input class="btn btn-primary" type="submit" value="modifier" name="form_ajouter"/> 
</form>
<?php
$content = ob_get_clean();
$titre = "Modifier le formation";
require "template.view.php";
?>