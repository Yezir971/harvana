<?php

class Hebdo extends Bdd{
    public function taux(){
        $info = $this->getPdo()->prepare('SELECT DATE_FORMAT(`date`, "%d/%m/%Y à %H:%i:%s") AS `date`, `taux` FROM `hebdo`');
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
    }


}