<?php
class Securite {
    public static function verifAccessAdmin(){
        return (isset($_SESSION['role']) && !empty($_SESSION['role']) && $_SESSION['role'] === "administrateur");
    }
    public static function verifAccessAbonne(){
        return (isset($_SESSION['role']) && !empty($_SESSION['role']) && $_SESSION['role'] === "abonne");
    }
    public static function verifAccessCfa(){
        return (isset($_SESSION['role']) && !empty($_SESSION['role']) && $_SESSION['role'] === "CFA");
    }
    public static function isConnected(){
        return (isset($_SESSION['role']) && !empty($_SESSION['role']));
    }
    public static function autoriserCookie(){
        return (isset($_COOKIE['cookie-accept']));
    }
}
