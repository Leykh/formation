<?php ob_start()?>
<?php if($alert !== ""){ ?>
            <div class="alert alert-danger" role="alert">
              <?= $alert ?>
            </div>              
<?php } else { ?>
<div class="container">
    <table class="table table-striped">
      <thead>
        <tr>
          <th scope="col">Id Inscription</th>
          <th scope="col">Nom</th>
          <th scope="col">date debut</th>
          <th scope="col">date fin</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($inscritHistoriqueList as $inscrit) { ?>
          <tr class="align-middle">
            <td scope="row"><?php echo $inscrit->getIdInscrit(); ?></td>
            <td><?php echo $inscrit->getNomFormation(); ?></td>
            <td><?php echo  $inscrit->getDateDebut(); ?></td> 
            <td><?php echo $inscrit->getDateFin(); ?></td>
          </tr>
        <?php } ?>
      </tbody>
    </table> 
</div> 
<?php } ?>
<?php
    $content=ob_get_clean();
    $titre = "Historique des formations inscriter";
    require "template.view.php";
?>