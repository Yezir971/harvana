<?php

// namespace App\Bdd;

class Bdd{


    private $db_name;
    private $db_user;
    private $db_pass;
    private $db_host;

    public $pdo;


    public $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING,  // On affiche les erreurs 
        PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',  // On définit le jeu de caractères à utf8
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,  // On récupère les données sous forme de tableau associatif
    ];
    /**
     * methode permettant de me connecter à ma BDD
     *
     * @param string $db_name
     * @param string $db_user
     * @param string $db_pass
     * @param string $db_host
     */
    public function __construct($db_name = 'harvana',$db_user = 'root',$db_pass='',$db_host='localhost'){
        $this->db_name = $db_name;
        $this->db_user = $db_user;
        $this->db_pass = $db_pass;
        $this->db_host = $db_host;
        // revove prod 
        ini_set('display_errors', 1);
        error_reporting(E_ALL);
        // revove prod 
    }


    /**
     * methode permettant de fair appel à la BDD lors des reuqêtes SQL
     *
     * 
     */
    public function getPdo(){
        // pour éviter de devoir à appeler plusieurs fois notre base de donné on regarde si la propriété pdo est null 
        if($this->pdo == null){
 
            $pdo = new PDO("mysql". ':host=' . $this->db_host . ';dbname=' . $this->db_name, $this->db_user, $this->db_pass,$this->options);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo = $pdo;
        }
        return $this->pdo;
    }

 
    /**
     * méthode permettant de faire des requêtes SQL et de retourner le résultat sous forme de tableau associatif utile pour le debug
     *
     * @param SQL $requete
     * @return void
     */
    public function requeteDebugSql($requete){
        // query permet de faire un prepare et un execute en une requête sql 
        $req = $this->getPdo()->query($requete);
        $data = $req->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }



    /**
     * methode permettant de se créer un compte
     *
     * @param string $email
     * @param string $password
     * @return string
     */
    public function createAccount(){ 
        if(isset($_POST["signButton"]) && $_POST["signButton"]=="S'INSCRIRE"){
            $email = $_POST['email'];
            $password = $_POST['mdp1'];
            $firstname = $_POST['firstname'];

            $uniqueUser = $this->getPdo()->prepare('SELECT email from user WHERE email = :emailTest');
            $uniqueUser->bindvalue(':emailTest',$email,PDO::PARAM_STR);
            $uniqueUser->execute();
            if($uniqueUser->rowCount() !=0){
                echo "<p class='error'>Cette adresse mail est déjà utilisé</p>";
            }else{
                $user = $this->getPdo()->prepare('INSERT INTO `user`( `firstname`,`email`, `password` ) VALUES (
                    :firstname,
                    :email,
                    :password
                )');
                $user->bindvalue(':email',strip_tags($email),PDO::PARAM_STR);
                $user->bindValue(':password',password_hash($password,PASSWORD_DEFAULT),PDO::PARAM_STR);
                $user->bindValue(':firstname',strip_tags($firstname),PDO::PARAM_STR);
                $user->execute();
                header('location: login?messageError=true');
                exit();

            }
        }
    }
}



