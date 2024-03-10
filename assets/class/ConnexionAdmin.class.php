<?php

require "Bdd.class.php";

class ConnexionAdmin extends Bdd{

    /**
     * connecte la personne à son compte
     *
     * @return void
     */
    public function verifierCompte(){


        if(isset($_POST) && isset($_POST["logButton"]) && !empty($_POST["email"]) && !empty($_POST["mdp"])  && !empty($_POST["firstname"]) ){
            extract($_POST);

            $pdoStatement = parent::getPdo()->prepare('SELECT `id`, `email`,`password`,`status`,`visibility`, `firstname` FROM `user` WHERE email =:email ');

            $pdoStatement->bindValue(':email',$email,PDO::PARAM_STR);
            
            $pdoStatement->execute();
            if($pdoStatement->rowCount() !=0){
                // echo password_verify($password,$verification['password']);
                // On créer un tableau associatif qui va contenir seulement les informations de l'admin pour pouvoir les comparer 
                $verification = $pdoStatement->fetch(PDO::FETCH_ASSOC);
                // print_r ($verification);
                // on vérifie si le mot de passe hashé est le même que celui dans la bdd grace a la fonction prédéfinie password_verify
                if(password_verify($_POST['mdp'],$verification['password'])){

                    // si le mot de passe est le bon alors on redirige l'admin vers la page backOffice, mais avant on va stocker dans session la valeurs de status qui est dans notre base de donnés se qui va permettre ou non a l'admin d'acceder a la page Backoffice
                    $_SESSION['member']['id']=$verification['id'];   
                    $_SESSION['member']['firstname']=$verification['firstname'];   
                    $_SESSION['member']['email']=$verification['email'];
                    $_SESSION['member']['status']=$verification['status'];
                    $_SESSION['member']['visibility']=$verification['visibility'];
                    
                    // var_dump($_SESSION['member']);
                    
                    if($_SESSION['member']['status'] == 1 ){
                        header("location: yu4vana");
                        exit();
                    }else{
                        return "<p class='error'>Vous n'êtes pas autorisé à accéder à la partie admin</p>";
                    }
                }else{
                    echo "<p>Le mot de passe n'est pas correcte</p>";
                }
            }else{
                echo  "<p class='errorMessage'>". $email . " n'existe pas.</p>";
            }
        }

    }
   
}