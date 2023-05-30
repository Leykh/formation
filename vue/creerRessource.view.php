<?php 
ob_start(); 
?>
<div class="container">
    <form method="POST" action="index.php?action=creer-ressource-validation" enctype="multipart/form-data">
      <div class="mb-3">
      <div class="mb-3">
        <label class="form-label" for="descr">Description : </label>
        <input class="form-control" type="text" rows="3" id="descr" name="descr">
      </div>
      <div class="mb-3">
        <label class="form-label" for="ressource">Ressource : </label>
        <input class="form-control" type="file" id="ressource" name="ressource">
      </div>
        <input type="hidden" name="idformation" value="<?= $formation->getId() ?>">
      <input class="btn btn-primary" type="submit" value="ajouter" name="form_ajouter"/> 
</form>
<?php
$content = ob_get_clean();
$titre = "Ajout d'un formation";
require "template.view.php";
?>