<?php

class Autoloader{
    // méthode qui prend en paramètre le nom des classe php qui vont contenir les classe utile au projet 
    static function register(){
        // on utilise la classse magique __CLASS__ pour récupérer le nom de la classe courante Autoloader
        // par définition spl_autoload_register prend en paramètre le nom d'une fonction or ici l'on veut appeler une fonction dans une class, pour celà on passe en paramètre un tableau qui contient le nom de la class et le nom de la propriéter de la class
        // if(__CLASS__ != 'PDO'){
            spl_autoload_register(array(__CLASS__,'autoload'));
        // }
    }
    static function autoload($class_name){
        // $class_name = str_replace("ConnexionMdp\\", '',$class_name);
        // var_dump($class_name);
        if($class_name != 'PDO'){
            require 'assets/class/' . $class_name . '.class.php';
        }
    }
}