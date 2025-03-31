<?php
session_start();
include_once 'app/controllers/AnimationController.php';
include_once 'app/controllers/ActivityController.php';
$anim = new controllers\AnimationController();
$act = new controllers\ActivityController();
$allAnimations = $anim->getAnimation();
$allActivities = $act->getActivity();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Activités - GACTI</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/styles.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
</head>
<body>
<nav class="navbar">
    <div class="container navbar-container">
        <h1 class="navbar-brand">VVA - Gestion des Activités</h1>

        <div class="navbar-links">
            <?php if ((isset($_SESSION['is_vacancier']) && $_SESSION['is_vacancier'] === true) ||
                (isset($_SESSION['profil']) && $_SESSION['profil'] === 'en') ||
                (isset($_SESSION['user']) && $_SESSION['user'] === 'admin')): ?>
                <a href="app/views/dashboard_vacancier.php" class="nav-link primary">
                    <i class="fas fa-home"></i> Tableau de bord
                </a>
            <?php endif; ?>

            <?php if ((isset($_SESSION['profil']) && $_SESSION['profil'] === 'en') ||
                (isset($_SESSION['user']) && $_SESSION['user'] === 'admin')): ?>
                <a href="app/views/dashboard_encadrant.php" class="nav-link primary">
                    <i class="fas fa-users"></i> Accès Encadrant
                </a>
            <?php endif; ?>

            <?php if (isset($_SESSION['user']) && $_SESSION['user'] === 'admin'): ?>
                <a href="app/views/dashboard_admin.php" class="nav-link primary">
                    <i class="fas fa-cog"></i> Accès Admin
                </a>
            <?php endif; ?>

            <?php if (isset($_SESSION['user'])): ?>
                <a href="app/views/logout.php" class="nav-link danger">
                    <i class="fas fa-sign-out-alt"></i> Se déconnecter
                </a>
            <?php else: ?>
                <a href="app/views/login.php" class="nav-link primary">
                    <i class="fas fa-sign-in-alt"></i> Se connecter
                </a>
            <?php endif; ?>
        </div>
    </div>
</nav>

<div class="main-content">
    <div class="container">
        <div class="filter-container fade-in">
            <label for="animationFilter" class="filter-label">
                <i class="fas fa-filter"></i> Filtrer par animation
            </label>
            <select id="animationFilter" name="animation" class="filter-select" onchange="filterActivities()">
                <option value="all">Toutes les animations</option>
                <?php foreach ($allAnimations as $animation): ?>
                    <option value="<?= $animation['CODEANIM'] ?>"><?= $animation['NOMANIM'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div id="activity-list" class="activity-grid">
            <?php if(empty($allActivities)): ?>
                <div class="empty-state">
                    <i class="fas fa-calendar-times fa-3x" style="color: var(--gray);"></i>
                    <p class="mt-3">Aucune activité n'est disponible pour le moment.</p>
                </div>
            <?php else: ?>
                <?php foreach ($allActivities as $activity): ?>
                    <div class="activity-card fade-in" data-animation="<?= $activity['CODEANIM'] ?>">
                        <div class="activity-content">
                            <h3 class="activity-title"><?= $activity['NOMANIM'] ?></h3>
                            <p class="activity-description"><?= $activity['DESCRIPTANIM'] ?></p>

                            <div class="activity-meta">
                                <div class="activity-meta-item">
                                    <i class="fas fa-calendar activity-meta-icon"></i>
                                    <?php
                                    $dateAct = new DateTime($activity['DATEACT']);
                                    echo $dateAct->format('d/m/Y');
                                    ?>
                                </div>
                                <div class="activity-meta-item">
                                    <span class="activity-price"><?= $activity['PRIXACT'] ?> €</span>
                                </div>
                            </div>

                            <button class="btn btn-primary" onclick="handleCardClick()">
                                <i class="fas fa-info-circle"></i> En savoir plus
                            </button>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>

<footer class="footer">
    <div class="container footer-content">
        &copy; 2025 Association VVA - Tous droits réservés.
    </div>
</footer>

<script>
    function filterActivities() {
        const filter = document.getElementById('animationFilter').value;
        const activities = document.querySelectorAll('.activity-card');

        activities.forEach(activity => {
            if (filter === 'all' || activity.getAttribute('data-animation') === filter) {
                activity.style.display = 'block';
            } else {
                activity.style.display = 'none';
            }
        });
    }

    function handleCardClick() {
        const isUserConnected = <?= isset($_SESSION['user']) ? 'true' : 'false' ?>;

        if (!isUserConnected) {
            Swal.fire({
                title: 'Connexion requise',
                text: 'Vous devez être connecté pour accéder à cette activité.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Se connecter',
                cancelButtonText: 'Annuler',
                customClass: {
                    popup: 'animate__animated animate__fadeIn animate__faster'
                },
                hideClass: {
                    popup: 'animate__animated animate__fadeOut animate__faster'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'app/views/login.php';
                }
            });
        } else {
            window.location.href = 'app/views/dashboard_vacancier.php';
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        const cards = document.querySelectorAll('.activity-card');
        cards.forEach((card, index) => {
            setTimeout(() => {
                card.classList.add('fade-in');
            }, 100 * index);
        });
    });
</script>
</body>
</html>