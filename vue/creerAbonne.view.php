<?php 
ob_start(); 
?>
<?php if($alert !== ""){ ?>
    <div class="alert alert-danger" role="alert">
        <?= $alert ?>
    </div>              
<?php } ?>
        <form action="index.php?action=creer-abonne-validation" method="post">
            <div class="mb-3">
              <label for="username" class="form-label">Nom utilisateur</label>
              <input type="text" class="form-control" id="username" name="login">
            </div>
            <div class="mb-3">
              <label for="passwd" class="form-label">Mot de passe</label>
              <input type="password" class="form-control" id="passwd" name="passwd">
            </div>
            <!-- version 3-01 -->
            <div class="mb-3">
                <label for="mail" class="form-label">mail</label>
                <input type="mail" class="form-control" id="mail" name="mail" required>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="mentions" id="flexCheckIndeterminate">
                <label class="form-check-label" for="flexCheckIndeterminate">
                  J'ai lu et j'accepte les conditions de service décrites dans les 
                  <a href="index.php?action=mentions-legales">mentions légales</a>
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="perso" id="flexCheckIndeterminate">
                <label class="form-check-label" for="flexCheckIndeterminate">
                  J'accepte que mes données soient conservées pour avoir accés aux services de la bibliothéques 
                </label>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
          </form>
<?php
$content = ob_get_clean();
$titre = "Créer compte abonné";
require "template.view.php";
?>

