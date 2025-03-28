<?php

namespace models;
include_once 'Database.php';
class Inscription
{
    public function setInscription($user, $codeAnim, $dateAct) {
        /**
         * Ajoute une inscription via une requete SQL
         * @arg char $user
         * @arg char $codeAnim
         * @arg date $dateAct
         * @var Database $db
         * @var PDO $connection
         * @var PDOStatement $stmt
         * @return bool
         */

        $db = new Database();
        $connection = $db->getConnection();
        $query = "INSERT INTO INSCRIPTION (USER, CODEANIM, DATEACT, DATEINSCRIP) VALUES (:user_id, :codeAnim, :dateAct, CURRENT_DATE())";
        $stmt = $connection->prepare($query);
        $stmt->bindParam(':user_id', $user);
        $stmt->bindParam(':codeAnim', $codeAnim);
        $stmt->bindParam(':dateAct', $dateAct);
        return $stmt->execute();

    }

    public function deleteInscription($user, $codeAnim, $dateAct) {
        /**
         * Supprime une inscription via une requete SQL
         * @arg char $user_id
         * @arg char $codeAnim
         * @arg date $dateAct
         * @var Database $db
         * @var PDO $connection
         * @var PDOStatement $stmt
         * @return bool
         */

        $db = new Database();
        $connection = $db->getConnection();
        $query = "UPDATE INSCRIPTION SET DATEANNULE = current_date() WHERE USER = :user_id AND CODEANIM = :codeAnim AND DATEACT = :dateAct";
        $stmt = $connection->prepare($query);
        $stmt->bindParam(':user_id', $user);
        $stmt->bindParam(':codeAnim', $codeAnim);
        $stmt->bindParam(':dateAct', $dateAct);
        return $stmt->execute();
    }

    public function getInscriptionById($user_id) {
        /**
         * Demande toutes les inscriptions d'un utilisateur
         * @arg char $id
         * @var Database $db
         * @var PDO $connection
         * @var PDOStatement $stmt
         * @return array
         */

        $db = new Database();
        $connection = $db->getConnection();
        $query = "SELECT an.NOMANIM, an.DESCRIPTANIM, an.DUREEANIM, an.LIMITEAGE, an.DIFFICULTEANIM, an.COMMENTANIM, 
                ac.DATEACT, ac.NOMRESP, ac.PRENOMRESP, i.CODEANIM, i.DATEINSCRIP, ac.CODEETATACT, e.NOMETATACT 
              FROM ANIMATION an 
              INNER JOIN ACTIVITE ac ON ac.CODEANIM = an.CODEANIM
              INNER JOIN INSCRIPTION i ON i.CODEANIM = an.CODEANIM AND i.DATEACT = ac.DATEACT
              INNER JOIN ETAT_ACT e ON e.CODEETATACT = ac.CODEETATACT
              WHERE i.USER = :id AND i.DATEANNULE IS NULL";
        $stmt = $connection->prepare($query);
        $stmt->bindParam(':id', $user_id);
        $stmt->execute();
        return $stmt->fetchAll();

    }

    public function getCountInscription($codeAnim, $dateAct) {
        /**
         * Compte le nombre d'inscrits à une activité
         * @arg char $codeAnim
         * @arg date $dateAct
         * @var Database $db
         * @var PDO $connection
         * @var PDOStatement $stmt
         * @return array
         */

        $db = new Database();
        $connection = $db->getConnection();
        $query = "SELECT COUNT(USER) as nb_inscrit FROM INSCRIPTION WHERE CODEANIM = :codeAnim AND DATEACT = :dateAct AND DATEANNULE IS NULL";
        $stmt = $connection->prepare($query);
        $stmt->bindParam(':codeAnim', $codeAnim);
        $stmt->bindParam(':dateAct', $dateAct);
        $stmt->execute();
        return $stmt->fetch()['nb_inscrit'];
    }

    public function getInscrits($activityId, $dateAct) {
        /**
         * Demande les inscrits pour une activité
         * @arg int $activityId
         * @arg date $dateAct
         * @var Database $db
         * @var PDO $connection
         * @var PDOStatement $stmt
         * @return array
         */

        $db = new Database();
        $connection = $db->getConnection();
        $query = "SELECT c.PRENOMCOMPTE, c.NOMCOMPTE, c.ADRMAILCOMPTE FROM INSCRIPTION i JOIN COMPTE c ON i.USER = c.USER WHERE i.CODEANIM = :activityId AND i.DATEACT = :dateAct AND i.DATEANNULE IS NULL";
        $stmt = $connection->prepare($query);
        $stmt->bindParam(':activityId', $activityId);
        $stmt->bindParam(':dateAct', $dateAct);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getMaxInscription($codeAnim) {
        /**
         * Demande le nombre maximum d'inscriptions pour une activité
         * @arg char $codeAnim
         * @arg date $dateAct
         * @var Database $db
         * @var PDO $connection
         * @var PDOStatement $stmt
         * @return array
         */

        $db = new Database();
        $connection = $db->getConnection();
        $query = "SELECT NBREPLACEANIM FROM ANIMATION WHERE CODEANIM = :codeAnim";
        $stmt = $connection->prepare($query);
        $stmt->bindParam(':codeAnim', $codeAnim);
        $stmt->execute();
        return $stmt->fetch()['NBREPLACEANIM'];
    }

}