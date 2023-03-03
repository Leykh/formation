<?php 
ob_start(); 
?>
<div class="container">
    <form method="POST" action="index.php?action=creer-formation-validation" enctype="multipart/form-data">
      <div class="mb-3">
        <label class="form-label" for="nom">Nom : </label>
        <input class="form-control" type="text" id="nom" name="nom">
      </div>
      <div class="mb-3">
        <label class="form-label" for="cout">Cout : </label>
        <input class="form-control" type="cout" id="cout" name="cout">
      </div>
      <div class="mb-3">
        <label class="form-label" for="descr">Description : </label>
        <input class="form-control" type="text" rows="3" id="descr" name="descr">
      </div>
      <div class="mb-3">
        <label class="form-label" for="image">Image : </label>
        <input class="form-control" type="file" id="image" name="image">
      </div>
      <input class="btn btn-primary" type="submit" value="ajouter" name="form_ajouter"/> 
</form>
<?php
$content = ob_get_clean();
$titre = "Ajout d'un formation";
require "template.view.php";
?>