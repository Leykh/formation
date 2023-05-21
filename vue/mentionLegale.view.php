<?php ob_start()?>
<h4>Éditeur</h4>
<p>
La Direction CAFOMA.
<br><br>
PO BOX 20223<br>
COMPTOIR DE LA JOLIETTE<br>
MARSEILLE<br>
<h4>Production des contenus</h4>
<p>La Direction de CAFOMA & ses partenaires.</p>
<h4>Mission du site</h4>
<p>Vente et suivie de service de formation</p>
<h4>Conception graphique</h4>
<p>ducoeur c.<br>
PO BOX 20223 COMPTOIR DE LA JOLIETTE</p>
<h4>Conception technique</h4>
<p>ducoeur c.<br>
PO BOX 20223 COMPTOIR DE LA JOLIETTE<br>
</p>
<h4>Droit d'accès, de modification et de suppression</h4>
<p>Le règlement UE/2016 du 27 avril 2016 relatif à la protection des données à caractère personnel et la loi n° 78-17 du 6 janvier 1978 relative à l’informatique, aux fichiers et aux libertés, confère aux Visiteurs ou Contributeurs, personnes physiques, un droit d’accès, de rectification, et d’effacement de ses données.<br>
<br>
Tout utilisateur peut exercer ce droit en écrivant au Délégué à la Protection des Données Personnelles : dpd.ducoeurc@gmail.com, ou par courrier à l'adresse suivante :<br>
<br>
Délégué à la Protection des Données Personnelles<br>
PO BOX 20223<br>
COMPTOIR DE LA JOLIETTE<br>
MARSEILLE<br>
<br>
Si un utilisateur estime que ses droits ne sont pas respectés, il peut faire une réclamation auprès de l’autorité de contrôle de la protection des données personnelles :<br>
<br>
Commission Nationale de l’Informatique et des Libertés (CNIL)<br>
3 Place de Fontenoy<br>
TSA 80715<br>
75334 PARIS CEDEX 07<br>
</p>
<?php
    $content=ob_get_clean();
    $titre = "Mentions légales";
    require "template.view.php";
?>

