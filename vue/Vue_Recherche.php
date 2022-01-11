<?php

require_once 'util/utilitairePageHtml.php';
require_once __DIR__."/../modele/modele.php";

class Vue_Recherche{

    function afficherRecherche($param){

        $util = new UtilitairePageHtml();
        echo $util->genereEnteteHtml();

        if ($param != NULL){
            echo $util->genereMenuBarre($param);
        }else{
            echo $util->genereMenuBarre(NULL);
        }

        ?>
        <div id = "body">
            <div>
<?php
                $mod = new Modele();
                if (isset($_POST['Rechercher']))
                    $result = $mod->rechercheJeux($_POST['Rechercher']);
                else
                    $result = $mod->rechercheJeux('');

                echo "<table class='jeux'>";
                echo "<thead><td>Nom</td><td class='description'>Description</td><td>Age minimum</td><td>Image</td><td>Catégorie</td><td class=\"button\">Action</td></thead>";
                echo "<tbody>";

                foreach ($result as $key => $value){
                    echo "<tr>";
                    echo "<form method='post' action='index.php?Reserver'>";
                    foreach ($value as $cle => $valeur){
                        if ($cle == 'image'){
                            echo "<td><img src='$valeur'></td>";
                        }else if ($cle != 'id') {
                            echo "<td>" . utf8_decode($valeur) . "</td>";
                        }
                    }
                    $resultat = $mod->getCate($value['id']);


                    echo "<td>";
                    foreach ($resultat as $clef => $cat){
                        foreach ($cat as $clefCat => $catJeux){
                            echo $catJeux."<br>";
                        }
                    }
                    echo "</td>";
                    echo "<td><input type='hidden' value='".$value['id']."' name='id'><input class=\"bouton\" type='submit' name='Reserver' value='Reserver' onClick=\"javascript: return confirm('Veuillez confirmez la réservation');\"'</td>";
                    echo "</form>";
                    echo "</tr>";
                }
                echo "</tbody>";
                echo "</table>"
?>
            </div>
        </div>
        <?php
        echo $util->generePied();
    }

}

?>
