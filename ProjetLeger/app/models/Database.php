<?php
namespace models;

class Database
{
    private $host = "localhost";
    private $dbname = "GACTI";
    private $user = "GactiUser";
    private $password = "GactiPassword";

    public function getConnection() {
        /**
         * Connexion à la base de données
         * @return \PDO
         */
        try {
            return new \PDO("mysql:host=$this->host;dbname=$this->dbname", $this->user, $this->password);
        } catch (\PDOException $e) {
            echo 'Connection failed: ' . $e->getMessage();
        }
    }
}