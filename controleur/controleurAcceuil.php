<?php
require_once PATH_VUE."/vueAcceuil.php";
require_once PATH_MODELE."/modele.php";



/**
 * Contrôleur de l'authentification d'un utilisateur.
 */
class ControleurAccueil{
    private $vueAcc;

    /**
     * Constructeur de la classe initialisant la vue de la page d'authentification.
     */
    public function __construct(){
        $this->vueAcc=new Vue_Acc();
    }

    function afficher(){
        $this->vueAcc->afficherAcc();
    }

}


