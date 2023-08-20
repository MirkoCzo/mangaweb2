<?php


class Ville extends Hydrate
{
    private $_db;
    private $data = array();
    private $result;

    public function __construct($cnx)
    {
        $this->_db = $cnx;
    }

    public function getVilleID($nom)
    {
        try {
            $query = "SELECT id_ville from ville where UPPER(nom_ville)=UPPER(:nom)";
            $result = $this->_db->prepare($query);
            $result->bindValue(':nom', $nom);
            $result->execute();
            $data = $result->fetch(PDO::FETCH_OBJ);
            return $data->id_ville;
        } catch (PDOException $e) {
            print "Erreur lors de la récupération de l'ID de la ville : " . $e->getMessage();

        }
    }

    public function addVille($nom, $pays)
    {
        try {
            $query = "SELECT addville(:nomville,:nompays) as retour";
            $result = $this->_db->prepare($query);
            $result->bindValue(":nomville", $nom);
            $result->bindValue(":nompays", $pays);
            $result->execute();

            $retour = $this->_db->lastInsertId();
            return $retour;
        } catch (PDOException $e) {
            print "Erreur lors de l'ajout de la ville : " . $e->getMessage();
        }
    }
}