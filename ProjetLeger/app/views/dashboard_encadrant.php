<?php
session_start();
if (!isset($_SESSION['user']) ||
    ($_SESSION['profil'] !== 'en' && $_SESSION['user'] !== 'admin')) {
    header('Location: ../../index.php');
    exit();
}

include_once '../controllers/AnimationController.php';
include_once '../controllers/ActivityController.php';
include_once '../controllers/InscriptionController.php';

$anim = new controllers\AnimationController();
$act = new controllers\ActivityController();
$inscriptionController = new controllers\InscriptionController();

$allActivities = $act->getActivity();
$allAnimations = $anim->getAnimation();

$groupedActivities = [];
foreach ($allActivities as $activity) {
    $groupedActivities[$activity['CODEANIM']]['animation'] = [
        'CODEANIM' => $activity['CODEANIM'],
        'NOMANIM' => $activity['NOMANIM']
    ];
    $groupedActivities[$activity['CODEANIM']]['activities'][] = $activity;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Dashboard - Animateur</title>
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
        <h1 class="navbar-brand">Mon Dashboard - Encadrant</h1>

        <div class="navbar-links">
            <a href="../../index.php" class="nav-link primary">
                <i class="fas fa-home"></i> Accueil
            </a>

            <?php if ((isset($_SESSION['is_vacancier']) && $_SESSION['is_vacancier'] === true) ||
                (isset($_SESSION['profil']) && $_SESSION['profil'] === 'en') ||
                (isset($_SESSION['user']) && $_SESSION['user'] === 'admin')): ?>
                <a href="dashboard_vacancier.php" class="nav-link primary">
                    <i class="fas fa-user"></i> Tableau de bord
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
        <div class="dashboard-section fade-in">
            <div class="section-header">
                <h2 class="section-title">
                    <i class="fas fa-tasks"></i> Gérer les activités et animations
                </h2>
            </div>

            <div class="admin-controls">
                <div class="filter-group">
                    <label for="animationFilter" class="filter-label">
                        <i class="fas fa-filter"></i> Filtrer par animation
                    </label>
                    <select id="animationFilter" class="filter-select" onchange="filterAndModify()">
                        <option value="all" data-nom="Toutes les animations">Toutes les animations</option>
                        <?php foreach ($allAnimations as $animation): ?>
                            <option value="<?= $animation['CODEANIM'] ?>" data-nom="<?= $animation['NOMANIM'] ?>">
                                <?= $animation['NOMANIM'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>

                    <p id="filterHelpText" class="filter-help">Sélectionnez une animation pour pouvoir la modifier.</p>
                    <p id="modifyMessage" class="filter-help hidden">Vous pouvez modifier l'animation sélectionnée.</p>
                </div>

                <div class="action-buttons">
                    <a href="add_animation.php" class="btn btn-accent">
                        <i class="fas fa-plus-circle"></i> Nouvelle animation
                    </a>

                    <button id="modifyAnimationButton" class="btn btn-primary btn-disabled" disabled onclick="modifySelectedAnimation()">
                        <i class="fas fa-edit"></i> Modifier l'animation
                    </button>
                </div>
            </div>

            <div class="add-activity-banner">
                <div class="add-activity-content">
                    <i class="fas fa-calendar-plus"></i>
                    <a href="add_activity.php" class="btn btn-accent">
                        Ajouter une nouvelle activité
                    </a>
                </div>
            </div>

            <div id="all-activities" class="activity-grid">
                <?php if(empty($allActivities)): ?>
                    <div class="empty-state">
                        <i class="fas fa-calendar-times fa-3x" style="color: var(--gray);"></i>
                        <p>Aucune activité n'est disponible pour le moment.</p>
                    </div>
                <?php else: ?>
                    <?php foreach ($allActivities as $activity): ?>
                        <div id="activity-<?= $activity['CODEANIM'] ?>" class="activity-card">
                            <div class="activity-content">
                                <h3 class="activity-title"><?= $activity['NOMANIM'] ?></h3>
                                <p class="activity-description"><?= $activity['DESCRIPTANIM'] ?></p>

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
                                        <i class="fas fa-users"></i>
                                        <span>Places restantes:
                                                <?= $activity['NBREPLACEANIM'] - $inscriptionController->getCountInscription($activity['CODEANIM'], $activity['DATEACT']) ?>
                                            </span>
                                    </div>
                                </div>

                                <div class="activity-actions">
                                    <button class="btn-action btn-view" onclick="viewInscrits('<?= $activity['CODEANIM'] ?>', '<?= $activity['DATEACT'] ?>')">
                                        <i class="fas fa-eye"></i> Voir les inscrits
                                    </button>
                                    <button class="btn-action btn-edit" onclick="window.location.href='add_activity.php?activityId=<?= $activity['CODEANIM'] ?>&dateAct=<?= $activity['DATEACT'] ?>'">
                                        <i class="fas fa-edit"></i> Modifier
                                    </button>
                                    <button class="btn-action btn-delete" onclick="deleteActivity('<?= $activity['CODEANIM'] ?>', '<?= $activity['DATEACT'] ?>')">
                                        <i class="fas fa-trash-alt"></i> Annuler
                                    </button>
                                </div>
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
        &copy; 2024 Association VVA - Tous droits réservés.
    </div>
</footer>

<script>
    function filterAndModify() {
        const filter = document.getElementById('animationFilter');
        const selectedValue = filter.value;
        const modifyButton = document.getElementById('modifyAnimationButton');
        const filterHelpText = document.getElementById('filterHelpText');
        const modifyMessage = document.getElementById('modifyMessage');
        const activities = document.querySelectorAll('#all-activities > div');

        activities.forEach(activity => {
            if (selectedValue === 'all' || activity.id.includes(selectedValue)) {
                activity.style.display = 'block';
            } else {
                activity.style.display = 'none';
            }
        });

        if (selectedValue === 'all') {
            // Au lieu de cacher le bouton, on le désactive et change son apparence
            modifyButton.classList.remove('hidden');
            modifyButton.classList.add('btn-disabled');
            modifyButton.disabled = true;

            // Mettre à jour les messages d'aide
            modifyMessage.classList.add('hidden');
            filterHelpText.classList.remove('hidden');
        } else {
            // Activer le bouton et lui donner son apparence normale
            modifyButton.classList.remove('hidden');
            modifyButton.classList.remove('btn-disabled');
            modifyButton.disabled = false;

            // Mettre à jour les messages d'aide
            modifyMessage.classList.remove('hidden');
            filterHelpText.classList.add('hidden');

            // Définir l'action du bouton
            modifyButton.setAttribute('onclick', `modifySelectedAnimation('${selectedValue}')`);
        }
    }

    function deleteActivity(activityId, dateAct) {
        Swal.fire({
            title: 'Confirmation',
            text: 'Souhaitez-vous annuler cette activité ?',
            icon: 'warning',
            showClass: {
                popup: 'animate__animated animate__fadeIn animate__faster'
            },
            hideClass: {
                popup: 'animate__animated animate__fadeOut animate__faster'
            },
            showCancelButton: true,
            confirmButtonText: 'Oui, annuler',
            cancelButtonText: 'Non'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch('../controllers/deleteActivity.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({ activityId: activityId, dateAct: dateAct})
                }).then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire('Succès', 'Activité annulée.', 'success');
                            document.getElementById(`activity-${activityId}`).remove();
                        } else {
                            Swal.fire('Erreur', data.message, 'error');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire('Erreur', 'Une erreur est survenue lors de l\'annulation.', 'error');
                    });
            }
        });
    }

    function viewInscrits(activityId, dateAct) {
        Swal.fire({
            title: 'Inscrits à l\'activité',
            showClass: {
                popup: 'animate__animated animate__fadeIn animate__faster'
            },
            hideClass: {
                popup: 'animate__animated animate__fadeOut animate__faster'
            },
            html: '<div id="inscrits-list" class="text-left"></div>',
            didOpen: () => {
                fetch('../controllers/getInscrits.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({ activityId: activityId, dateAct: dateAct })
                }).then(response => response.json())
                    .then(data => {
                        let inscritsList = document.getElementById('inscrits-list');
                        if (data.success) {
                            if (data.inscrits.length > 0) {
                                inscritsList.innerHTML = '';
                                data.inscrits.forEach(inscrit => {
                                    let inscritDiv = document.createElement('div');
                                    inscritDiv.classList.add('mb-2');
                                    inscritDiv.innerHTML = `<strong>${inscrit.NOMCOMPTE} ${inscrit.PRENOMCOMPTE}</strong> - ${inscrit.ADRMAILCOMPTE}`;
                                    inscritsList.appendChild(inscritDiv);
                                });
                            } else {
                                inscritsList.innerHTML = 'Aucun inscrit';
                            }
                        } else {
                            Swal.showValidationMessage(`Erreur: ${data.message}`);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.showValidationMessage('Une erreur est survenue lors de la récupération des inscrits.');
                    });
            }
        });
    }

    function modifySelectedAnimation(animationId) {
        window.location.href = `add_animation.php?animationId=${animationId}`;
    }
</script>
</body>
</html>