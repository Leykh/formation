<?php 
  require_once "outil/Outils.class.php"; 
  ob_start(); 
?>
<?php if($alert !== ""){ ?>
    <div class="alert alert-danger" role="alert">
        <?= $alert ?>
    </div>              
<?php } else { ?>
  <div class="row">
    <?php $i=0; ?>
    <?php foreach($formations as $formation) { ?>
      <div class="col">
        <div class="card p-2 m-2" style="width: 20rem;">
          <img height="300px" src="public/images/<?php echo $formation->getImage(); ?>" class="card-img-top" alt="image">
          <div class="card-body">
            <h5 class="card-title"><?php echo Outils::sousChaineTaille($formation->getNom(), 18); ?></h5>
            <p class="card-text"><?php echo Outils::sousChaineTaille($formation->getDescription(),100); ?></p>
          <ul class="list-group list-group-flush">
            <li class="list-group-item"><?php echo Outils::sousChaineTaille($formation->getCout()." €",10); ?></li>
          </ul>
            <p class="card-text"></p>
            <a href="index.php?action=afficher-formation&id=<?php echo $formation->getid(); ?>" class="btn btn-primary">Détail</a>
            <?php if(Securite::isConnected()){ ?>
              <a href="index.php?action=ajouter-formation-panier&id=<?php echo $formation->getid(); ?>" class="btn btn-success">Ajouter au panier</a>
            <?php } ?>
          </div>
        </div>
      </div>
    <?php } ?>
    <?php if($i == count($formations) and $i % 4 != 0) { ?>
        <div class="col-3"></div>          
    <?php } ?>  
  </div>
  <?php if(Securite::isConnected()){ ?>
      <div class="col text-center" style="padding: 20;">
        <a href="index.php?action=afficher-panier" class="btn btn-primary btn-lg">Payer les formations</a>
    </div>
  <?php } ?>
<?php } ?> 
<?php
$content = ob_get_clean();
$titre = "Catalogue";
require "template.view.php";
?>  