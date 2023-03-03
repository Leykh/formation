<?php ob_start()?>

<div class="container">
    <table class="table table-striped">
      <thead>
        <tr>
        <th scope="col">Id</th>
          <th scope="col">Nom</th>
          <th scope="col">Cout</th>
          <th scope="col">description</th>
          <th scope="col" colspan="3">Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($tabFormations as $formation) { ?>
          <tr class="align-middle">
            <td scope="row"><?php echo $formation->getId(); ?></td>
            <td><img width="80" src="public/images/<?php echo $formation->getImage(); ?>"></td>
            <td><?php echo $formation->getNom(); ?></td>
            <td><?php echo $formation->getCout(); ?></td>
            <td><?php echo $formation->getDescription(); ?></td>
            <td><a href="index.php?action=afficher-formation&id=<?= $formation->getId(); ?>" class="btn btn-info">Afficher détail</a></td>
            <td><a href="index.php?action=modifier-formation&id=<?= $formation->getId(); ?>" class="btn btn-warning">Modifier</a></td>
            <td><a href="index.php?action=supprimer-formation&id=<?= $formation->getId(); ?>" class="btn btn-danger">Supprimer</a></td>
          </tr>
        <?php } ?>
      </tbody>
    </table> 
        <div class="col-center text-center">
            <a href="index.php?action=creer-formation" class="btn btn-primary">Ajouter une formation</a>
        </div>
</div> 
<?php
    $content=ob_get_clean();
    $titre = "Administrer les formations";
    require "template.view.php";
?>