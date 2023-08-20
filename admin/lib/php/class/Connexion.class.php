<?php


class Connexion
{
    private static $_instance = null;

    public static function getInstance($dsn, $user, $pass)
    {
        if (!self::$_instance) {

            try {
                self::$_instance = new PDO ($dsn, $user, $pass);
            } catch (PDOException $e) {
                print 'Echec : ' . $e->getMessage();
            }
        }
        return self::$_instance;
    }
}




