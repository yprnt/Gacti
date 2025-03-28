<?php
session_start();
if (!isset($_SESSION['user'])) {
    echo json_encode(['success' => false, 'message' => 'Utilisateur non authentifié.']);
    exit();
}

/**
 * Désinscription à une activité via une requête AJAX
 */
require_once '../controllers/InscriptionController.php';

$data = json_decode(file_get_contents("php://input"), true); //Récupère les données envoyées via AJAX et décode.
$activityId = $data['activityId'];
$dateAct = $data['dateAct'];
$user = $_SESSION['user'];

$inscriptionController = new \controllers\InscriptionController();
try {
    $inscriptionController->deleteInscription($user, $activityId, $dateAct);
    echo json_encode(['success' => true]);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Erreur lors de la désinscription.']);
}
exit();