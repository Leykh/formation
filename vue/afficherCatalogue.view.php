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
      <?php $i++; ?>
      <div class="col-5">
        <div class="card p-1 m-1" style="width: 25rem;">
          <img height="300px" src="public/images/<?php echo $formation->getImage(); ?>" class="card-img-top" alt="image">
          <div class="card-body">
            <h5 class="card-title"><?php echo Outils::sousChaineTaille($formation->getNom(), 35); ?></h5>
            <p class="card-text"><?php echo Outils::sousChaineTaille($formation->getDescription(),150); ?></p>
            <p class="card-text"><?php echo Outils::sousChaineTaille($formation->getCout()." €",50); ?></p>
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
<?php } ?> 
<?php
$content = ob_get_clean();
$titre = "Catalogue";
require "template.view.php";
?>  