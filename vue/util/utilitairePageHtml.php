<?php


/**
 * Classe permettant la génération de l'entête, du menu et du pied de page.
 */
class UtilitairePageHtml
{

    /**
     * Fonction permettant de générer l'entête HTML.
     * @return String l'entête du site.
     */
    public function genereEnteteHtml()
    {
        $entete = "<!DOCTYPE html>\n";
        $entete .= "<html>\n";
        $entete .= "<head>\n\t";
        $entete .= "<title>Gestion de commandes</title>\n\t";
        $entete .= "<meta charset=\"UTF-8\">\n\t";
        $entete.= "<link rel=\"stylesheet\" href=\"vue/css/style.css\"> \n";
        $entete.= "<script src=\"vue/JavaScript.js\"></script>";
        $entete .= "</head>\n";
        $entete .= '<body>' . "\n" . '
    ';
        return $entete;
    }


    public function genereMenuBarre(){

        $menu = "<div id = \"header\">";
            $menu .= "<div id =\"title\">";
                $menu .= "<a href ='index.php'>";
                $menu .= "&nbspGestion de fiche client</></a> ";
            $menu .= "</div>";

            $menu .= "<nav id = \"menuBar\">";
                    $menu .= "<ul>
                                <li class=\"deroulant\"><a href=\"?gestClient\">Clients &ensp;</a>
                                </li>
                                <li class=\"deroulant\"><a href=\"#\">Commandes &ensp;</a>
                                  <ul class=\"sous\">
                                    <li><a href=\"#\">Modifier</a></li>
                                    <li><a href=\"#\">Générer facture</a></li>
                                    <li><a href=\"#\">Liste commande</a></li>
                                  </ul>
                                </li>
                              </ul>";

        $menu .= "</nav></div>";

        return $menu;
    }



    public function generePied()
    {

        $pied= '';


        return $pied;
    }

}