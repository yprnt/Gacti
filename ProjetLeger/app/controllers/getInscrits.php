<?php
session_start();
if (!isset($_SESSION['user']) || ($_SESSION['profil'] !== 'en' && $_SESSION['user'] !== 'admin')) {
    echo json_encode(['success' => false, 'message' => 'Accès non autorisé']);
    exit();
}

include_once '../controllers/InscriptionController.php';
/**
 * Récupérer les inscrits à une activité via AJAX et retourner du JSON.
 */

$inscriptionController = new controllers\InscriptionController();

$data = json_decode(file_get_contents('php://input'), true); // Récupérer les données envoyées grâce au POST + décode
$activityId = $data['activityId'];
$dateAct = $data['dateAct'];

if (empty($activityId) || empty($dateAct)) {
    echo json_encode(['success' => false, 'message' => 'Paramètres manquants']);
    exit();
}

$inscrits = $inscriptionController->getInscrits($activityId, $dateAct);

if ($inscrits !== false) {
    echo json_encode(['success' => true, 'inscrits' => $inscrits]);
} else {
    echo json_encode(['success' => false, 'message' => 'Erreur lors de la récupération des inscrits']);
}