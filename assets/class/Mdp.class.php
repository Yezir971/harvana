<?php

// on utilise un namespace pour bien faire la différences entre chaque class que l'on va créer 
// namespace ConnexionMdp;
require "assets/class/Bdd.class.php";


// class qui vérifie que les conditions de validité du mot de passe sont bien respectées
class Mdp extends Bdd{
    public static $content = "";

    /**
     * mdp
     *
     * @param string $data
     */
    // class qui va vérifier la syntaxe du mot de passe
    public static function mdpSyntaxe(string $data): string{

        if(preg_match('#^[a-zA-Z0-9_-]{8,15}$#',$data)){
            //vérification des maj : 
            if(!preg_match('#[A-Z]+#',$data))
            {
                self::$content .= "<p class='error'>Le champ mot de passe doit contenir au moins une majuscule</p>";
            }
            //vérification des min : 
            if(!preg_match('#[a-z]+#',$data))
            {
                self::$content .= "<p class='error'>Le champ mot de passe doit contenir au moins une minuscule</p>";
            }
            //vérification des entiers : 
            if(!preg_match('#[0-9]+#',$data))
            {
                self::$content .= "<p class='error'>Le champ mot de passe doit contenir au moins une chiffre</p>";
            }
        }else{
            self::$content .= "<p class='error'>Le champs mot de passe est incorrect</p>";

        }
        return self::$content;
    }
    // propriété qui va vérifier si le mot de passe de confirmation est identique au premier mot de passe 
    public static function mdpCompare(string $data1,string $data2): string{
        if($data1 != $data2){
            self::$content .= "<p class='error'>les mdp sont différents</p>";
        }
        // echo self::$content;
        return self::$content;

    }
    // propriété qui va créer ou non le compte de l'utilisateur
    public function mdpOk(){
        if (isset($_POST) && isset($_POST["signButton"]) ){
            if(self::mdpSyntaxe($_POST["mdp1"]) == "" && self::mdpCompare($_POST["mdp1"],$_POST["mdp2"]) == "" ){
                $this->createAccount();
            }else{
                echo self::$content;
                echo "<p class='error'>Votre compte n'a pas été créer</p>";

            }
        }
        
    }
}