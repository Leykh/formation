<?php 
ob_start(); 
?>
<div class="container">
    <form method="POST" action="index.php?page=formations&action=modifier-user-validation" enctype="multipart/form-data">
      <div class="mb-3">
        <label class="form-label" for="newlogin">Nom utilisateur : </label>
        <input class="form-control" type="text" id="newlogin" name="newlogin" value="<?= $user->getLogin() ?>">
      </div>
      <div class="mb-3">
        <label class="form-label" for="mail">Mail : </label>
        <input class="form-control" type="text" id="mail" name="mail" value="<?= $user->getMail() ?>">
      </div>
      <div class="mb-3">
        <label class="form-label" for="role">Role : </label>
        <input class="form-control" type="text" id="role" name="role" value="<?= $user->getRole() ?>">
      </div>
      <div class="mb-3">
        <label class="form-label" for="valide">Valide : </label>
        <input class="form-control" type="text" id="valide" name="valide" value="<?= $user->getEstValide() ?>">
      </div>
      <div class="mb-3">
        <label class="form-label" for="password">Password : </label>
        <input class="form-control" type="text" id="password" name="password" value="<?= $user->getPassword() ?>">
      </div>
      <img width="200px" src="public/images/<?php echo $user->getImage(); ?>">
      <div class="mb-3">
        <label class="form-label" for="image">Image : </label>
        <input class="form-control" type="file" id="image" name="image">
      </div>
        <input type="hidden" name="id" value="<?= $user->getLogin() ?>">
        <input type="hidden" name="image" value="<?= $user->getImage() ?>">
        
      <div class="mb-3">
        <label class="form-label" for="login"></label>
        <input type="hidden" id="login" name="login" value="<?= $user->getLogin() ?>">
      </div>

      <input class="btn btn-primary" type="submit" value="modifier" name="form_ajouter"/> 
</form>
<?php
$content = ob_get_clean();
$titre = "Modifier user";
require "template.view.php";
?>