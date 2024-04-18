<?php

class Hebdo extends Bdd{
    /**
     * fonction qui va retourner le taux dans un tableau html
     *
     * @return void
     */
    public function taux(){

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
                            <a href="./hebdo?page=<?= $currentPage - 1 ?>#pagination" class="page-link">Précédente</a>
                        </li>
                        <?php for($page = 1; $page <= $pages; $page++): ?>
                            <!-- Lien vers chacune des pages (activé si on se trouve sur la page correspondante) -->
                            <li class="page-item <?= ($currentPage == $page) ? "active" : "" ?>">
                                <a href="./hebdo?page=<?= $page ?>#pagination" class="page-link"><?= $page ?></a>
                            </li>
                        <?php endfor?>
                            <!-- Lien vers la page suivante (désactivé si on se trouve sur la dernière page) -->
                            <li class="page-item <?= ($currentPage >= $pages) ? 'disabled' : "" ?>">
                                <a href="./hebdo?page=<?= $currentPage + 1 ?>#pagination" class="page-link">Suivante</a>
                            </li>
                    </ul>
                </nav>
            </tr>
        </thead>
        <?php
    }
}