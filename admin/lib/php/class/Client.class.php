<?php


class Client extends Hydrate
{
    private $_db;
    private $data = array();
    private $result;

    public function __construct($cnx)
    {
        $this->_db = $cnx;
        var_dump($cnx);
    }

    public function isClient($mail, $pwd)
    {
        try {
            $query = "SELECT * FROM client WHERE LOWER(email_client) = LOWER(:mail) AND password = :pwd";
            $res = $this->_db->prepare($query);
            $res->bindValue(':mail', strtolower($mail)); // Convertir également l'e-mail en minuscules
            $res->bindValue(':pwd', $pwd);
            $res->execute();
            $data = $res->fetch();
            if (!empty($data)) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            print "échec : " . $e->getMessage();
        }
    }

    public function addClient($nom_client, $pass, $email_cli, $id_ville){
        try {
            $query = "INSERT INTO client(nom_client, password, email_client, id_ville) VALUES (:nom_client, :pass, :email_cli, :id_ville)";
            $res = $this->_db->prepare($query);
            $res->bindValue(':nom_client', $nom_client);
            $res->bindValue(':pass', $pass);
            $res->bindValue(':email_cli', $email_cli);
            $res->bindValue(':id_ville', $id_ville, PDO::PARAM_INT);
            $res->execute();
            $check = $this->_db->lastInsertId();
            return $check;
        } catch (PDOException $e) {
            print "Erreur lors de l'ajout client : " . $e->getMessage();
        }
    }

    public function getClientByMail($mail){
        try{
            $query = "SELECT * FROM client WHERE LOWER(email_client) = LOWER(:mail)";
            $res = $this->_db->prepare($query);
            $res->bindValue(':mail', strtolower($mail));
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

    public function getNameClientById($id)
    {
        try {
            $query = "SELECT nom_client from client where id_client = :id";
            $res = $this->_db->prepare($query);
            $res->bindValue(':id', $id);
            $res->execute();
            $data = $res->fetch();
            if (!empty($data)) {
                return $data;
            } else {
                return null;
            }
        } catch (PDOException $e) {
            print "échec : " . $e->getMessage();
        }
    }

}