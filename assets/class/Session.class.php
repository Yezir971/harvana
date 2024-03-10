<?php

class Session {
    /**
     * la fonction vérifie si le compte est un bien celui d'un admin
     *
     * @return void
     */
    public function adminAccess(){
        // var_dump($_SESSION['member']);
        if($_SESSION['member']['status']==0){
            session_destroy();
            header('location: ../../index');
        }    
    }
    /**
     * permet de se deconnecter de sa session
     *
     * @param [string] $bouton
     * @return void
     */
    public function destroy() {
        // $boutton = $_POST['decoSession'];
        if(isset($_POST['decoSession']) && $_POST['decoSession']='Déconnexion'){
            session_destroy();
            header('location: ../../index');
        }
    }

    public function destroyHebdo() {
        // $boutton = $_POST['decoSession'];
        if(isset($_POST['decoSession']) && $_POST['decoSession']='Déconnexion'){
            session_destroy();
            header('location: index');
        }
    }

    /**
     * affiche les données de la session, outils de debug
     *
     * @return void
     */
    public function afficheSession() {
        
        if(isset($_POST['PrintSession']) && $_POST['PrintSession']=='Affichez un var_dump de la session'){
            echo var_dump($_SESSION);
        }
    } 

    /**
     * vérifie que la l'utilisateur à le droit d'accéder à la page hebdomadaire
     * 
     * @return void
     */
    public function visibility() {
        if($_SESSION['member']['visibility']==0){
            header('location:index');
            session_destroy();
        }
    }

    public function get_info(string $var): string {
        if($var == 'firstname'){
            return $_SESSION['member']['firstname'];
        }else if($var == 'email'){
           return $_SESSION['member']['email'];
        }
    }
}
?>