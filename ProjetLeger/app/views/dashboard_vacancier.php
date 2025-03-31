<?php
session_start();
if(!isset($_SESSION['user']) ||
    (!isset($_SESSION['is_vacancier']) && $_SESSION['user'] !== 'admin' && $_SESSION['profil'] !== 'en')) {
    header('Location: ../../index.php');
    exit();
}
include_once '../controllers/ActivityController.php';
include_once '../controllers/InscriptionController.php';

$act = new controllers\ActivityController();
$inscriptionController = new controllers\InscriptionController();
$currentDate = new DateTime();

// Récupérer les activités avec lesquelles l'utilisateur est inscrit et celles disponibles
$inscritActivities = $inscriptionController->getInscriptionById($_SESSION['user']);
$availableActivities = $act->getActivityUnRegister($_SESSION['user']);
$date = new DateTime();

// Permet de combiner les 2 tableaux et ainsi obtenir toutes les animations disponibles
$allAnimations = array_unique(
    array_map(function ($activity) { // Transformation de chaque activité en tableau associatif
        return ['code' => $activity['CODEANIM'], 'name' => $activity['NOMANIM']];
    }, array_merge($availableActivities, $inscritActivities)),
    SORT_REGULAR // Supprime les doublons en comparant les valeurs et les types
);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Dashboard - Vacancier</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../../assets/css/styles.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .activity-warning {
            background-color: #fff3cd;
            color: #856404;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 15px;
            border-left: 4px solid #ffeeba;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .activity-warning i {
            font-size: 1.25rem;
        }
    </style>
</head>
<body>
<nav class="navbar">
    <div class="container navbar-container">
        <h1 class="navbar-brand">Mon Dashboard - Activités</h1>

        <div class="navbar-links">
            <a href="../../index.php" class="nav-link primary">
                <i class="fas fa-home"></i> Accueil
            </a>

            <?php if ((isset($_SESSION['profil']) && $_SESSION['profil'] === 'en') || (isset($_SESSION['user']) && $_SESSION['user'] === 'admin')): ?>
                <a href="dashboard_encadrant.php" class="nav-link primary">
                    <i class="fas fa-users"></i> Accès Encadrant
                </a>
            <?php endif; ?>

            <?php if (isset($_SESSION['user']) && $_SESSION['user'] === 'admin'): ?>
                <a href="dashboard_admin.php" class="nav-link primary">
                    <i class="fas fa-cog"></i> Accès Admin
                </a>
            <?php endif; ?>

            <a href="logout.php" class="nav-link danger">
                <i class="fas fa-sign-out-alt"></i> Se déconnecter
            </a>
        </div>
    </div>
</nav>

<div class="main-content">
    <div class="container">
        <div class="filter-container fade-in">
            <label for="animationFilter" class="filter-label">
                <i class="fas fa-filter"></i> Filtrer par animation
            </label>
            <select id="animationFilter" class="filter-select" onchange="filterAnimation()">
                <option value="all">Toutes les animations</option>
                <?php foreach ($allAnimations as $animation): ?>
                    <option value="<?= $animation['code'] ?>"><?= htmlspecialchars($animation['name']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="dashboard-section fade-in">
            <div class="section-header">
                <h2 class="section-title">
                    <i class="fas fa-check-circle"></i> Activités auxquelles je suis inscrit
                </h2>
            </div>

            <div id="inscrit-activities" class="activity-grid">
                <?php if (empty($inscritActivities)): ?>
                    <div class="empty-state">
                        <i class="fas fa-calendar-times fa-3x" style="color: var(--gray);"></i>
                        <p>Vous n'êtes inscrit à aucune activité pour le moment.</p>
                    </div>
                <?php else: ?>
                    <?php foreach ($inscritActivities as $activity): ?>
                        <div id="activity-<?= $activity['CODEANIM'] ?>" class="activity-card">
                            <div class="activity-content">
                                <h3 class="activity-title"><?= $activity['NOMANIM'] ?></h3>
                                <p class="activity-description"><?= $activity['DESCRIPTANIM'] ?></p>

                                <?php if(isset($activity['CODEETATACT']) && $activity['CODEETATACT'] === 'in'): ?>
                                    <div class="activity-warning">
                                        <i class="fas fa-exclamation-triangle"></i>
                                        <span>Attention: Cette activité a une inscription incertaine. Il est probable qu'elle soit annulée pour cause météorologique ou autre.</span>
                                    </div>
                                <?php endif; ?>

                                <div class="activity-details">
                                    <div class="activity-detail">
                                        <i class="fas fa-calendar"></i>
                                        <span>
                                                <?php
                                                $dateAct = new DateTime($activity['DATEACT']);
                                                echo $dateAct->format('d/m/Y');
                                                ?>
                                            </span>
                                    </div>
                                    <div class="activity-detail">
                                        <i class="fas fa-clock"></i>
                                        <span><?= $activity['DUREEANIM'] ?> h</span>
                                    </div>
                                    <div class="activity-detail">
                                        <i class="fas fa-child"></i>
                                        <span>Limite: <?= $activity['LIMITEAGE'] ?> ans</span>
                                    </div>
                                    <div class="activity-detail">
                                        <i class="fas fa-mountain"></i>
                                        <span>Difficulté: <?= $activity['DIFFICULTEANIM'] ?></span>
                                    </div>
                                    <div class="activity-detail">
                                        <i class="fas fa-comment"></i>
                                        <span><?= $activity['COMMENTANIM'] ?></span>
                                    </div>
                                    <div class="activity-detail">
                                        <i class="fas fa-user"></i>
                                        <span><?= $activity['NOMRESP'] . " " . $activity['PRENOMRESP'] ?></span>
                                    </div>
                                    <div class="activity-detail">
                                        <i class="fas fa-calendar-check"></i>
                                        <span>Inscrit le: <?= $activity['DATEINSCRIP'] ?></span>
                                    </div>
                                </div>

                                <?php if($date > $dateAct): ?>
                                    <button class="btn btn-disabled" disabled>
                                        <i class="fas fa-ban"></i> Activité terminée
                                    </button>
                                <?php else: ?>
                                    <button class="btn btn-danger" onclick="unsubscribeActivity('<?= $activity['CODEANIM'] ?>', '<?= $activity['DATEACT'] ?>')">
                                        <i class="fas fa-times-circle"></i> Se désinscrire
                                    </button>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>

        <div class="dashboard-section fade-in">
            <div class="section-header">
                <h2 class="section-title">
                    <i class="fas fa-list"></i> Activités disponibles
                </h2>
            </div>

            <div id="available-activities" class="activity-grid">
                <?php if (empty($availableActivities)): ?>
                    <div class="empty-state">
                        <i class="fas fa-calendar-times fa-3x" style="color: var(--gray);"></i>
                        <p>Aucune activité n'est disponible pour le moment.</p>
                    </div>
                <?php else: ?>
                    <?php foreach ($availableActivities as $activity): ?>
                        <div id="activity-<?= $activity['CODEANIM'] ?>" class="activity-card">
                            <div class="activity-content">
                                <h3 class="activity-title"><?= $activity['NOMANIM'] ?></h3>
                                <p class="activity-description"><?= $activity['DESCRIPTANIM'] ?></p>

                                <?php if(isset($activity['CODEETATACT']) && $activity['CODEETATACT'] === 'in'): ?>
                                    <div class="activity-warning">
                                        <i class="fas fa-exclamation-triangle"></i>
                                        <span>Attention: Cette activité a une inscription incertaine. Il est probable qu'elle soit annulée pour cause météorologique ou autre.</span>
                                    </div>
                                <?php endif; ?>

                                <div class="activity-details">
                                    <div class="activity-detail">
                                        <i class="fas fa-calendar"></i>
                                        <span>
                                                <?php
                                                $dateAct = new DateTime($activity['DATEACT']);
                                                echo $dateAct->format('d/m/Y');
                                                ?>
                                            </span>
                                    </div>
                                    <div class="activity-detail">
                                        <i class="fas fa-clock"></i>
                                        <span><?= $activity['DUREEANIM'] ?> h</span>
                                    </div>
                                    <div class="activity-detail">
                                        <i class="fas fa-mountain"></i>
                                        <span>Difficulté: <?= $activity['DIFFICULTEANIM'] ?></span>
                                    </div>
                                    <div class="activity-detail">
                                        <i class="fas fa-child"></i>
                                        <span>Limite: <?= $activity['LIMITEAGE'] ?> ans</span>
                                    </div>
                                    <div class="activity-detail">
                                        <i class="fas fa-comment"></i>
                                        <span><?= $activity['COMMENTANIM'] ?></span>
                                    </div>
                                    <div class="activity-detail">
                                        <i class="fas fa-users"></i>
                                        <span>Places: <?= $activity['NBREPLACEANIM'] ?></span>
                                    </div>
                                    <div class="activity-detail price-tag">
                                        <i class="fas fa-tag"></i>
                                        <span><?= $activity['PRIXACT'] ?> €</span>
                                    </div>
                                </div>

                                <button class="btn btn-primary" onclick="subscribeActivity('<?= $activity['CODEANIM'] ?>', '<?= $activity['DATEACT'] ?>')">
                                    <i class="fas fa-plus-circle"></i> S'inscrire
                                </button>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<footer class="footer">
    <div class="container footer-content">
        &copy; 2025 Association VVA - Tous droits réservés.
    </div>
</footer>

<script>
    function filterAnimation() {
        const filter = document.getElementById('animationFilter');
        const selectedValue = filter.value;

        const inscritActivities = document.querySelectorAll('#inscrit-activities > div');
        const availableActivities = document.querySelectorAll('#available-activities > div');

        [inscritActivities, availableActivities].forEach(activitySection => {
            activitySection.forEach(activity => {
                if (selectedValue === 'all' || activity.id.includes(selectedValue)) {
                    activity.style.display = 'block';
                } else {
                    activity.style.display = 'none';
                }
            });
        });
    }

    function subscribeActivity(activityId, dateAct) {
        Swal.fire({
            title: 'Confirmation',
            showClass: {
                popup: 'animate__animated animate__fadeIn animate__faster'
            },
            hideClass: {
                popup: 'animate__animated animate__fadeOut animate__faster'
            },
            text: 'Souhaitez-vous vous inscrire à cette activité ?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Oui, je m\'inscris',
            cancelButtonText: 'Non'
        }).then((result) => {
            if (result.isConfirmed) {
                // Envoi de la requête AJAX
                fetch('../controllers/register.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({ activityId: activityId, dateAct: dateAct })
                }).then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire('Inscription réussie!', 'Vous êtes maintenant inscrit à cette activité.', 'success')
                            // MAJ déplace activité
                            let activityDiv = document.querySelector(`#activity-${activityId}`);
                            document.getElementById('inscrit-activities').appendChild(activityDiv);

                            activityDiv.querySelector('button').innerHTML = '<i class="fas fa-times-circle"></i> Se désinscrire';
                            activityDiv.querySelector('button').classList.remove('btn-primary');
                            activityDiv.querySelector('button').classList.add('btn-danger');
                            activityDiv.querySelector('button').setAttribute('onclick', `unsubscribeActivity('${activityId}', '${dateAct}')`);
                        } else {
                            Swal.fire('Erreur', data.message, 'error');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire('Erreur', 'Une erreur est survenue lors de l\'inscription.', 'error');
                    });
            }
        });
    }

    function unsubscribeActivity(activityId, dateAct) {
        Swal.fire({
            title: 'Confirmation',
            text: 'Souhaitez-vous vous désinscrire de cette activité ?',
            icon: 'warning',
            showClass: {
                popup: 'animate__animated animate__fadeIn animate__faster'
            },
            hideClass: {
                popup: 'animate__animated animate__fadeOut animate__faster'
            },
            showCancelButton: true,
            confirmButtonText: 'Oui, me désinscrire',
            cancelButtonText: 'Non'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch('../controllers/unregister.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({ activityId: activityId , dateAct: dateAct })
                }).then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire('Désinscription réussie!', 'Vous vous êtes désinscrit de cette activité.', 'success')
                            // MAJ déplace activité
                            const activityDiv = document.querySelector(`#inscrit-activities #activity-${activityId}`);

                            if (activityDiv) {
                                document.getElementById('available-activities').appendChild(activityDiv);

                                const button = activityDiv.querySelector('button');
                                button.innerHTML = '<i class="fas fa-plus-circle"></i> S\'inscrire';
                                button.classList.remove('btn-danger');
                                button.classList.add('btn-primary');
                                button.setAttribute('onclick', `subscribeActivity('${activityId}', '${dateAct}')`);
                            } else {
                                Swal.fire('Erreur', 'Activité non trouvée dans la liste des activités disponibles', 'error');
                            }
                        } else {
                            Swal.fire('Erreur', data.message, 'error');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire('Erreur', 'Une erreur est survenue lors de la désinscription.', 'error');
                    });
            }
        });
    }
</script>
</body>
</html>