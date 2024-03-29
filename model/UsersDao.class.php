<?php
require_once "Connexion.class.php";
require_once "User.class.php";

class UsersDao extends Connexion {
    private static $_instance = null;

    private function __construct() {}
    
    public static function getInstance() {
        if(is_null(self::$_instance)) {
            self::$_instance = new UsersDao();  
        }
        return self::$_instance;
    } 
    function getPasswdHashUser($login){
        $pdo = $this->getBdd();
        $req = "SELECT password FROM utilisateur WHERE login=:login";
        $stmt = $pdo->prepare($req);
        $stmt->bindValue(":login",$login,PDO::PARAM_STR);
        $cpt = $stmt->execute();
        $passwd = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt->closeCursor();  
        return isset($passwd['password']) ? $passwd['password'] : ("");
    }    
    function findAllUser(){
        $stmt = $this->getBdd()->prepare("SELECT * FROM utilisateur");
        $stmt->execute();
        $bddUsers = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        foreach($bddUsers as $user){
            $u=new User($user['login'], $user['password'],$user['mail'], $user['role'],$user['image'], $user['est_valide']);
            $users[]=$u;
        }
        return $users;
    }
    function supprimerUser($username){
        $pdo = $this->getBdd();
        $req = "Delete from utilisateur where login = :username";
        $stmt = $pdo->prepare($req);
        $stmt->bindValue(":username",$username,PDO::PARAM_STR);
        $resultat = $stmt->execute();
        $stmt->closeCursor();

        return $resultat > 0;
    }
    function creerAbonne($user, $cle) {  
        echo "user=".$user->getLogin()."<br>";
        $pdo = $this->getBdd();
        $req = "
        INSERT INTO utilisateur (login, password, mail, role, image, est_valide, clef)
        values (:login, :password, :mail, :role, :image, :est_valide, :clef)";
        $stmt = $pdo->prepare($req);
        $stmt->bindValue(":login",$user->getLogin(),PDO::PARAM_STR);
        $stmt->bindValue(":password",$user->getPassword(),PDO::PARAM_STR);
        $stmt->bindValue(":mail",$user->getMail(),PDO::PARAM_STR);
        $stmt->bindValue(":role",$user->getRole(),PDO::PARAM_STR);
        $stmt->bindValue(":image",$user->getImage(),PDO::PARAM_STR);
        $stmt->bindValue(":est_valide",$user->getEstValide(),PDO::PARAM_INT);
        $stmt->bindValue(":clef",$cle,PDO::PARAM_STR);
        $resultat = $stmt->execute();
        $stmt->closeCursor();      
    }
    function validerAbonne($login,$cle){
        $pdo = $this->getBdd();
        $req = "UPDATE utilisateur SET est_valide = 1, role = 'abonne' WHERE login = :login AND clef = :cle";
        $stmt = $pdo->prepare($req);
        $stmt->bindValue(":login",$login,PDO::PARAM_STR);
        $stmt->bindValue(":cle",$cle,PDO::PARAM_STR);
        $stmt->execute();
        $estModifier = ($stmt->rowCount() > 0);
        $stmt->closeCursor();

        return $estModifier;
    }
    function isExistLoginUser($login){
        $pdo = $this->getBdd();
        $req = "SELECT count(login) AS nb FROM utilisateur WHERE login=:login";
        $stmt = $pdo->prepare($req);
        $stmt->bindValue(":login",$login,PDO::PARAM_STR);
        $cpt = $stmt->execute();
        $nbUserTab = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt->closeCursor(); 
        return ($nbUserTab['nb'] > 0);
    }
    function isAbonneValide($login){
        $pdo = $this->getBdd();
        $req = "SELECT est_valide AS isvalid FROM utilisateur WHERE login=:login";
        $stmt = $pdo->prepare($req);
        $stmt->bindValue(":login",$login,PDO::PARAM_STR);
        $cpt = $stmt->execute();
        $estValid = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt->closeCursor(); 
        return $estValid['isvalid'];
    }
    function getRoleByLogin($login){
        $pdo = $this->getBdd();
        $req = "SELECT role FROM utilisateur WHERE login=:login";
        $stmt = $pdo->prepare($req);
        $stmt->bindValue(":login",$login,PDO::PARAM_STR);
        $cpt = $stmt->execute();
        $role = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt->closeCursor();  
        return $role['role'];
    }
    function findUserByLogin($login){
        $stmt = $this->getBdd()->prepare("SELECT * FROM utilisateur WHERE login=:login");
        $stmt->bindValue(":login",$login,PDO::PARAM_STR);
        $cpt = $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        $u=new User($user['login'], $user['password'],$user['mail'], $user['role'],$user['image'], $user['est_valide']);
        return $u;
    }
    
    function modifierUser($login,$newlogin,$password,$mail,$role,$est_valide,$image){
        $pdo = $this->getBdd();
        $req = "
        update utilisateur 
        set login = :newlogin, password = :password, mail = :mail, role = :role, image = :image, est_valide = :est_valide
        where login = :login";
        $stmt = $pdo->prepare($req);
        $stmt->bindValue(":newlogin",$newlogin,PDO::PARAM_STR);
        $stmt->bindValue(":login",$login,PDO::PARAM_STR);
        $stmt->bindValue(":password",$password,PDO::PARAM_STR);
        $stmt->bindValue(":mail",$mail,PDO::PARAM_STR);
        $stmt->bindValue(":role",$role,PDO::PARAM_STR);
        $stmt->bindValue(":image",$image,PDO::PARAM_STR);
        $stmt->bindValue(":est_valide",$est_valide,PDO::PARAM_INT);
        $resultat = $stmt->execute();
        $stmt->closeCursor();

        if($resultat > 0){
            echo "user modifier login=".$login."<br>";
        }
    }
    
    function modifierUserImage($login,$image){
        $pdo = $this->getBdd();
        $req = "
        update utilisateur 
        set image = :image
        where login = :login";
        $stmt = $pdo->prepare($req);
        $stmt->bindValue(":login",$login,PDO::PARAM_STR);
        $stmt->bindValue(":image",$image,PDO::PARAM_STR);
        $resultat = $stmt->execute();
        $stmt->closeCursor();

        if($resultat > 0){
            echo "user modifier login=".$login."<br>";
        }
    }
    function getAllPasswdHashUser($login){
        $pdo = $this->getBdd();
        $req = "SELECT * FROM historique_utilisateur WHERE login=:login";
        $stmt = $pdo->prepare($req);
        $stmt->execute();
        $bddUsers = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        foreach($bddUsers as $user){
            $p=array('login' => $user['login'],'mdp' => $user['password'],'date'=>$user['mail']);
            $passwds[]=$p;
        }
        return $passwds;
    } 
    function archivePsswdUser($login,$pwd){
        $date = date('Y-m-d H:i:s');
        $pdo = $this->getBdd();
        $req = "INSERT INTO historique_utilisateur (login, mdp, date)
        VALUES (:login, :pwd, :date)";
        $stmt = $pdo->prepare($req);
        $stmt->bindValue(":login",$login,PDO::PARAM_STR);
        $stmt->bindValue(":pwd",$pwd,PDO::PARAM_STR);
        $stmt->bindValue(":date",$date,PDO::PARAM_STR);
        $resultat = $stmt->execute();
        $stmt->closeCursor();
    } 
    
    function changePsswd($login,$pwd){
        $pdo = $this->getBdd();
        $req = "UPDATE utilisateur SET password = :pwd WHERE login = :login";
        $stmt = $pdo->prepare($req);
        $stmt->bindValue(":login",$login,PDO::PARAM_STR);
        $stmt->bindValue(":pwd",$pwd,PDO::PARAM_STR);
        $resultat = $stmt->execute();
        $stmt->closeCursor();
    } 
    
    function updateClef($login,$clef){
        $pdo = $this->getBdd();
        $req = "
        update utilisateur 
        set clef = :clef, est_valide = 0
        where login = :login";
        $stmt = $pdo->prepare($req);
        $stmt->bindValue(":login",$login,PDO::PARAM_STR);
        $stmt->bindValue(":clef",$clef,PDO::PARAM_STR);
        $resultat = $stmt->execute();
        $stmt->closeCursor();
    }
}
?>