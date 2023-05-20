<?php 
ob_start(); 
?>
<?php $coutTotal = 0; 
 if($alert !== ""){ ?>
    <div class="alert alert-danger" role="alert">
        <?= $alert ?>
    </div>              
<?php } else { ?>
<br>
    <table class="table table-striped">
      <thead>
        <tr>
        
          <th scope="col">Image</th>
          <th scope="col">Titre</th>
          
          <th scope="col">Prix</th>
          <th scope="col" colspan="3">Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($formations as $formation) {
          $coutTotal += floatval($formation->getCout());
        ?>
          <tr class="align-middle">
            
            <td><img width="80" src="../public/images/<?php echo $formation->getImage(); ?>"></td>
            <td><?php echo $formation->getNom(); ?></td>
            <td><?php echo $formation->getCout(); ?></td>
            <td><a href="index.php?action=afficher-formation&id=<?php echo $formation->getId(); ?>" class="btn btn-info">Details</a></td>
            <td><a href="index.php?action=supprimer-formation-panier&id=<?= $formation->getId(); ?>" class="btn btn-danger">Supprimer du panier</a></td>
          </tr>
          
        <?php } ?>
      </tbody>
    </table>
      
    <h3>Prix total : <?php echo $coutTotal; ?>€</h3>
    <a href="index.php?action=valider-panier" class="btn btn-success">Valider le paiement</a>
    
<?php } ?>     
<?php
$content = ob_get_clean();
$titre = "Panier" ;
require "template.view.php";
?>