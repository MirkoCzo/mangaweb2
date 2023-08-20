<?php

class AdminDB extends admin
{
    private $_db;
    private $_array = array();

    public function __construct($cnx)
    {
        $this->_db = $cnx;
        var_dump($cnx);

    }

    public function isAdmin($login, $password)
    {
        try {
            $query = "select verifier_connexion(:login,:password) as retour";
            $res = $this->_db->prepare($query);
            $res->bindValue(':login', $login);
            $res->bindValue(':password', $password);
            $res->execute();
            return $res->fetchColumn(0);

        } catch (PDOException $e) {
            print "<br>Echec : " . $e->getMessage();
        }
    }
}