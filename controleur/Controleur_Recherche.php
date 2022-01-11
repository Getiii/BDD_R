<?php

require_once PATH_VUE."/Vue_Recherche.php";
require_once PATH_MODELE."/modele.php";

class Controleur_Recherche
{
    private $vueRecherche;

    public function __construct(){
        $this->vueRecherche = new Vue_Recherche();
    }


    public function afficheur_Recherche(){
        if (isset($_SESSION['login']))
            $this->vueRecherche->afficherRecherche($_SESSION['login']);
        else
            $this->vueRecherche->afficherRecherche(null);
    }
}