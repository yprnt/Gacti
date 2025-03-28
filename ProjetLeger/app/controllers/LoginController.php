<?php
namespace controllers;
session_start();
require_once '../models/User.php';
class LoginController
{
    public function login() {
        if (isset($_POST['username']) && isset($_POST['password'])) {
            $user = $_POST['username'];
            $password = $_POST['password'];

            $userModel = new \models\User();
            $user = $userModel->connection($user, $password);

            if ($user) {
                $_SESSION['user'] = $user[0]['USER'];
                $_SESSION['profil'] = $user[0]['TYPEPROFIL'];
                $_SESSION['dateNaissance'] = $user[0]['YEARNAISCOMPTE'];

                // Gestion des accès en fonction du type de profil
                if ($user[0]['TYPEPROFIL'] == 'va') {
                    $this->vacancier($user);
                } elseif ($user[0]['TYPEPROFIL'] == 'en') {
                    header("Location: ../views/dashboard_encadrant.php");
                } elseif ($user[0]['USER'] == 'admin') {
                   header("Location: ../views/dashboard_admin.php");
                } else {
                    $this->showError("Type de profil non reconnu.");
                }
            } else {
                $this->showError("Login ou mot de passe incorrect.");
            }
        } else {
            $this->showError("Veuillez remplir tous les champs.");
        }
    }

    private function vacancier($user) {
        $today = date('Y-m-d');
        if ($today >= $user[0]['DATEDEBSEJOUR'] && $today <= $user[0]['DATEFINSEJOUR']) {
            $_SESSION['is_vacancier'] = true;
            header("Location: ../views/dashboard_vacancier.php");
        } else {
            $this->showError("Votre séjour ne correspond pas à la date actuelle.");
            header("Location: ../views/error.php");
        }
    }

    private function showError($message) {
        $_SESSION['error'] = $message;
        header("Location: ../views/error.php");
    }
}

$controller = new LoginController();
$controller->login();
