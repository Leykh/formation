<?php
class Outils {
    public static function sendMail($destinataire, $sujet, $message){
        if(mail($destinataire,$sujet,$message)){
            Outils::debug_to_console("Mail envoyé");
        } else {
            Outils::debug_to_console("Mail non envoyé" . $destinataire . "destinataire");
        }
    }
    public static function debug_to_console($data) {
        $output = $data;
        if (is_array($output))
            $output = implode(',', $output);
    
        echo "<script>console.log('Debug Objects: " . $output . "' );</script>";
    }
    public static function afficherTableau($tab,$titre){
        echo "<hr>";
        echo "<p>Tableau ".$titre."</p>";
        echo "<pre>";
        print_r($tab);
        echo "</pre>";
        echo "<hr>";
    }

    public static function afficherChaine($chaine, $titre){
        echo "<p>".$titre."</p>";
        echo "Chaine = ". $chaine . "<br>";
        echo "<hr>";
    }

    public static function ajouterImage($file, $dir){
        $random = rand(0,99999);
        $target_file = $dir.$random."_".$file['name'];
        move_uploaded_file($file['tmp_name'], $target_file);
        return $random."_".$file['name'];
    }

    public static function sousChaineTaille($chaine,$taille){
        if(strlen($chaine) >= $taille)
            $sousChaine = substr($chaine, 0, $taille)."...";
        else {
            $bouchon = str_repeat(" ", $taille-strlen($chaine));
            $sousChaine = $chaine;
        }
        return $sousChaine;
    }
    public static function afficherImageProfil(){
        $userDao = UsersDao::getInstance();
        $user = $userDao->findUserByLogin($_SESSION['login']);
        $imageprofil = $user->getImage();
        return $imageprofil;
    }
}
?>