<?php
namespace models;
include_once 'Database.php';

class Animation
{
    public static function getAnimations() {
        /**
         * Demande toutes les animations
         * @var Database $db
         * @var \PDO $connection
         * @var \PDOStatement $stmt
         * @return array
         */
        $db = new Database();
        $connection = $db->getConnection();
        $query = "SELECT CODEANIM, NOMANIM, DESCRIPTANIM, DIFFICULTEANIM, TARIFANIM FROM ANIMATION";
        $stmt = $connection->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function addAnimation($codeAnim, $nomAnim, $typeAnim, $dureeAnim, $limiteAge, $nbrePlaceAnim, $prixAnim, $descriptionAnim, $commentaireAnim, $difficulteAnim) {
        /**
         * Ajoute une animation
         * @var Database $db
         * @var PDO $connection
         * @var PDOStatement $stmt
         * @return bool
         */
        $db = new Database();
        $connection = $db->getConnection();
        $query = "INSERT INTO ANIMATION (CODEANIM, CODETYPEANIM, NOMANIM, DATECREATIONANIM, DUREEANIM, LIMITEAGE, NBREPLACEANIM, TARIFANIM, DESCRIPTANIM, COMMENTANIM, DIFFICULTEANIM) VALUES (:codeAnim,:typeAnim, :nomAnim, current_date(), :dureeAnim, :limiteAge, :nbrePlaceAnim, :prixAnim, :descriptionAnim, :commentaireAnim, :difficulteAnim)";
        $stmt = $connection->prepare($query);
        $stmt->bindParam(':codeAnim', $codeAnim);
        $stmt->bindParam(':nomAnim', $nomAnim);
        $stmt->bindParam(':typeAnim', $typeAnim);
        $stmt->bindParam(':dureeAnim', $dureeAnim);
        $stmt->bindParam(':limiteAge', $limiteAge);
        $stmt->bindParam(':nbrePlaceAnim', $nbrePlaceAnim);
        $stmt->bindParam(':prixAnim', $prixAnim);
        $stmt->bindParam(':descriptionAnim', $descriptionAnim);
        $stmt->bindParam(':commentaireAnim', $commentaireAnim);
        $stmt->bindParam(':difficulteAnim', $difficulteAnim);
        return $stmt->execute();

    }

    public function countAnimation() {
        /**
         * Demande le nombre d'animations
         * @var Database $db
         * @var PDO $connection
         * @var PDOStatement $stmt
         * @return int
         */
        $db = new Database();
        $connection = $db->getConnection();
        $query = "SELECT COUNT(CODEANIM) FROM ANIMATION";
        $stmt = $connection->prepare($query);
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    public function getAllTypes() {
        /**
         * Demande tous les types
         * @var Database $db
         * @var PDO $connection
         * @var PDOStatement $stmt
         * @return array
         */
        $db = new Database();
        $connection = $db->getConnection();
        $query = "SELECT CODETYPEANIM, NOMTYPEANIM FROM TYPE_ANIM";
        $stmt = $connection->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function addType($codeType, $nomType) {
        /**
         * Ajoute un type
         * @var Database $db
         * @var PDO $connection
         * @var PDOStatement $stmt
         * @return bool
         */
        $db = new Database();
        $connection = $db->getConnection();
        $query = "INSERT INTO TYPE_ANIM (CODETYPEANIM, NOMTYPEANIM) VALUES (:codeType, :nomType)";
        $stmt = $connection->prepare($query);
        $stmt->bindParam(':codeType', $codeType);
        $stmt->bindParam(':nomType', $nomType);
        return $stmt->execute();
    }

    public function verifCodeType($codeType) {
        /**
         * Demande tous les codes de type
         * @var Database $db
         * @var PDO $connection
         * @var PDOStatement $stmt
         * @return bool
         */
        $db = new Database();
        $connection = $db->getConnection();
        $query = "SELECT CODETYPEANIM FROM TYPE_ANIM WHERE CODETYPEANIM = :codeType";
        $stmt = $connection->prepare($query);
        $stmt->bindParam(':codeType', $codeType);
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    public function getAnimationById($codeAnim) {
        /**
         * Demande une animation par son code
         * @var Database $db
         * @var PDO $connection
         * @var PDOStatement $stmt
         * @return array
         */
        $db = new Database();
        $connection = $db->getConnection();
        $query = "SELECT t.NOMTYPEANIM, a.CODETYPEANIM, a.NOMANIM, a.DATEVALIDITEANIM, a.DUREEANIM, a.LIMITEAGE, a.TARIFANIM, 
                        a.NBREPLACEANIM, a.DESCRIPTANIM, a.COMMENTANIM, a.DIFFICULTEANIM 
                    FROM ANIMATION a, TYPE_ANIM t 
                    WHERE CODEANIM = :codeAnim";
        $stmt = $connection->prepare($query);
        $stmt->bindParam(':codeAnim', $codeAnim);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function updateAnimation($codeAnim, $nomAnim, $typeAnim, $dureeAnim, $limiteAge, $nbrePlaceAnim, $prixAnim, $descriptionAnim, $commentaireAnim, $difficulteAnim) {
        /**
         * Met à jour une animation
         * @var Database $db
         * @var PDO $connection
         * @var PDOStatement $stmt
         * @return bool
         */
        $db = new Database();
        $connection = $db->getConnection();
        $query = "UPDATE ANIMATION 
                    SET NOMANIM = :nomAnim, CODETYPEANIM = :typeAnim, DUREEANIM = :dureeAnim, LIMITEAGE = :limiteAge, 
                    NBREPLACEANIM = :nbrePlaceAnim, TARIFANIM = :prixAnim, DESCRIPTANIM = :descriptionAnim, 
                    COMMENTANIM = :commentaireAnim, DIFFICULTEANIM = :difficulteAnim 
                    WHERE CODEANIM = :codeAnim";
        $stmt = $connection->prepare($query);
        $stmt->bindParam(':codeAnim', $codeAnim);
        $stmt->bindParam(':nomAnim', $nomAnim);
        $stmt->bindParam(':typeAnim', $typeAnim);
        $stmt->bindParam(':dureeAnim', $dureeAnim);
        $stmt->bindParam(':limiteAge', $limiteAge);
        $stmt->bindParam(':nbrePlaceAnim', $nbrePlaceAnim);
        $stmt->bindParam(':prixAnim', $prixAnim);
        $stmt->bindParam(':descriptionAnim', $descriptionAnim);
        $stmt->bindParam(':commentaireAnim', $commentaireAnim);
        $stmt->bindParam(':difficulteAnim', $difficulteAnim);
        return $stmt->execute();
    }

    public function getLimitAgeAnimation($codeAnim) {
        /**
         * Demande la limite d'âge pour une animation
         * @var Databse $db
         * @var PDO $connection
         * @var PDOStatement $stmt
         * @return int | null
         */
        $db = new Database();
        $connection = $db->getConnection();
        $query="SELECT LIMITEAGE FROM ANIMATION WHERE CODEANIM = :codeAnim";
        $stmt = $connection->prepare($query);
        $stmt->bindParam(':codeAnim', $codeAnim);
        $stmt->execute();
        $result = $stmt->fetch();
        return $result ? $result['LIMITEAGE'] : null;
    }

}