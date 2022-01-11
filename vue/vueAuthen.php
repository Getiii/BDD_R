<?php

require_once 'util/utilitairePageHtml.php';
require_once __DIR__."/../modele/modele.php";

class Vue_Authn{

    function demandePseudo($param){

        $util = new UtilitairePageHtml();
        echo $util->genereEnteteHtml();
        echo  $util->genereMenuBarre(NULL);

        ?>
        <div id="pageConnexion">
            <br><br><br>
            <form action="index.php" method="post">
                <table align="center">
                    <tr>
                        <td>
                            Login:
                        </td>
                        <td>
                            <input id="text" type="text" name="login" size="20"/>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Mot de passe:
                        </td>
                        <td>
                            <input id="text" type="password" name="mdp" size="20"/>
                        </td>
                    </tr>
                    <tr>
                        <td>
                        </td>
                        <td>
                            <input class="bouton" id="boutton" type="submit" value="Envoyer"/>
                            <input class="bouton" id="boutton" type="reset" value="Annuler"/>
                        </td>
                        <td></td>
                    </tr>
                </table>
            </form>
            <?php
            if ($param != null){
                echo $param;
            }
            ?>
        </div>
        <?php

        echo $util->generePied();
    }

}

?>


