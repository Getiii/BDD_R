<?php
require_once PATH_VUE."/Vue_Gestion.php";
require_once PATH_MODELE."/modele.php";



/**
 * Contrôleur de l'authentification d'un utilisateur.
 */
class Controleur_Gestion{
    private $vueGest;

    /**
     * Constructeur de la classe initialisant la vue de la page d'authentification.
     */
    public function __construct(){
        $this->vueGest = new Vue_Gestion();
    }

    function afficherCommandes(){
        $this->vueGest->afficherGestionCommandes();
    }

    function afficherCommande($param1, $param2){
        $this->vueGest->afficherGestionCommande($param1, $param2);
    }

    function afficherClients(){
        $this->vueGest->afficherGestionClients();
    }


    function afficherUnClient($param1, $param2){
        $this->vueGest->afficherGestionClient($param1, $param2);
    }
}


