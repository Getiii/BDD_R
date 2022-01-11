<?php

require_once 'controleurAuth.php';
require_once 'controleurAcceuil.php';
require_once 'Controleur_Gestion.php';
require_once 'Controleur_Recherche.php';
require_once __DIR__."/../modele/modele.php";


class Routeur {

    private $controleurAuth;
    private $controleurAcc;
    private $Controleur_Gestion;
    private $controleur_Recherche;
    private $modele;


    public function __construct() {
        $this->controleurAuth= new controleurAuthentification();
        $this->controleurAcc = new controleurAccueil();
        $this->Controleur_Gestion = new Controleur_Gestion();
        $this->controleur_Recherche = new Controleur_Recherche();
        $this->modele= new Modele();
    }



    public function routerRequete() {

        try {

            if(isset($_GET['search'])){
                $this->controleur_Recherche->afficheur_Recherche();
                return;
            }

            if (isset($_GET['gestCommande'])){
                $this->Controleur_Gestion->afficherCommande();
                return;
            }

            if( isset($_GET['addGame'])){
                if (isset($_POST['agemini'])){
                    $this->modele->addJeux($_POST['nom_jeu'], $_POST['desc_Jeu'], $_POST['agemini'], $_POST['catejeu1'], $_POST['catejeu2'], $_POST['img']);
                }else{
                    $this->modele->addJeux($_POST['nom_jeu'], $_POST['desc_Jeu'],4, $_POST['catejeu1'], $_POST['catejeu2'],$_POST['img']);
                }

                header('location:index.php?gestJeux');
                $this->Controleur_Gestion->afficherJeux($_SESSION['login']);
                return;

            }

            if (isset($_GET['editJeu'])){
                if (isset($_POST["Editer"])){
                    $this->Controleur_Gestion->afficherJeu($_SESSION['login'], $_POST['id']);
                    return;
                }else{
                    $this->modele->deleteById($_POST['id']);
                    header('location:index.php?gestJeux');
                    $this->Controleur_Gestion->afficherJeux($_SESSION['login']);
                    return;
                }
            }

            if (isset($_GET['modifJeu'])){
                if (isset($_POST['envoyer'])){
                    $this->modele->modifJeu($_POST['id'], $_POST['nom'], $_POST['image'], $_POST['description'], $_POST['agemini'], $_POST['catejeu1'], $_POST['catejeu2']);
                    header('location:index.php?gestJeux');
                    $this->Controleur_Gestion->afficherJeux($_SESSION['login']);
                    return;
                }else {
                    $this->modele->deleteById($_POST['id']);
                    header('location:index.php?gestJeux');
                    $this->Controleur_Gestion->afficherJeux($_SESSION['login']);
                    return;
                }
            }

            if (isset($_GET['gestClient'])) {
                if (isset($_POST['Editer']) || isset($_POST['Supprimer'])){
                    if(isset($_POST['Supprimer'])){
                        $this->modele->deleteUserById($_POST['id']);
                        header('location:index.php?gestCompte');
                        $this->Controleur_Gestion->afficherCompte($_SESSION['login']);
                        return;
                    }else{
                        $this->Controleur_Gestion->afficherUnCompte($_SESSION['login'], $_POST['id']);
                        return;
                    }
                }else if (isset($_POST['Modifier'])) {
                        $this->modele->modifUser($_POST['id'], $_POST['nom_Compte'], $_POST['mdp']);
                        $this->Controleur_Gestion->afficherCompte($_SESSION['login']);
                        return;
                } else{
                    $this->Controleur_Gestion->afficherClients();
                    return;
                }

                if (isset($_GET['addUser'])){
                    return;
                }

            }else{
                $this->controleurAcc->afficher();
            }

        }catch(Exception $e) {}


    }


    // Traite une requête entrante
    /*public function routerRequete() {



        try {
        $this->controleur->accueil();

        }
        catch(Exception $e){}
   }*/
}



?>
