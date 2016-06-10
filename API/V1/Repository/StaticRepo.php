<?php

namespace API\V1\Repository;

class StaticRepo
{

    //contiens l'instance de la Connexion PDO
    private static $connexion;

    //contiens les informations de connexion a la BDD
    private static $config;

    /**
     * @return \PDO instance de la connexion a la BDD
     */
    public static function getConnexion()
    {
        if (static::$config == null) {
            throw new \Exception('Aucune configuration n\'a été précisé');
        }
        if (static::$connexion == null) {
            static::$connexion = new \PDO('mysql:host=' . static::$config['dbHost'] . ';dbname=' . static::$config['dbName'] . ';charset=utf8', static::$config['dbUser'], static::$config['dbPass']);
            static::$connexion->setAttribute(\PDO::ATTR_EMULATE_PREPARES, true);
        }
        return static::$connexion;
    }

    /**
     * @return bool test de la Connexion
     */
    public static function testConnexion()
    {
        return static::getConnexion() instanceof \PDO;
    }

    /** Set all the credentials for future uses
     * @param $config
     */
    public static function setConfig($config)
    {
        static::$config = $config;
    }
}