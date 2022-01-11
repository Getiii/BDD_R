<?php
require_once 'util/utilitairePageHtml.php';
require_once __DIR__."/../modele/modele.php";

class Vue_Gestion
{

    /***
     * @param $param
     * @throws ConnexionException
     */
    function afficherGestionCommandes(){

        $util = new UtilitairePageHtml();
        echo $util->genereEnteteHtml();


        echo $util->genereMenuBarre();

        ?>

        <div id = "body_Gest">
            <form  class="abc" action="index.php" method="post">
                <table class="TableAjouterJeu">
                    <tr>
                        <td><label for="nom_jeu">Nom du jeu</label>
                            <input type="text" name="nom_jeu" id="nom_jeu">
                        </td>

                        <td><label for="description_jeu">Description</label>
                            <textarea rows="10" cols="50" name="desc_Jeu" id="description_jeu" style="resize: none"> </textarea></td>

                        <td><label for="agemini">Age mini :</label>
                            <input type="number" id="agemini" name="agemini" min="5" max="18">
                        </td>
                        <td><label for="img">Lien image : </label>
                            <input type="text" id="img" name="img">
                        </td>

                        <td>
                            <label for="catejeu">Catégorie 1 :</label>
                            <select name="catejeu1" id="catejeu">
                                <option value="">Choisir une catégorie</option>
                            <?php
                            $modele = new Modele();

                            $resultat= $modele->getAllCate();

                            echo "";
                            for ($i = 0; $i < count($resultat); $i++){
                                foreach ($resultat[$i] as $cle =>$value){
                                    echo "<option value='".$value."'>$value</option><br/>";
                                }
                            }
                            ?>
                            </select>
                            <br/>


                            <label for="catejeu">Catégorie 2:</label>
                            <select name="catejeu2" id="catejeu2">
                                <option value="">Choisir une catégorie</option>
                            <?php
                            $modele = new Modele();

                            $resultat= $modele->getAllCate();


                            for ($i = 0; $i < count($resultat); $i++){
                                foreach ($resultat[$i] as $cle =>$value){
                                    echo "<option value='".$value."'>$value</option><br/>";
                                }
                            }
                            ?>
                        </td>

                        <td>
                            <input type="submit" class="envoyer bouton">
                        </td>
                    </tr>
                </table>
            </form>

            <table class="jeux">
                <thead><td>Id</td><td>Nom</td><td>Image</td><td>Description</td><td>Age minimum</td><td>Catégorie</td><td class="button">Action</td></thead>

                <tbody>
                <?php

                $modele = new Modele();

                $resultat = $modele->getDescription();

                for ($i = 0; $i < count($resultat); $i++) {
                    echo "<form action='index.php?editJeu' method='post'><tr>";

                    $ligne = $resultat[$i];
                    $test = $modele->getCate($ligne['id']);

                    foreach ($ligne as $cle => $value) {
                        if ($cle == 'image') {
                            echo "<td class='$cle'><img class='$cle' src='$value'></td>";
                        } else if ($cle == 'id'){
                            echo "<td class='$cle'><p>".utf8_decode($value)."</p></td>";
                            echo "<input name='id' value='$value' type='hidden'>";
                        }else{
                            echo "<td class='$cle'><p>".utf8_decode($value)."</p></td>";
                        }
                    }

                    echo "<td class='cate'>";
                    for ($j = 0; $j < count($test); $j++){
                        foreach ($test[$j] as $cle => $value){
                            echo "<p>".utf8_decode($value)."</p>";
                        }
                    }
                    echo "</td>";
                    echo "<td><input type='submit' class='bouton' name='Editer' value='Editer' onClick=\"javascript: return confirm('Veuillez confirmez la modification');\"'>";
                    echo "<input type='submit' class='bouton' name='Supprimer' value='Supprimer'onClick=\"javascript: return confirm('Veuillez confirmez la suppression');\"></a></td>";

                    echo "</tr></form>";
                }

                ?>
                </tbody>
            </table>
        </div>
        <?php
        echo $util->generePied();
    }


    /***
     * @param $param
     * @throws ConnexionException
     */
    function afficherGestionClients(){

        $util = new UtilitairePageHtml();
        echo $util->genereEnteteHtml();
        echo $util->genereMenuBarre();


        ?>
        <div id = "body_Gest">

            <form  class="abc" action="index.php?addClient" method="post">
                <table class="TableAjouterJeu">
                    <tr>
                        <td><label for="id_Client">id Client : </label>
                            <input type="text" name="id_Client" id="id_Client">
                        </td>

                        <td><label for="nom_Client">Nom :</label>
                            <input type="text" id="nom_Client" name="nom_Client" >
                        </td>

                        <td><label for="mail">Mail : </label>
                            <input type="text" id="mail" name="mail">
                        </td>

                        <td><label for="Facebook">Facebook : </label>
                            <input type="text" id="Facebook" name="Facebook">
                        </td>

                        <td><label for="Instagram">Instagram : </label>
                            <input type="text" id="Instagram" name="Instagram">
                        </td>

                        <td><label for="Membership">Membership : </label>
                            <input type="text" id="Membership" name="Membership">
                        </td>

                        <td>
                            <input type="submit" class="envoyer">
                        </td>
                    </tr>
                </table>
            </form>
            <br/><br/>

            <table class="Client">
                <thead><td>ID_Compte</td></tdt><td>Nom du client</td><td>mail</td><td>Facebook</td><td>instagram</td><td>Membership</td><td>N° points</td><td>Modification</td></thead>
                <?php


                $modele = new Modele();

                $resultat = $modele->getClient();
                $resultatMemShip = NULL;
                $resultPoint = NULL;


                foreach ($resultat as $cle => $value){
                    $result = $modele->getInfoClient($value);
                    echo "<form action='index.php?gestClient' method='post'><tr>";
                    foreach ($result as $key => $valeur){
                        if ($key == "codeclient"){
                            $resultatCart = $modele->getCartClient($valeur);
                            $resultatMemShip = $modele->getMembership($resultatCart["idMembership"]);
                            $resultPoint = $modele->getPointbyCard($resultatCart['idCard']);

                        }
                        echo "<td class='$key'><p>".utf8_decode($valeur)."</p>";
                        echo "<input type='hidden' value='$valeur' name='$key'></td>";
                    }

                    echo "<td>".$resultatMemShip["nameMembership"]."</td>";
                    echo "<td>".$resultPoint["nbPoint"]."</td>";
                    echo "</td>";
                    echo "<td><input type='submit' name='Editer' value='Editer' onClick=\"javascript: return confirm('Veuillez confirmez la modification');\"'>";
                    echo "<input type='submit' name='Supprimer' value='Supprimer'onClick=\"javascript: return confirm('Veuillez confirmez la suppression');\"></a></td>";
                    echo "</tr></form>";
                }


                ?>
            </table>
        </div>
        <?php
        echo $util->generePied();
    }


    function afficherGestionCommande($param, $param2){
        $util = new UtilitairePageHtml();
        echo $util->genereEnteteHtml();

        if ($param != NULL){
            echo $util->genereMenuBarre($param);
        }else{
            echo $util->genereMenuBarre(NULL);
        }
        ?>

        <table class="jeux">
            <thead>
            <td>Id</td>
            <td>Nom</td>
            <td>Image</td>
            <td>Description</td>
            <td>Age mini</td>
            <td>Catégorie</td>
            <td>Action</td>
            </thead>
            <tbody>
            <tr>
                <form action="index.php?modifJeu" method="post">
<?php
                    $modele = new Modele();
                    $result = $modele->getDescriptionById($param2);

                    $ligne = $result[0];

                    foreach ($ligne as $cle => $value) {
                        if ($cle=='image'){
                            echo "<td class='$cle'><img class='$cle' src='$value'>";
                            echo "<input name='$cle' type='text' value='$value'></td>";
                        }else if($cle != 'id' && $cle !='description'){
                            echo "<td class='$cle'><p>".utf8_decode($value)."</p>";
                            echo "<input name='$cle' type='text' value='".utf8_decode($value)."'required></td>";
                        }else if ($cle == 'description'){
                            echo "<td class='$cle'><p>".utf8_decode($value)."</p>";
                            echo "<textarea name='$cle' value='$value' style='resize: none; width: 72%; height: 25%'>$value</textarea></td>";
                        }else{
                            echo "<td class='$cle'><input name='id' type='hidden' value='".utf8_decode($value)."'>".utf8_decode($value)."</td>";
                        }



                    }
                    $result1 = $modele->getCate($param2);

                    if (count($result1)>1) {
                        echo "<td class='cate'>";
                        for ($j = 0; $j < count($result1); $j++) {
                            foreach ($result1[$j] as $cle => $value) {
                                echo '<label for="catejeu">Catégorie' . ++$j . ':</label>
                                    <select required name="catejeu' . $j . '" id="catejeu">
                                        <option value=' . $value . '>' . $value . '</option>
                                    ';
                                $j--;
                                $resultat = $modele->getAllCate();

                                echo "";
                                for ($i = 0; $i < count($resultat); $i++) {
                                    foreach ($resultat[$i] as $cle => $value) {
                                        echo "<option value='" . $value . "'>$value</option><br/>";
                                    }
                                }

                                echo "</select>";
                            }
                        }
                        echo "</td>";
                    }else {
                        echo "<td class='cate'>";
                        for ($j = 0; $j < 2; $j++) {
                            echo '<label for="catejeu">Catégorie' . ++$j . ':</label>
                                    <select required name="catejeu' . $j . '" id="catejeu">
                                        <option value="">Choisissez une catégorie : </option>
                                    ';
                            $j--;
                            $resultat = $modele->getAllCate();

                            echo "";
                            for ($i = 0; $i < count($resultat); $i++) {
                                foreach ($resultat[$i] as $cle => $value) {
                                    echo "<option value='" . $value . "'>$value</option><br/>";
                                }
                            }

                            echo "</select>";
                        }
                    }
                        echo "<td>";
                        echo '<input type="submit" name="envoyer">';
                        echo "<input type='submit' name='supprimer' value='Supprimez' onClick=\"javascript: return confirm('Veuillez confirmez la suppression');\"'></td>";

                        ?>
                </form>
            </tr>
            </tbody>
        </table>
<?php
        echo $util->generePied();
    }

    public function afficherGestionClient($param, $param2){
        $util = new UtilitairePageHtml();
        echo $util->genereEnteteHtml();

        if ($param != NULL){
            echo $util->genereMenuBarre($param);
        }else{
            echo $util->genereMenuBarre(NULL);
        }

        $modele = new Modele();


        $result = $modele->getInfoUser($param2);
        echo "<table class='jeux' style='margin-top: 2em'>";
        echo "<thead><td>ID_Compte</td></tdt><td>Nom du compte</td><td>mdp</td><td>Is Admin</td><td class='button'>Action</td></thead>";

        echo "<form action='index.php?gestCompte' method='post'><tr>";
        foreach ($result as $key => $valeur){
            if ($key == 'id'){
                echo "<td class='$key'><p>".utf8_decode($valeur)."</p>";
                echo "<input type='hidden' value='$valeur' name='$key'></td>";
            }else if($key == 'nom_Compte'){
                echo "<td class='$key'><p>".utf8_decode($valeur)."</p>";
                echo "<input type='text' value='$valeur' name='$key'></td>";
            }else if ($key == 'mdp'){
                echo "<td class='$key'><p>".utf8_decode($valeur)."</p>";
                echo "<input type='password' value='$valeur' name='$key'></td>";
            }else{
                echo "<td class='$key'><p>".utf8_decode($valeur)."</p>";
                if ($valeur == 1){
                    echo "<input type='checkbox' checked value='1' name='$key'></td>";
                }else{
                    echo "<input type='checkbox' value='0' name='$key'></td>";
                }
            }

        }
        echo "</td>";
        echo "<td><input type='submit' name='Modifier' value='Modifier' onClick=\"javascript: return confirm('Veuillez confirmez la modification');\"'>";
        echo "<input type='submit' name='Supprimer' value='Supprimer'onClick=\"javascript: return confirm('Veuillez confirmez la suppression');\"></a></td>";
        echo "</tr></form>";
        echo "<table>";


        echo $util->generePied();
    }

}
?>