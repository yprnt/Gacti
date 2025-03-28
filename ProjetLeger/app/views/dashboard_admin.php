<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user'] !== 'admin') {
    header("Location: app/views/login.php");
    exit();
}

include_once '../models/User.php';
$model = new models\User();
$users = $model->getUsers();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../../assets/css/styles.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
<nav class="navbar">
    <div class="container navbar-container">
        <h1 class="navbar-brand">Mon Dashboard - Administrateur</h1>

        <div class="navbar-links">
            <a href="../../index.php" class="nav-link primary">
                <i class="fas fa-home"></i> Accueil
            </a>
            <a href="dashboard_vacancier.php" class="nav-link primary">
                <i class="fas fa-user"></i> Mon Dashboard
            </a>
            <a href="dashboard_encadrant.php" class="nav-link primary">
                <i class="fas fa-users"></i> Accès Encadrant
            </a>
            <a href="logout.php" class="nav-link danger">
                <i class="fas fa-sign-out-alt"></i> Se déconnecter
            </a>
        </div>
    </div>
</nav>

<div class="main-content">
    <div class="container">
        <div class="dashboard-section fade-in">
            <div class="section-header">
                <h2 class="section-title">
                    <i class="fas fa-users"></i> Liste des utilisateurs
                </h2>
            </div>

            <div class="data-table-container">
                <table class="data-table">
                    <thead>
                    <tr>
                        <th>
                            <div class="th-content">
                                <i class="fas fa-user"></i> Utilisateur
                            </div>
                        </th>
                        <th>
                            <div class="th-content">
                                <i class="fas fa-key"></i> Mot de passe
                            </div>
                        </th>
                        <th>
                            <div class="th-content">
                                <i class="fas fa-envelope"></i> Email
                            </div>
                        </th>
                        <th>
                            <div class="th-content">
                                <i class="fas fa-id-badge"></i> Type de Profil
                            </div>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($user['USER']); ?></td>
                            <td><?php echo htmlspecialchars($user['MDP']); ?></td>
                            <td><?php echo htmlspecialchars($user['ADRMAILCOMPTE'] ?? ''); ?></td>
                            <td>
                                <?php if ($user['USER'] == "admin"): ?>
                                    <span class='profile-badge admin'>Admin</span>
                                <?php else: ?>
                                    <span class="profile-badge <?php echo strtolower($user['TYPEPROFIL'] ?? 'default'); ?>">
                                        <?php echo htmlspecialchars($user['TYPEPROFIL'] ?? ''); ?>
                                    </span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<footer class="footer">
    <div class="container footer-content">
        &copy; 2024 Association VVA - Tous droits réservés.
    </div>
</footer>
</body>
</html>