<?php
namespace controllers;
use models\Inscription;

include_once '../models/Inscription.php';
class InscriptionController
{
    public function getInscriptionById($id) {
        /**
         * Demande toutes les inscriptions d'un utilisateur
         * @arg int $id
         * @var Inscription $inscriptionModel
         * @return array
         */
        $inscriptionModel = new \models\Inscription();
        return $inscriptionModel->getInscriptionById($id);
    }

    public function getCountInscription($codeAnim, $dateAct) {
        /**
         * Demande le nombre d'inscriptions pour une activité
         * @arg strint $codeAnim
         * @arg date $dateAct
         * @var Inscription $inscriptionModel
         * @return array
         */

        $inscriptionModel = new \models\Inscription();
        return $inscriptionModel->getCountInscription($codeAnim, $dateAct);
    }

    public function getInscrits($activityId, $dateAct) {
        /**
         * Demande les inscrits pour une activité
         * @arg int $activityId
         * @arg date $dateAct
         * @var Inscription $inscriptionModel
         * @return array
         */

        $inscriptionModel = new \models\Inscription();
        return $inscriptionModel->getInscrits($activityId, $dateAct);
    }

    public function getMaxInscription($codeAnim) {
        /**
         * Demande le nombre maximum d'inscriptions pour une activité
         * @arg string $codeAnim
         * @arg date $dateAct
         * @var Inscription $inscriptionModel
         * @return array
         */

        $inscriptionModel = new \models\Inscription();
        return $inscriptionModel->getMaxInscription($codeAnim);
    }

    public function setInscription($user, $codeAnim, $dateAct) {
        /**
         * Ajoute une inscription
         * @arg int $user
         * @arg string $codeAnim
         * @arg date $dateAct
         * @var Inscription $inscriptionModel
         * @var AnimationController $animationController
         * @return bool
         */

        if($this->getCountInscription($codeAnim, $dateAct) >= $this->getMaxInscription($codeAnim)) {
            return false;
        }

        $animationController = new AnimationController();
        $limiteage = $animationController->getLimitAgeAnimation($codeAnim);

        if((date('Y') - $_SESSION['dateNaissance']) < $limiteage) {
            return false;
        }

        $inscriptionModel = new \models\Inscription();
        return $inscriptionModel->setInscription($user, $codeAnim, $dateAct);
    }

    public function deleteInscription($user, $activityId, $dateAct) {
        /**
         * Supprime une inscription
         * @arg int $user
         * @arg int $activityId
         * @arg date $dateAct
         * @var Inscription $inscriptionModel
         * @return bool
         */

        $inscriptionModel = new \models\Inscription();
        return $inscriptionModel->deleteInscription($user, $activityId, $dateAct);
    }

}