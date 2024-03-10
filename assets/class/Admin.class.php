<?php

class Admin extends Bdd{
     /**
     * permet d'afficher les personnes ayant un compte et de pouvoir les supprimer si nécessaire
     *
     * @return void
     */
    public function affichePerso(){
        if(isset($_GET["s"]) && $_GET["s"] == "Rechercher"){
            $user = $this->getPdo()->prepare('SELECT id,firstname,email,status,visibility FROM `user` WHERE email LIKE ? ');
            $_GET["terme"] = htmlspecialchars($_GET["terme"]); //pour sécuriser le formulaire contre les failles html
            $terme = $_GET["terme"];
            $terme = trim($terme);
            $terme = strip_tags($terme); 

            if (isset($terme))
            {
                $terme = strtolower($terme);
            }
            $user->execute(array("%".$terme."%"));
            
        }else if(empty($_GET["s"])){
            $user = $this->getPdo()->prepare('SELECT id,firstname,email,status,visibility FROM `user`');
            $user->execute();

        }
        $keys = $user->fetchAll();
        
        // var_dump($keys);
        // var_dump($_SESSION);
        for($key = 0; $key < count($keys);$key++){
            echo '<tr>';
            echo '<td>'.$keys[$key]['id'].'</td>';
            echo '<td>'.$keys[$key]['email'].'</td>';
            echo '<td>'.$keys[$key]['firstname'].'</td>';
            echo '<td>'.$keys[$key]['status'].'</td>';
            echo '<td>'.$keys[$key]['visibility'].'</td>';
            echo '<td><a href="yu4vana?deleteAccount='. $keys[$key]['id'] . '">Supprimer</a></td>';
            echo '<td><a href="yu4vana?see='. $keys[$key]['id'] . '">visibilité</a></td>';
            // echo '<td> <form action="#" method="post"><input type="hidden" name="idCount" value="'. $key + 1 .'"><input type="submit" name="deleteCount" value="Supprimer"></form></td>';
            echo '</tr>';
            
            if(isset($_GET['see']) && $_SESSION['member']['status']==1){
                if($_GET['deleteAccount'] != $_SESSION['member']['id']){

                    $user = $this->getPdo()->prepare("UPDATE `user` SET `visibility`=1 WHERE id=".$_GET['see']);
                    // $user->bindvalue(':id',$id,PDO::PARAM_INT);
                    
                    $user->execute(); 
                }else{
                    echo "Vous ne pouvez pas changer les droits de visibiilité de se compte !";
                }
                header('location: yu4vana');
                exit();
            }

            if(isset($_GET['deleteAccount']) && $_SESSION['member']['status']==1){
                if($_GET['deleteAccount'] != $_SESSION['member']['id']){
                    $user = $this->getPdo()->prepare("DELETE FROM `user` WHERE id =".$_GET['deleteAccount']." AND status!= 1");
                    $user->execute(); 
                }else{
                    echo "Vous ne pouvez pas supprimer se compte !";
                }
                $user = $this->getPdo()->prepare("
                SET @num := 0;
                UPDATE user SET id = @num := (@num+1);
                ALTER TABLE user AUTO_INCREMENT = 1;");
                $user->execute();
    
                header('location: yu4vana');
                exit();
            }
        }
    }

    /**
     * methode permettant d'insérer le taux hebdomadaire en %
     * 
     * @return string
     */
    public function insertTaux() {
        
        if(isset($_POST['insertButton']) && $_POST['insertButton']=="Envoyer"){
            try{
                $taux = $_POST['taux'];
                $insert = $this->getPdo()->prepare('INSERT INTO `hebdo` (`taux`,`date`) VALUES (
                    :taux,
                    NOW()
                    )');
                $insert->bindValue(':taux',$taux,PDO::PARAM_INT);
                // $insert->bindValue(':date', Date(), PDO::PARAM_STR);
                
                $insert->execute();
            }catch(Exception $e){
                // $this->error($e);
                
                return "<p class='error'>". $e ." Merci de bien vouloir remplir le champs dédier au taux avant d'envoyer</p>";
            }
        }
    } 
    
    public function visibilityAccess() {
        if(isset($_POST['changeVisibility']) && $_POST['changeVisibility']=="Envoyer") {
            $email = $_POST['email'];
            $user = $this->getPdo()->prepare('SELECT * FROM user WHERE email = :email');
            $user->bindValue(':email',$email,PDO::PARAM_STR);
            $user->execute();
            /*
            $keys = $user->fetchAll();
            
            foreach($keys as $key){//on affiche toutes les données dans un formulaire et on place ça dans le html grâce à l'appelle de la fonction
                echo "<label for='visibility'>Visibilité</label>
                <input type='text' id='visibility' name='visibility' placeholder='changer la visibilité' value='".$key['visibility']."'>

                <label for='emailChange' >Mail</label>
                <input type='text' id='emailChange' value='".$key['visibility']."' name=''>

                
                <input type='submit' name='newVisibility'>
                <input type='submit' name='cancel' value='Annuler'>
                ";
            }

            if(isset($_POST['annuler']) && $_POST['annuler']=='Annuler'){
                $_POST['buttonPrint']='Close';
            }

            if(isset($_POST['newVisibility'])){
            $user = $this->getPdo()->prepare("UPDATE `user` SET `name`=:nameSkill ,
            `level`=:level,
            `description`=:description,
            `levelClass`=:levelClass
            WHERE email =:email2");

            $user->bindValue(':nameSkill',strip_tags($_POST['nameUpdate']),PDO::PARAM_STR);

            $user->execute();
        }
            */
        }
    }

    public function search() {
        $_GET["terme"] = htmlspecialchars($_GET["terme"]); //pour sécuriser le formulaire contre les failles html
        $terme = $_GET["terme"];
        $terme = trim($terme);
        $terme = strip_tags($terme); 
        if (isset($terme))
        {
            $terme = strtolower($terme);
            $user = $this->getPdo()->prepare("SELECT email FROM user WHERE email LIKE ?");
            // $user->execute(array("%".$terme."%"));
        }
        // var_dump($user);
    }
}