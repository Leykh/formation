<?php ob_start()?>

<?php
    $content=ob_get_clean();
    $titre = "Accueil";
    require "template.view.php";
?>