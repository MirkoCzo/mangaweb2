<?php


class Hydrate
{
    private $_attributs = array();

    public function __construct(array $data)
    {
        $this->hydrate($data);
    }

    public function hydrate($data)
    {
        foreach ($data as $champ => $valeur) {
            $this->$champ = $valeur;

        }
    }

    public function __set($champ, $valeur)
    {
        $this->_attributs[$champ] = $valeur;
    }

    public function __get($champ)
    {
        if (isset($this->_attributs[$champ])) {
            return $this->_attributs[$champ];
        }
    }

}