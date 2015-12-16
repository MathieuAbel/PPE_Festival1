<?php

namespace modele;
use \PDO;
use \PDOException;

define('DSN', 'mysql:host=localhost;dbname=mabel_festival');
define('USER', 'mabel_festival');
define('MDP', 'secret');

class Connexion {
    private static $pdo = null;

    /**
     * Crée un objet de type PDO et ouvre la connexion 
     * @return un objet de type PDO pour accéder à la base de données
     */
    static function connecter() {
        /* Connexion à une base via PDO */
        try {
            self::$pdo = new PDO(DSN, USER, MDP);
            self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            self::$pdo->query("SET NAMES utf8");
        } catch (PDOException $e) {
            echo 'Connexion échouée : ' . $e->getMessage();
        }
        return self::$pdo;
    }

    static function deconnecter() {
        self::$pdo= null;
    }
    static function getPdo() {
        return self::$pdo;
    }
}
