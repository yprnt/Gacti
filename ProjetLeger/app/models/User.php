<?php
namespace models;
include_once 'Database.php';
class User
{
    public static function connection($login, $password) {
        /**
         * Demande les informations d'un utilisateur à la base de données
         * @var Database $db
         * @var PDO $connection
         * @var string $query
         * @var PDOStatement $stmt
         * @return array
         */
        $db = new Database();
        $connection = $db->getConnection();
        $query = "SELECT USER, TYPEPROFIL, DATEDEBSEJOUR, DATEFINSEJOUR, YEAR(DATENAISCOMPTE) AS YEARNAISCOMPTE FROM COMPTE WHERE USER = :login AND MDP = :password";
        $stmt = $connection->prepare($query);
        $stmt->bindParam(':login', $login);
        $stmt->bindParam(':password', $password);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getUsers() {
        /**
         * Demande les informations de tous les utilisateurs à la base de données
         * @var Database $db
         * @var PDO $connection
         * @return array
         */
        $db = new Database();
        $connection = $db->getConnection();
        $query = "SELECT USER, MDP, ADRMAILCOMPTE, TYPEPROFIL FROM COMPTE";
        $stmt = $connection->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getPrenomNom($user) {
        /**
         * Demande le prénom et le nom d'un utilisateur à la base de données
         * @var Database $db
         * @var PDO $connection
         * @var string $query
         * @var PDOStatement $stmt
         * @return array
         */
        $db = new Database();
        $connection = $db->getConnection();
        $query = "SELECT PRENOMCOMPTE, NOMCOMPTE FROM COMPTE WHERE USER = :user";
        $stmt = $connection->prepare($query);
        $stmt->bindParam(':user', $user);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}