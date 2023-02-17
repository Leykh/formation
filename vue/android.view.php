<?php ob_start()?>

Télécharger l'application android : <a href="biblio.apk">bibliotheque android</a>

<?php
    $content=ob_get_clean();
    $titre = "Android";
    require "template.view.php";
?>