<?php ob_start()?>

Télécharger l'application android : <a href="../public/formation.apk" download>formation APK</a><br>
Voir le repository : <a href="https://github.com/Leykh/formation-android">repository github</a>
<?php
    $content=ob_get_clean();
    $titre = "Android";
    require "template.view.php";
?>