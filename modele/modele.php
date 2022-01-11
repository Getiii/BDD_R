<?php


// Classe generale de definition d'exception
class MonException extends Exception{
    private $chaine;
    public function __construct($chaine){
        $this->chaine=$chaine;
    }

    public function afficher(){
        return $this->chaine;
    }

}


// Exception relative à un probleme de connexion
class ConnexionException extends MonException{
}

// Exception relative à un probleme d'accès à une table
class TableAccesException extends MonException{
}


class Modele{

    private $connexion;



    public function __construct(){
        try{

            date_default_timezone_set('Europe/London');
            $chaine="mysql:host=".HOST.";dbname=".BD;
            $this->connexion = new PDO($chaine,LOGIN,PASSWORD);
            $this->connexion->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        }
        catch(PDOException $e){
            $exception=new ConnexionException("problème de connexion à la base");
            throw $exception;
        }
    }



    // utiliser une requête préparée
    //vérifie qu'un pseudo existe dans la table pseudonyme
    // post-condition retourne vrai si le pseudo existe sinon faux
    // si un problème est rencontré, une exception de type TableAccesException est levée
    public function exists($nom_Compte){
        try{
            $statement = $this->connexion->prepare("select nom_Compte from user_ludotheque where nom_Compte=?;");
            $statement->bindParam(1, $nom_Compte);
            $statement->execute();
            $result=$statement->fetch(PDO::FETCH_ASSOC);

            if ($result['nom_Compte']!= null){
                return true;
            }
            else{
                return false;
            }
        }
        catch(PDOException $e){
            throw new TableAccesException("problème avec la table pseudonyme");
        }
    }


    public function isAdmin($nom_Compte){
        $statement = $this->connexion->prepare("select admin from user_ludotheque where nom_Compte=?;");
        $statement->bindParam(1, $nom_Compte);
        $statement->execute();

        $result=$statement->fetch(PDO::FETCH_ASSOC);
        return $result['admin'];
    }

    public function verificationMdp($login, $motdepasse){

        $statement = $this->connexion->prepare("select mdp from user_ludotheque where nom_Compte=?;");
        $statement->bindParam(1, $login);
        $statement->execute();

        $result=$statement->fetch(PDO::FETCH_ASSOC);

        //if (crypt($motdepasse, $result['motDePasse'])== $result['motDePasse']) {
        if ($motdepasse == $result['mdp']){
            return true;
        } else {
            return false;
        }
    }

    public function getDescription(){
        $statement = $this->connexion->prepare("select id, nom, image, description, agemini from jeux");
        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }


    public function getJeux(){

        $statement = $this->connexion->prepare("select * from jeux");
        $statement->execute();

        while ($ligne = $statement->fetch()) {
            $result[] = $ligne['nom'];
        }

        return $result;
    }


    public function getDescriptionById($idJeu){
        $statement = $this->connexion->prepare("select id, nom, image, description, agemini from jeux where id = ?;");
        $statement->bindParam(1, $idJeu);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }


    public function getCate($idJeu){
        $statement = $this->connexion->prepare("SELECT nom_cat FROM categorie c WHERE c.id IN (SELECT id_cat FROM cat_jeu cj WHERE cj.id_jeu = ?) GROUP BY id;");
        $statement->bindParam(1,$idJeu);

        $statement->execute();

        $result = $statement->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }


    public function getAllCate(){
        $statement = $this->connexion->prepare("SELECT nom_cat from categorie;");

        $statement->execute();

        $result = $statement->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }


    public function deleteById($idJeu){
        $statement = $this->connexion->prepare("delete from cat_jeu where id_jeu = ?");
        $statement->bindParam(1,$idJeu);
        $statement->execute();

        $statement = $this->connexion->prepare("delete from jeux where id = ?;");
        $statement->bindParam(1,$idJeu);
        $statement->execute();
    }


    public function getClient(){

        $statement = $this->connexion->prepare("select * from clients");
        $statement->execute();

        while ($ligne = $statement->fetch()) {
            $result[] = $ligne['codeclient'];
        }

        return $result;

    }


    public function getInfoClient($id){

        $statement = $this->connexion->prepare("select * from clients where codeclient = ?;");
        $statement->bindParam(1,$id);

        $statement->execute();

        $result = $statement->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getCartClient($id){
        $statement = $this->connexion->prepare("select * from card where codeclient = ?;");
        $statement->bindParam(1,$id);

        $statement->execute();

        $result = $statement->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getMembership($id){
        $statement = $this->connexion->prepare("select nameMembership from membership where idMembership = ?;");
        $statement->bindParam(1,$id);

        $statement->execute();

        $result = $statement->fetch(PDO::FETCH_ASSOC);
        return $result;
    }


    public function getPointbyCard($id){
        $statement = $this->connexion->prepare("select SUM(numPoint) as nbPoint from points where idPoints IN (SELECT idPoints FROM cartepoint WHERE idCard = ?);");
        $statement->bindParam(1,$id);

        $statement->execute();

        $result = $statement->fetch(PDO::FETCH_ASSOC);

        return $result;
    }


    public function addJeux($nom_Jeux, $desc, $age_mini, $categorie1, $categorie2, $img){
        $statement = $this->connexion->prepare("INSERT into jeux(nom, description, agemini,image) VALUES (?,?,?,?);");
        $statement->bindParam(1,utf8_encode($nom_Jeux));
        $statement->bindParam(2,utf8_encode($desc));
        $statement->bindParam(3,$age_mini);
        $statement->bindParam(4,$img);
        $statement->execute();

        $statement2 = $this->connexion->prepare("SELECT id FROM jeux ORDER BY id DESC LIMIT 1;");
        $statement2->execute();
        $result1 = $statement2->fetch(PDO::FETCH_ASSOC);


        $statement3 = $this->connexion->prepare("SELECT id from categorie where nom_cat = :categorie;");
        $statement3->bindParam(':categorie',$categorie1, PDO::PARAM_STR,12);
        $statement3->execute();
        $result2 = $statement3->fetch(PDO::FETCH_ASSOC);


        $statement4 = $this->connexion->prepare("INSERT INTO cat_jeu(id_jeu,id_cat) VALUES (?,?);");
        $statement4->bindParam(1, $result1['id']);
        $statement4->bindParam(2,$result2['id']);
        $statement4->execute();


        $statement5 = $this->connexion->prepare("SELECT id from categorie where nom_cat = ?;");
        $statement5->bindParam(1,$categorie2);
        $statement5->execute();
        $result3 = $statement5->fetch(PDO::FETCH_ASSOC);


        $statement6 = $this->connexion->prepare("INSERT INTO cat_jeu(id_jeu,id_cat) VALUES (?,?);");
        $statement6->bindParam(1, $result1['id']);
        $statement6->bindParam(2,$result3['id']);
        $statement6->execute();

    }


    public function addUser($nom, $mdp, $isAdmin){

        $statement = $this->connexion->prepare("INSERT into user_ludotheque(nom_compte, mdp, admin) values (?,?,?);");
        $statement->bindParam(1, $nom);
        $statement->bindParam(2, $mdp);
        $statement->bindParam(3, $isAdmin);
        $statement->execute();
    }


    public function deleteUserById($id){

        $statement = $this->connexion->prepare("delete from user_ludotheque where id = ?;");
        $statement->bindParam(1,$id);

        $statement->execute();

    }


    public function modifJeu($id, $nom, $path, $desc, $agemini, $cate1, $cate2){

        $statement = $this->connexion->prepare("update jeux set nom = ?, image = ?, description = ?, agemini = ? where id = ?;");
        $statement->bindParam(1,utf8_encode($nom));
        $statement->bindParam(2,utf8_encode($path));
        $statement->bindParam(3,utf8_encode($desc));
        $statement->bindParam(4,$agemini);
        $statement->bindParam(5,$id);
        $statement->execute();



        $statement2 = $this->connexion->prepare("Select id from categorie Where nom_cat = ?");
        $statement2->bindParam(1, $cate1);
        $statement2->execute();
        $result = $statement2->fetch(PDO::FETCH_ASSOC);


        $statement5 = $this->connexion->prepare("Select id from cat_jeu where id_jeu = ?");
        $statement5->bindParam(1, $id);
        $statement5->execute();
        $result1 = $statement5->fetch(PDO::FETCH_ASSOC);




        if ($result1 != null){
            $statement3 = $this->connexion->prepare("delete from cat_jeu where id_jeu = ?");
            $statement3->bindParam(1, $id);
            $statement3->execute();
        }

        $statement4 = $this->connexion->prepare("INSERT INTO cat_jeu(id_jeu,id_cat) VALUES (?,?);");
        $statement4->bindParam(1, $id);
        $statement4->bindParam(2, $result['id']);
        $statement4->execute();

        var_dump($cate2);
        $statement2 = $this->connexion->prepare("Select id from categorie Where nom_cat LIKE ?");
        $statement2->bindParam(1, $cate2);
        $statement2->execute();
        $result = $statement2->fetch(PDO::FETCH_ASSOC);
        var_dump($result);



        $statement4 = $this->connexion->prepare("INSERT INTO cat_jeu(id_jeu,id_cat) VALUES (?,?);");
        $statement4->bindParam(1, $id);
        $statement4->bindParam(2, $result['id']);
        $statement4->execute();


    }


    public function modifUser($id, $nom, $mdp, $isAdmin){
        $statement = $this->connexion->prepare("UPDATE user_ludotheque set nom_compte = ?, mdp = ?, admin = ? where id = ?;");
        $statement->bindParam(1, utf8_encode($nom));
        $statement->bindParam(2, $mdp);
        $statement->bindParam(3, $isAdmin);
        $statement->bindParam(4, $id);
        $statement->execute();
    }


    public function rechercheJeux($value){

        if ($value == null)
            $value = '';

        if (is_numeric($value)){
            $statement = $this->connexion->prepare("SELECT * from jeux where (nom like '%$value%' or 
                          id  IN (SELECT id_jeu from cat_jeu where id_cat IN (SELECT id from categorie where nom_cat like '%$value%')
                            ) or agemini > ? )AND id NOT IN (SELECT id_jeux FROM booking); ");
            $statement->bindParam(1, $value);
        }else{
            $statement = $this->connexion->prepare("SELECT * from jeux where (nom like '%$value%' or 
                          id  IN (SELECT id_jeu from cat_jeu where id_cat IN (SELECT id from categorie where nom_cat like '%$value%')
                            ))AND id NOT IN (SELECT id_jeux FROM booking); ");
        }


        $statement->execute();

        $result = $statement->fetchAll(PDO::FETCH_ASSOC);


        return $result;
    }


    public function addResa($id_Jeux, $id_joueur)
    {

        $StatmentnbResa = $this->connexion->prepare("Select COUNT(*) as cpt from booking where id_Member = ?;");
        $StatmentnbResa->bindParam(1, $this->getIdparLogin($id_joueur)['ID']);
        $StatmentnbResa->execute();

        $r = $StatmentnbResa->fetch(PDO::FETCH_ASSOC);

        if ($r['cpt'] < 3) {
            $statement = $this->connexion->prepare("INSERT INTO booking (id_Member, id_Jeux, Date_resa, Date_retour)
                                                  VALUES ( ?,?,CAST(CURDATE() as DATE),CAST(DATE_ADD(CURDATE(), INTERVAL 60 DAY) as DATE))");
            $statement->bindParam(1, $this->getIdparLogin($id_joueur)['ID']);
            $statement->bindParam(2, $id_Jeux);
            $statement->execute();
        }
    }


    public function getIdparLogin($login){
        $statement = $this->connexion->prepare("SELECT ID from user_ludotheque where nom_Compte = ?;");
        $statement->bindParam(1,$login);
        $statement->execute();

        return $result = $statement->fetch(PDO::FETCH_ASSOC);
    }


    public function getResa($id){
        $statement = $this->connexion->prepare("SELECT * from booking where id_Member = ?;");
        $statement->bindParam(1,$id);
        $statement->execute();

        return $result = $statement->fetchAll(PDO::FETCH_ASSOC);

    }


    public function RendreResa($id_Jeux){
        $statement = $this->connexion->prepare("delete from booking where id_Jeux = ?;");
        $statement->bindParam(1, $id_Jeux);
        $statement->execute();
    }


    public function selectRandom(){
        $statement = $this->connexion->prepare("select * from jeux where id NOT IN (SELECT id_jeux FROM booking) order by RAND(); ");
        $statement->execute();

        $r = $statement->fetch(PDO::FETCH_ASSOC);
        return $r;
    }


    public function getResaAllUser(){
        $statement = $this->connexion->prepare("SELECT b.id_Jeux, b.id_Member, u.nom_Compte, j.nom, j.description, j.image, j.agemini
                                                          FROM booking b, user_ludotheque u, jeux j WHERE b.id_Jeux = j.id AND 
                                                                          b.id_Member = u.id");

        $statement->execute();

        $r = $statement->fetchAll();

        return $r;

    }
}




?>