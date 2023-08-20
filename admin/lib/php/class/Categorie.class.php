<?php

class Categorie extends Hydrate
{
    private $_db;
    private $_array;
    private $data = array();

    public function __construct($cnx){
        $this->_db = $cnx;
        var_dump($cnx);
    }

    public function getAllCategorie()
    {
        try {
            $query = "SELECT * FROM categorie";
            $res = $this->_db->prepare($query);
            $res->execute();
            while($data = $res->fetch()){
                $_array[]=new Hydrate($data);
            }
            if(empty($_array)){
                return null;
            }
            else{
                return $_array;
            }
        }
        catch (PDOException $e){
            echo 'echec : '.$e->getMessage();
        }
    }
    public function getAllCategoriesJSON()
    {
        $categories = $this->getAllCategorie();
        return json_encode($categories);
    }

    public function getCategorieByID($iden){
        try {
            $query = "SELECT nom_categorie from categorie where id_categorie = :iden";
            $res = $this->_db->prepare($query);
            $res->bindValue(':iden',$iden);
            $res->execute();
            $data = $res->fetch();
            if(!empty($data))
            {
                return $data['nom_categorie'];
            }
            else
            {
                return false;
            }
        }catch (PDOException $e)
        {
            print "échec : ".$e->getMessage();
            return false;
        }
    }


}