<?php

namespace controllers;
include_once(dirname(__DIR__, 2) . '/app/models/Activity.php');
include_once(dirname(__DIR__, 2) . '/app/models/User.php');

use DateTime;
use models\Activity;
use models\User;

class ActivityController
{
    public function getActivity() {
        /**
         * Demande toutes les activités ou seulement celles d'une animation en excluant les activités passées
         * @var Activity $activiteModel
         * @return array
         */
        $activiteModel = new Activity();
        $activities = $activiteModel->getActivity();
        $currentDate = new DateTime();
        $filteredActivities = array_filter($activities, function ($activity) use ($currentDate) {
            $activityDate = new DateTime($activity['DATEACT']);
            return $activityDate >= $currentDate;
        });

        return $filteredActivities;
    }

    public function getActivityUnRegister($id) {
        /**
         * Demande toutes les activités non inscrites par un utilisateur en excluant les activités passées
         * @var Activity $activiteModel
         * @return array
         */
        $activiteModel = new Activity();
        $activities = $activiteModel->getActivityUnRegister($id);

        $currentDate = new \DateTime();
        $filteredActivities = array_filter($activities, function ($activity) use ($currentDate) {
            $activityDate = new \DateTime($activity['DATEACT']);
            return $activityDate >= $currentDate;
        });

        return $filteredActivities;

    }

    public function getAllStatuts() {
        /**
         * Demande tous les statuts
         * @var Activity $activiteModel
         * @return array
         */
        $activiteModel = new Activity();
        return $activiteModel->getAllStatuts();
    }

    public function addActivity($animation, $statutAct, $dateAct, $heureArrivee, $heureDebut, $heureFin, $prixAct) {
        /**
         * Ajoute une activité
         * @var Activity $activiteModel
         * @return bool
         */

        $activiteModel = new Activity();
        $currentDate = new DateTime();
        $activityDate = new \DateTime($dateAct);
        if($activityDate < $currentDate) {
            return false;
        }
        $activities = $activiteModel->getAllCodeAnimDateAct();
        foreach ($activities as $activity) {
            if ($activity['CODEANIM'] == $animation && $activity['DATEACT'] == $dateAct) {
                return false;
            }
        }
        $userModel = new User();
        $userInfo = $userModel->getPrenomNom($_SESSION['user']);
        return $activiteModel->addActivity($animation, $statutAct, $dateAct, $heureArrivee, $heureDebut, $heureFin, $prixAct, $userInfo[0]['NOMCOMPTE'], $userInfo[0]['PRENOMCOMPTE']);
    }

    public function getActivityByIdAndDate($activityId, $dateAct) {
        /**
         * Demande une activité par son id et sa date
         * @var Activity $activiteModel
         * @return array
         */
        $activiteModel = new Activity();
        return $activiteModel->getActivityByIdAndDate($activityId, $dateAct);
    }

    public function updateActivity($animation, $dateAnimation, $statutAct,$heureArrivee,$heureDebut,$heureFin,$prixAct, $codeAnim, $dateAct) {
        /**
         * Modifie une activité
         * @var Activity $activiteModel
         * @return bool
         */
        $activiteModel = new Activity();
        $currentDate = new DateTime();
        $activityDate = new \DateTime($dateAct);
        if($activityDate < $currentDate) {
            return false;
        }

        $activities = $activiteModel->getAllCodeAnimDateAct();
        foreach ($activities as $activity) {
            if ($activity['CODEANIM'] != $codeAnim || $activity['DATEACT'] != $dateAct) {
                if ($activity['CODEANIM'] == $animation && $activity['DATEACT'] == $dateAnimation &&
                    is_null($activity['DATEANNULEACT'])) {
                    return false;
                }
            }
        }
        return $activiteModel->updateActivity($animation, $dateAnimation, $statutAct,$heureArrivee,$heureDebut,$heureFin,$prixAct, $codeAnim, $dateAct);
    }
}