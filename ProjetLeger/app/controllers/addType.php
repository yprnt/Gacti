<?php
session_start();
if (!isset($_SESSION['user']) || ($_SESSION['profil'] !== 'en' && $_SESSION['profil'] !== 'admin')) {
    header('Location: ../../index.php');
    exit();
}
use controllers\AnimationController;
include_once 'AnimationController.php';

/**
 * Ajouter un type d'animation via AJAX et retourne du JSON.
 */


header('Content-Type: application/json');
$data = json_decode(file_get_contents("php://input"), true); // Récupérer les données envoyées grâce au POST + décode
$codeType = $data['codeType'];
$nomType = $data['nomType'];

if (!$codeType || !$nomType) {
    echo json_encode(['success' => false, 'message' => 'Tous les champs sont obligatoires.']);
    exit();
}

$controller = new AnimationController();
$exists = $controller->verifCodeType($codeType);

if ($exists) {
    echo json_encode(['success' => false, 'message' => 'Le Code Type existe déjà.']);
    exit();
}

try {
    $controller->addType($codeType, $nomType);
    echo json_encode(['success' => true, 'codeType' => $codeType, 'nomType' => $nomType]);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Erreur lors de l\'ajout du type d\'animation.']);
}