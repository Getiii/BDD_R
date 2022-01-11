<?php
require_once PATH_VUE."/vueAuthen.php";
require_once PATH_MODELE."/modele.php";



/**
 * Contrôleur de l'authentification d'un utilisateur.
 */
class ControleurAuthentification{
    private $vueAuthn;

    /**
     * Constructeur de la classe initialisant la vue de la page d'authentification.
     */
    public function __construct(){
        $this->vueAuthn=new Vue_Authn();
    }

    function invalid($param){
        if($param == 1 ){
            // 1 = Nouvelle venu sur la page
            $this->vueAuthn->demandePseudo(null);
        }else if ($param == 2){
            //2 = l'user c'est trompé de mdp ou login
            $error = "<h2 style = \"color:red;text-align: center \"> MAUVAISE COMBINAISON LOGIN / MOT DE PASSE !!</h2>";
            $this->vueAuthn->demandePseudo($error);

        }

    }

}


