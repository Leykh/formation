<?php 
ob_start(); 
?>
    <h3>Formulaire changement mot de passe</h3>
    <form action="index.php?action=modif-passwd-validation" method="post">
        <div class="mb-3">
            <label for="username" class="form-label">Nom utilisateur</label>
            <input type="text" class="form-control" id="login" name="login">
        </div>
        <div class="mb-3">
            <label for="passwd" class="form-label">Mot de passe</label>
            <input type="password" class="form-control" id="passwd" name="passwd">
        </div>
        <div class="mb-3">
            <label for="passwd" class="form-label">Nouveau mot de passe</label>
            <input type="password" class="form-control" id="npasswd" name="npasswd">
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
<?php
$content = ob_get_clean();
$titre = "changer mdp";
require "template.view.php";
?>