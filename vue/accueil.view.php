<?php ob_start()?>
<head>
  <link rel="stylesheet" href="./css/style.css" type="text/css" media="screen" />
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
</head>

 <body>
  <div id="myCarousel" class="carousel slide" data-ride="carousel">
    <ol class="carousel-indicators">
      <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
            <?php $max = sizeof($formations); for($i = 1; $i <= $max; $i++) {?>
      <li data-target="#myCarousel" data-slide-to="<?php $i ?>"></li>
            <?php } ?>
    </ol>
    <div class="carousel-inner">
      <div class="item active">
        <a href="index.php?action=afficher-catalogue">
        <img src="public/images/formation.jpg" style="object-fit: cover;object-position: center;height: 70vh;overflow: hidden;"></a>
        <div class="carousel-caption d-none d-md-block">
                    <h3 style="text-shadow: 0 0 5px black;">Retrouvez dès à présent toutes nos formations !</h3>
                    <h5 style="text-shadow: 0 0 4px black;">Numérique, management, immobilier, et bien plus encore</h5>
                </div>
        </div>
            <?php foreach($formations as $formation) {?>
                <div class="item"><a href="index.php?action=afficher-formation&id=<?php echo $formation->getid(); ?>">
                <img class="container-fluid" src="public/images/<?php echo $formation->getImage(); ?>" alt="<?php echo $formation->getId(); ?>" style=" object-fit: cover;object-position: center;height: 70vh;overflow: hidden;"></a>
                <div class="carousel-caption d-none d-md-block">
                    <h3 style="text-shadow: 0 0 4px black;"><?php echo $formation->getNom(); ?></h3>
                    <h5 style="text-shadow: 0 0 2px black;"><?php echo Outils::sousChaineTaille($formation->getDescription(),100); ?></h5>
                </div>
            </div>
        <?php } ?>
    </div>

    <a class="left carousel-control" href="#myCarousel" data-slide="prev">
      <span class="glyphicon glyphicon-chevron-left"></span>
      <span class="sr-only">Previous</span>
    </a>
    <a class="right carousel-control" href="#myCarousel" data-slide="next">
      <span class="glyphicon glyphicon-chevron-right"></span>
      <span class="sr-only">Next</span>
    </a>
  </div>
</body>
   
<?php
    $content=ob_get_clean();
    $titre = "Accueil";
    require "template.view.php";
?>