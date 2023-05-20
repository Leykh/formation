<?php
abstract class Connexion {
    private static $pdo;
    private static $servername = 'localhost';
    private static $username = 'u166297419_userformation';
    private static $password = 'iNO9par?]G9';
    private static $dbname = 'u166297419_formation';
   
    private static function setBdd(){
        self::$pdo = new PDO("mysql:host=".self::$servername.";dbname=".self::$dbname.";charset=utf8",self::$username,self::$password);
        self::$pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_WARNING);
    }
    protected function getBdd(){
        if(self::$pdo === null){
            self::setBdd();
        }
        return self::$pdo;
    }
}
?>
