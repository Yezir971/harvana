<?php

class Admin extends Bdd{
     /**
     * permet d'afficher les personnes ayant un compte et de pouvoir les supprimer si nécessaire
     *
     * @return void
     */
    public function affichePerso(){
        if(isset($_GET["s"]) && $_GET["s"] == "Rechercher / Reinitialiser"){
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
        echo '<th>Email</th><th>Status</th><th>Visibilité</th><th>Supprimer</th>';
        for($key = 0; $key < count($keys);$key++){
            echo '<tr>';
            echo '<td>'.$keys[$key]['email'].'</td>';
            echo '<td>'.$keys[$key]['status'].'</td>';
            echo $keys[$key]['visibility'] != 1 ? '<td><a href="yu4vana?see='. $keys[$key]['id'] . '"> <img src="../img/eye-slash-solid.svg"></a></td>' : '<td><a href="yu4vana?see='. $keys[$key]['id'].'"><img src="../img/eye-solid"></a></td>'; 
            echo '<td><a href="yu4vana?deleteAccount='. $keys[$key]['id'] . '"><img src="../img/trash-can-solid.svg"></a></td>';
            echo '</tr>';

            
            if(isset($_GET['see']) && $_SESSION['member']['status']==1){
                $recupVisibility = $this->getPdo()->prepare("SELECT visibility FROM user WHERE id=".$_GET['see']);
                $recupVisibility->execute();
                $keys = $recupVisibility->fetchAll();


            
                if($_GET['see'] != $_SESSION['member']['id']){
                    if($keys[0]['visibility'] == 1){
                        $user = $this->getPdo()->prepare("UPDATE `user` SET `visibility`=0 WHERE id=".$_GET['see']);
                        $user->execute(); 
                    }else{
                        $user = $this->getPdo()->prepare("UPDATE `user` SET `visibility`=1 WHERE id=".$_GET['see']);
                        $user->execute(); 
                    }

                }
                else{
                    echo "Vous ne pouvez pas changer les droits de visibiilité de se compte !";
                }
                // $location = $_SERVER["REQUEST_URI"];
                // echo $location;
                

                header('location: yu4vana');
                exit();
            }

            if(isset($_GET['deleteAccount']) && $_SESSION['member']['status']==1){
                if($_GET['deleteAccount'] != $_SESSION['member']['id']){
                    $user = $this->getPdo()->prepare("DELETE FROM `user` WHERE id =".$_GET['deleteAccount']." AND status!= 1");
                    $user->execute(); 
                    $user = $this->getPdo()->prepare("
                    SET @num := 0;
                    UPDATE user SET id = @num := (@num+1);
                    ALTER TABLE user AUTO_INCREMENT = 1;");
                    $user->execute();
        
                    header('location: ./yu4vana?messageError=false');
                    exit();
                }else{
                    header('location: ./yu4vana?messageError=true');
                    exit();
                }
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
                
                $insert->execute();
            }catch(Exception $e){
                
                return "<p class='error'>". $e ." Merci de bien vouloir remplir le champs dédier au taux avant d'envoyer</p>";
            }
        }
    } 

    public function deleteAccount(){
        if(isset($_GET["messageError"]) && $_GET["messageError"]=="true" ){
            echo "<p class='error'>Vous ne pouvez pas supprimer ce compte !</p>";
        }
        else if(isset($_GET["messageError"]) && $_GET["messageError"]=="false"){
            echo "<p class='success'>Compte supprimé avec succès !</p>";
        }
    }
    /**
     * affiche le taux des admins
     *
     * @return void
     */
    public function tauxAdmin(){
        // On détermine sur quelle page on se trouve
        if(isset($_GET['page']) && !empty($_GET['page'])){
            $currentPage = (int) strip_tags($_GET['page']);
        }else{
            $currentPage = 1;
        }

        // On détermine le nombre total d'articles
        $sql = 'SELECT COUNT(*) AS nb_stats FROM `hebdo`;';

        $query = $this->getPdo()->prepare($sql);

        $query->execute();

        $result = $query->fetch();

        $nbtaux = (int) $result['nb_stats'];

        //nb de page total
        $tauxParPage = 10;
        $pages = ceil($nbtaux / $tauxParPage);


        //pagination

        $premier = ($currentPage * $tauxParPage) - $tauxParPage;

        $info = $this->getPdo()->prepare('SELECT DATE_FORMAT(`date`, "%d/%m/%Y à %H:%i:%s") AS `date`, `taux` FROM `hebdo`  ORDER BY `date` DESC LIMIT :premier, :tauxParPage;');
        $info->bindValue(':premier', $premier, PDO::PARAM_INT);
        $info->bindValue(':tauxParPage', $tauxParPage, PDO::PARAM_INT);
        $info->execute();


        
        echo '<th>Taux</th><th>Date/Heure</th>';
        $keys = $info->fetchAll();
   
        foreach($keys as $key){
            echo  "
            <tr>
            <td>". $key['taux'] . "% </td>
            <td>". $key['date'] . "</td>
            </tr>
            ";
        }
        ?>
        <thead>
            <tr>
                <nav role="pagination">
                    <ul id="pagination">
                        <!-- Lien vers la page précédente (désactivé si on se trouve sur la 1ère page) -->
                        <li class="page-item <?= ($currentPage == 1) ? "disabled" : "" ?>">
                            <a href="./yu4vana?page=<?= $currentPage - 1 ?>#pagination" class="page-link">Précédente</a>
                        </li>
                        <?php for($page = 1; $page <= $pages; $page++): ?>
                            <!-- Lien vers chacune des pages (activé si on se trouve sur la page correspondante) -->
                            <li class="page-item <?= ($currentPage == $page) ? "active" : "" ?>">
                                <a href="./yu4vana?page=<?= $page ?>#pagination" class="page-link"><?= $page ?></a>
                            </li>
                        <?php endfor?>
                            <!-- Lien vers la page suivante (désactivé si on se trouve sur la dernière page) -->
                            <li class="page-item <?= ($currentPage >= $pages) ? 'disabled' : "" ?>">
                                <a href="./yu4vana?page=<?= $currentPage + 1 ?>#pagination" class="page-link">Suivante</a>
                            </li>
                    </ul>
                </nav>
            </tr>
        </thead>
        <?php

    }
}

