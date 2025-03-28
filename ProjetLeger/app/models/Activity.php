<?php
namespace models;
include_once 'Database.php';

class Activity
{
    public static function getActivity() {
        /**
         * Demande toutes les activités à la base de données
         * @var Database $db
         * @var PDO $connection
         * @var PDOStatement $stmt
         * @return array
         */
        $db = new Database();
        $connection = $db->getConnection();
        $query = "SELECT an.NOMANIM, an.DUREEANIM, an.LIMITEAGE, an.DESCRIPTANIM, an.DIFFICULTEANIM, an.COMMENTANIM, an.NBREPLACEANIM, ac.DATEACT, ac.PRIXACT, ac.CODEANIM FROM ACTIVITE ac, ANIMATION an WHERE ac.CODEANIM = an.CODEANIM AND ac.DATEANNULEACT IS NULL";
        $stmt = $connection->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public static function getActivityByAnimation($codeAnim) {
        /**
         * Demande toutes les activités d'une animation à la base de données
         * @arg int $codeAnim
         * @var Database $db
         * @var PDO $connection
         * @var PDOStatement $stmt
         * @return array
         */
        $db = new Database();
        $connection = $db->getConnection();
        $query = "SELECT an.NOMANIM, ac.DATEACT, ac.PRIXACT, an.DESCRIPTANIM FROM ACTIVITE ac, ANIMATION an WHERE ac.CODEANIM = an.CODEANIM AND an.CODEANIM = :codeAnim AND ac.DATEANNULEACT IS NULL";
        $stmt = $connection->prepare($query);
        $stmt->bindParam(':codeAnim', $codeAnim);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public static function getActivityUnRegister($id) {
        /**
         * Demande toutes les activités non inscrites par un utilisateur à la base de données
         * @arg int $id
         * @var Database $db
         * @var PDO $connection
         * @var PDOStatement $stmt
         * @return array
         */
        $db = new Database();
        $connection = $db->getConnection();
        $query = "SELECT an.NOMANIM, an.DUREEANIM, an.LIMITEAGE, an.DESCRIPTANIM, an.DIFFICULTEANIM, an.COMMENTANIM, 
                    an.NBREPLACEANIM, ac.DATEACT, ac.PRIXACT, ac.CODEANIM, ac.CODEETATACT, e.NOMETATACT 
                FROM ACTIVITE ac
                INNER JOIN ANIMATION an ON an.CODEANIM = ac.CODEANIM 
                INNER JOIN ETAT_ACT e ON e.CODEETATACT = ac.CODEETATACT
                WHERE (ac.CODEANIM, ac.DATEACT) NOT IN 
                    (SELECT i.CODEANIM, i.DATEACT FROM INSCRIPTION i WHERE i.USER = :id AND i.DATEANNULE IS NULL) 
                AND ac.DATEANNULEACT IS NULL";
        $stmt = $connection->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetchAll();

    }

    public static function getAllStatuts() {
        /**
         * Demande tous les statuts à la base de données
         * @var Database $db
         * @var PDO $connection
         * @var PDOStatement $stmt
         * @return array
         */
        $db = new Database();
        $connection = $db->getConnection();
        $query = "SELECT CODEETATACT, NOMETATACT 
                    FROM ETAT_ACT
                    WHERE CODEETATACT != 'an'";
        $stmt = $connection->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();

    }

    public function deleteActivity($activityId, $dateAct) {
        /**
         * Supprime une activité aux yeux des membres
         * @arg int $activityId
         * @arg string $dateAct
         * @var Database $db
         * @var PDO $connection
         * @var PDOStatement $stmt
         * @return bool
         */
        $db = new Database();
        $connection = $db->getConnection();
        $query = "UPDATE ACTIVITE SET DATEANNULEACT = current_date() WHERE CODEANIM = :activityId AND DATEACT = :dateAct";
        $stmt = $connection->prepare($query);
        $stmt->bindParam(':activityId', $activityId);
        $stmt->bindParam(':dateAct', $dateAct);
        return $stmt->execute();
    }

    public function addActivity($animation, $statutAct, $dateAct, $heureArrivee, $heureDebut, $heureFin, $prixAct, $nomCompte, $prenomCompte) {
        /**
         * Ajoute une activité à la base de données
         * @arg int $animation
         * @arg int $statutAct
         * @arg date $dateAct
         * @arg date $heureArrivee
         * @arg date $heureDebut
         * @arg date $heureFin
         * @arg float $prixAct
         * @var Database $db
         * @var PDO $connection
         * @var PDOStatement $stmt
         * @return bool
         */

        $db = new Database();
        $connection = $db->getConnection();
        $query = "INSERT INTO ACTIVITE (CODEANIM, CODEETATACT, DATEACT, HRRDVACT, HRDEBUTACT, HRFINACT, PRIXACT, NOMRESP, PRENOMRESP) VALUES (:animation, :statutAct, :dateAct, :heureArrivee, :heureDebut, :heureFin, :prixAct, :nomCompte, :prenomCompte)";
        $stmt = $connection->prepare($query);
        $stmt->bindParam(':animation', $animation);
        $stmt->bindParam(':statutAct', $statutAct);
        $stmt->bindParam(':dateAct', $dateAct);
        $stmt->bindParam(':heureArrivee', $heureArrivee);
        $stmt->bindParam(':heureDebut', $heureDebut);
        $stmt->bindParam(':heureFin', $heureFin);
        $stmt->bindParam(':prixAct', $prixAct);
        $stmt->bindParam(':nomCompte', $nomCompte);
        $stmt->bindParam(':prenomCompte', $prenomCompte);
        return $stmt->execute();
    }

    public function getAllCodeAnimDateAct() {
        /**
         * Demande tous les codes d'animation et les dates d'activité à la base de données
         * @var Database $db
         * @var PDO $connection
         * @var PDOStatement $stmt
         * @return array
         */

        $db = new Database();
        $connection = $db->getConnection();
        $query = "SELECT CODEANIM, DATEACT, DATEANNULEACT FROM ACTIVITE";
        $stmt = $connection->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getActivityByIdAndDate($activityId, $dateAct) {
        /**
         * Demande une activité par son id et sa date à la base de données
         * @arg int $activityId
         * @arg string $dateAct
         * @var Database $db
         * @var PDO $connection
         * @var PDOStatement $stmt
         * @return array
         */
        $db = new Database();
        $connection = $db->getConnection();
        $query = "SELECT CODEANIM, CODEETATACT, DATEACT, HRRDVACT, PRIXACT, HRDEBUTACT, HRFINACT 
                FROM ACTIVITE WHERE CODEANIM = :activityId AND DATEACT = :dateAct";
        $stmt = $connection->prepare($query);
        $stmt->bindParam(':activityId', $activityId);
        $stmt->bindParam(':dateAct', $dateAct);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function updateActivity($animation, $dateAnimation, $statutAct, $heureArrivee, $heureDebut, $heureFin, $prixAct, $codeAnim, $dateAct)
    {
        /**
         * Modifie une activité à la base de données
         * @arg int $animation
         * @arg int $statutAct
         * @arg date $dateAct
         * @arg date $heureArrivee
         * @arg date $heureDebut
         * @arg date $heureFin
         * @arg float $prixAct
         * @var Database $db
         * @var PDO $connection
         * @var PDOStatement $stmt
         * @return bool
         */

        $db = new Database();
        $connection = $db->getConnection();
        $query = "UPDATE ACTIVITE 
                SET CODEANIM = :animation, DATEACT = :dateAnimation, CODEETATACT = :statutAct, HRRDVACT = :heureArrivee, HRDEBUTACT = :heureDebut, HRFINACT = :heureFin, 
                    PRIXACT = :prixAct WHERE CODEANIM = :codeAnim AND DATEACT = :dateAct";
        $stmt = $connection->prepare($query);
        $stmt->bindParam(':animation', $animation);
        $stmt->bindParam(':dateAnimation', $dateAnimation);
        $stmt->bindParam(':statutAct', $statutAct);
        $stmt->bindParam(':heureArrivee', $heureArrivee);
        $stmt->bindParam(':heureDebut', $heureDebut);
        $stmt->bindParam(':heureFin', $heureFin);
        $stmt->bindParam(':prixAct', $prixAct);
        $stmt->bindParam(':codeAnim', $codeAnim);
        $stmt->bindParam(':dateAct', $dateAct);
        return $stmt->execute();

    }

}