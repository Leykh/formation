<?php
abstract class Connexion {
    private static $pdo;
    private static $servername = 'localhost';
    private static $username = 'root';
    private static $password = '';
    private static $dbname = 'formation';
   
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
