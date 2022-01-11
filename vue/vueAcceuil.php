<?php

require_once 'util/utilitairePageHtml.php';
require_once __DIR__."/../modele/modele.php";

class Vue_Acc{

    function afficherAcc(){

        $util = new UtilitairePageHtml();
        echo $util->genereEnteteHtml();

        echo $util->genereMenuBarre(NULL);

        ?>
        <div id = "body">
            <div id = "bodySideLeft">
				<span class="BestLoc">
					<div>
                        <h3>A découvrir</h3>
                        <?php
                        $mod = new Modele();
                        $r = $mod->selectRandom();
                        echo "<table class='jeux'>";

                        echo "<thead><td>Nom</td><td>Description</td><td>Image</td><td class=\"button\">Action</td></thead>";
                        echo "<tbody>";

                        echo "<tr>";
                        echo "<td>".utf8_decode($r['nom'])."</td>";
                        echo "<td>".utf8_decode($r['description'])."</td>";
                        echo "<td><img src=".$r['image']."></td>";

                        echo "<form method='post' action='index.php?Reserver'>";

                        echo "<td><input type='hidden' value='".$r['id']."' name='id'><input type='submit' class=\"bouton\" name='Reserver' value='Reserver' onClick=\"javascript: return confirm('Veuillez confirmez la réservation');\"'</td>";
                        echo "</form>";

                        echo "</tr>";


                        echo "<br>";
                        echo "</tbody>";
                        echo "</table>"
                        ?>
					</div>
				</span>
            </div>

            <div id="bodySideRight">
                <h3>Sortie prochaine !</h3>
                <img src="https://images.igdb.com/igdb/image/upload/t_cover_big/co1uwf.jpg">
                <img src="https://images.igdb.com/igdb/image/upload/t_cover_big/co2gnx.jpg">
            </div>
        </div>
        <?php
        echo $util->generePied();
    }

}

?>


