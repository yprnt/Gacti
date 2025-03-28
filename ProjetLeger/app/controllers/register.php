<?php
session_start();
if (!isset($_SESSION['user'])) {
    echo json_encode(['success' => false, 'message' => 'Utilisateur non authentifié.']);
    exit();
}

/**
 * Inscription à une activité via une requête AJAX
 */
require_once '../controllers/InscriptionController.php';
require_once '../controllers/AnimationController.php';

$data = json_decode(file_get_contents("php://input"), true); //Récupère les données envoyées via AJAX et décode.
$activityId = $data['activityId'];
$dateAct = $data['dateAct'];
$user = $_SESSION['user'];

$inscriptionController = new \controllers\InscriptionController();
try {
    if($inscriptionController->setInscription($user, $activityId, $dateAct)) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'L\'animation n\'a plus de place disponible ou vous n\'avez pas l\'age pour accéder à celle-ci.']);
    }
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Erreur lors de l\'inscription.']);
}
exit();
