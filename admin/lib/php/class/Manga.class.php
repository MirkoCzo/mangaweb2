<?php

class Manga extends Hydrate
{
    private $_db;
    private $_array = array();

    public function __construct($cnx){
        $this->_db = $cnx;

    }

    public function getAllManga(){
        try{
            $query = "SELECT * FROM manga ORDER BY nom_manga";
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
        catch(PDOException $e){
            echo '<br>Echec de la connexion : '.$e->getMessage();
        }
    }

    public function deleteManga($id_manga)
    {
        try {
            $query = "DELETE FROM manga where id_manga = :id_manga";
            $res = $this->_db->prepare($query);
            $res->bindValue(':id_manga',$id_manga);
            $res->execute();
        }catch (PDOException $e)
        {
            print "Echec ".$e->getMessage();
        }
    }

    public function updateManga($champ,$valeur,$id_manga)
    {
        try
        {
            $query = "update manga set ".$champ." = :valeur WHERE id_manga= :id_manga";
            $res = $this->_db->prepare($query);
            $res->bindValue(':valeur',$valeur);
            $res->bindValue(':id_manga',$id_manga);
            $res->execute();
        }catch (PDOException $e)
        {
            print 'Echec'.$e->getMessage();
        }
    }
    public function addManga($nom_manga, $description, $prix, $id_categorie, $image){
        try{
            $query = "INSERT INTO manga (nom_manga, description, prix, id_categorie, image) values";
            $query.="('".$nom_manga."','".$description."','".$prix."', '".$id_categorie."','".$image."')";
            $res = $this->_db->prepare($query);
            $res->execute();
        }catch (PDOException $e){
            print "Echec".$e->getMessage();
        }

    }

    public function getNumberMangaById($id)
    {
        try
        {
            $query = "SELECT COUNT(*) as count FROM manga WHERE id_categorie = :id";
            $res = $this->_db->prepare($query);
            $res->bindValue(':id', $id);
            $res->execute();
            $data = $res->fetch();

            if (!empty($data)) {
                return $data['count'];
            } else {
                return 0;
            }
        } catch (PDOException $e) {
            print 'Echec : ' . $e->getMessage();
            return 0;
        }
    }

    public function getMangaByID($id)
    {
        try{
            $query="select * from manga where id_manga = :id";
            $res = $this->_db->prepare($query);
            $res->bindValue(':id',$id);
            $res->execute();
            $data = $res->fetch();
            if(!empty($data)) {
                return $data;
            }
            else{
                return 0;
            }
        }catch(PDOException $e){
            print "Echec ".$e->getMessage();
        }
    }




}