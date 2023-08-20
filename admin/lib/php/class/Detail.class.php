<?php
class Detail extends Hydrate {
    private $_db;
    private $data = array();
    private $result;

    public function __construct($cnx){
        $this->_db = $cnx;
        var_dump($cnx);
    }


    public function addDetail($quantite, $id_commande, $id_manga){
        try {
            $query = "INSERT INTO detail(quantite, id_commande, id_manga) VALUES ( :quantite, :id_commande, :id_manga)";
            $res = $this->_db->prepare($query);
            $res->bindValue(':quantite', $quantite);
            $res->bindValue(':id_commande', $id_commande);
            $res->bindValue(':id_manga', $id_manga);

            $res->execute();
            $data = $res->fetch();
            if(!empty($data)){
                return $data;
            }
            else{
                return null;
            }
        }catch (PDOException $e){
            print "échec : ".$e->getMessage();
        }
    }


}
