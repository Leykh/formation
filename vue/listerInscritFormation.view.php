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
          <th scope="col">Titre</th>
          <th scope="col">Date Debut</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($inscritList as $inscrit) { ?>
          <tr class="align-middle">
            <td scope="row"><?php echo $inscrit->getIdInscrit(); ?></td>
            <td><?php echo $inscrit->getNomFormation(); ?></td>
            <td><?php echo  $inscrit->getDateDebut(); ?></td> 
            <td><a href="index.php?action=afficher-formation&id=<?= $inscrit->getidFormation(); ?>" class="btn btn-info">Suivre</a></td>
            <td><a href="index.php?action=retourner-inscrit-formation&idInscrit=<?= $inscrit->getIdInscrit(); ?>&idFormation=<?= $inscrit->getidFormation(); ?>" class="btn btn-danger">Fin de formation</a></td>
          </tr>
        <?php } ?>
      </tbody>
    </table> 
</div> 
<?php } ?>
<?php
    $content=ob_get_clean();
    $titre = "Liste des formations inscrits";
    require "template.view.php";
?>