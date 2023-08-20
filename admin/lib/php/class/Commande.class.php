<?php

class Commande extends Hydrate
{
    private $_db;
    private $data = array();
    private $result;

    public function __construct($cnx){
        $this->_db = $cnx;
        var_dump($cnx);
    }

    public function addCommande($id_commande, $date_commande, $prix_commande, $id_client){
        try {
            $query = "INSERT INTO commande(id_commande, date_commande, prix_commande, id_client) VALUES (:id_commande, :date_commande, :prix_commande, :id_client)";
            $res = $this->_db->prepare($query);
            $res->bindValue(':id_commande', $id_commande);
            $res->bindValue(':date_commande', $date_commande);
            $res->bindValue(':prix_commande', $prix_commande);
            $res->bindValue(':id_client', $id_client);

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

    public function deleteCommande($id_commande){
        try {
            $query = "DELETE FROM commande WHERE id_commande = :id_commande";
            $res = $this->_db->prepare($query);
            $res->bindValue(':id_commande', $id_commande);
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
    public function getIDforDetailCommande()
    {
        try {
            $query = "INSERT INTO commande DEFAULT VALUES";
            $res = $this->_db->prepare($query);
            $res->execute();

            $query2 = "SELECT MAX(id_commande) AS max_id FROM commande";
            $res2 = $this->_db->prepare($query2);
            $res2->execute();
            $data = $res2->fetch();

            if (!empty($data['max_id'])) {
                return $data['max_id'];
            } else {
                return null;
            }
        } catch (PDOException $e) {
            echo "échec : " . $e->getMessage();
        }
    }

    public function getTotalCommande($id_commande){

        try{
            $query = "SELECT SUM(tot_row) FROM commande_full WHERE id_commande = :idcommande";
            $res = $this->_db->prepare($query);
            $res->bindValue(':idcommande', $id_commande);
            $res->execute();
            $data = $res->fetch();
            $data = $data['sum'];
            if(!empty($data)){
                return $data;
            }
            else{
                return null;
            }
        }catch (PDOException $f){
            print "échec : ".$f->getMessage();
        }

    }

    public function addTotalDate($id_commande, $prix_commande, $date_commande)
    {
        try {
            $formattedDate = date("Y-m-d", strtotime($date_commande));
            $query = "UPDATE commande SET date_commande = :date_commande, prix_commande = :prix_commande WHERE id_commande = :id_commande";
            $res = $this->_db->prepare($query);
            $res->bindValue(':id_commande', $id_commande);
            $res->bindValue(':prix_commande', $prix_commande);
            $res->bindValue(':date_commande', $formattedDate);

            $res->execute();

            return $res->rowCount() > 0;
        } catch (PDOException $e) {
            echo "échec : " . $e->getMessage();
        }
    }

    public function addIdClientToOrder($id_commande,$id_client){
        //add the id_client to the order
        try{
            $query = "UPDATE commande SET id_client = :id_client WHERE id_commande = :id_commande";
            $res = $this->_db->prepare($query);
            $res->bindValue(':id_commande', $id_commande);
            $res->bindValue(':id_client', $id_client);
            $res->execute();

            return $res->rowCount() > 0;

        }catch (PDOException $e){
            echo "échec : ".$e->getMessage();
        }
    }
}