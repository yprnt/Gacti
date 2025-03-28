<?php
namespace controllers;
include_once(dirname(__DIR__, 2) . '/app/models/Animation.php');
include_once(dirname(__DIR__, 2) . '/app/models/Activity.php');
use models\Animation;

class AnimationController {

    public function getAnimation() {
        /**
         * Demande toutes les animations
         * @var Animation $animationModel
         * @return array
         */
        $animationModel = new Animation();
        return $animationModel->getAnimations();
    }

    public function getAllTypes() {
        /**
         * Demande tous les types
         * @var Animation $animationModel
         * @return array
         */
        $animationModel = new Animation();
        return $animationModel->getAllTypes();
    }

    public function addAnimation($nomAnim, $typeAnim, $dureeAnim, $limiteAge, $nbrePlaceAnim, $prixAnim, $descriptionAnim, $commentaireAnim, $difficulteAnim) {
        /**
         * Ajoute une animation
         * @var Animation $animationModel
         * @return bool
         */
        $animationModel = new Animation();
        $animations = $animationModel->getAnimations();
        foreach ($animations as $animation) {
            if ($animation['NOMANIM'] == $nomAnim) {
                return false;
            }
        }
        $codeAnim = "ANIM00" . $animationModel->countAnimation() + 1;
        return $animationModel->addAnimation($codeAnim, $nomAnim, $typeAnim, $dureeAnim, $limiteAge, $nbrePlaceAnim, $prixAnim, $descriptionAnim, $commentaireAnim, $difficulteAnim);
    }

    public function verifCodeType($codeType) {
        /**
         * Demande tous les codes de type
         * @var Animation $animationModel
         * @return array
         */
        $animationModel = new Animation();
        return $animationModel->verifCodeType($codeType);
    }

    public function addType($codeType, $nomType) {
        /**
         * Ajoute un type
         * @var Animation $animationModel
         * @return bool
         */
        $animationModel = new Animation();
        return $animationModel->addType($codeType, $nomType);
    }

public function getAnimationById($codeAnim) {
        /**
         * Demande une animation par son code
         * @var Animation $animationModel
         * @return array
         */
        $animationModel = new Animation();
        return $animationModel->getAnimationById($codeAnim);
    }

    public function updateAnimation($codeAnim, $nomAnim, $typeAnim, $dureeAnim, $limiteAge, $nbrePlaceAnim, $prixAnim, $descriptionAnim, $commentaireAnim, $difficulteAnim) {
        /**
         * Met à jour une animation
         * @var Animation $animationModel
         * @return bool
         */

        $animationModel = new Animation();
        $animations = $animationModel->getAnimations();
        foreach ($animations as $animation) {
            if ($animation['NOMANIM'] == $nomAnim && $animation['CODEANIM'] != $codeAnim) {
                return false;
            }
        }
        return $animationModel->updateAnimation($codeAnim, $nomAnim, $typeAnim, $dureeAnim, $limiteAge, $nbrePlaceAnim, $prixAnim, $descriptionAnim, $commentaireAnim, $difficulteAnim);
    }

    public function getLimitAgeAnimation($codeAnim) {
        /**
         * Demande la limite d'âge pour une animation
         * @var Animation $animationModel
         * @return int
         */

        $animationModel = new Animation();
        return $animationModel->getLimitAgeAnimation($codeAnim);
    }
}
