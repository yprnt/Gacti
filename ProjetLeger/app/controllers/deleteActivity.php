<?php
session_start();
if (!isset($_SESSION['user']) ||
    ($_SESSION['profil'] !== 'en' && $_SESSION['user'] !== 'admin')) {
    echo json_encode(['success' => false, 'message' => 'Utilisateur non authentifié.']);
    exit();
}
require_once '../models/Activity.php';

/**
 * Supprimer une activité via une requête AJAX
 */

$data = json_decode(file_get_contents("php://input"), true); //Récupère les données envoyées via AJAX et décode.
$activityId = $data['activityId'];
$dateAct = $data['dateAct'];

$controller = new \models\Activity();
try {
    $controller->deleteActivity($activityId, $dateAct);
    echo json_encode(['success' => true]);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Erreur lors de la suppression de l\'activité.']);
}
exit();
