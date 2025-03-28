<?php
session_start();
if (!isset($_SESSION['user']) ||
    ($_SESSION['profil'] !== 'en' && $_SESSION['user'] !== 'admin')) {
    header('Location: ../../index.php');
    exit();
}

$showAlert = false;
$alertMessage = '';
$alertType = '';

include_once '../controllers/AnimationController.php';
include_once '../controllers/ActivityController.php';

$anim = new controllers\AnimationController();
$act = new controllers\ActivityController();

// Récupération des données pour les listes déroulantes
$allAnimations = $anim->getAnimation();
$allStatuts = $act->getAllStatuts();

// Vérifie si on est en mode modification
$isEditMode = isset($_GET['activityId'], $_GET['dateAct']);
$activity = null;

if ($isEditMode) {
    $activity = $act->getActivityByIdAndDate($_GET['activityId'], $_GET['dateAct']);
}

// Définir le titre en fonction du mode
$pageTitle = $isEditMode ? "Modifier une Activité" : "Ajouter une Activité";

// Vérifie si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $animation = $_POST['animation'];
    $statutAct = $_POST['statutAct'];
    $dateAnimation = $_POST['dateAct'];
    $heureArrivee = $_POST['heureArrivee'] ?? null;
    $heureDebut = $_POST['heureDebut'] ?? null;
    $heureFin = $_POST['heureFin'] ?? null;
    $prixAct = $_POST['prixAct'] ?? null;

    // Validation des données de formulaire
    if (!$animation || !$statutAct || !$dateAnimation) {
        $errorMessage = "Veuillez remplir tous les champs obligatoires.";
    } else {
        if ($isEditMode) {
            // Mode modification
            $success = $act->updateActivity($animation, $dateAnimation, $statutAct, $heureArrivee, $heureDebut, $heureFin, $prixAct, $_GET['activityId'], $_GET['dateAct']);
            $alertMessage = $success ? "Activité modifiée avec succès." : "Erreur lors de la modification.";
        } else {
            // Mode ajout
            $success = $act->addActivity($animation, $statutAct, $dateAnimation, $heureArrivee, $heureDebut, $heureFin, $prixAct);
            $alertMessage = $success ? "Activité ajoutée avec succès." : "Erreur lors de l\'ajout.";
        }

        $showAlert = true;
        $alertType = $success ? 'success' : 'error';
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?></title>
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
        <h1 class="navbar-brand"><?= $pageTitle ?></h1>

        <div class="navbar-links">
            <a href="dashboard_encadrant.php" class="nav-link primary">
                <i class="fas fa-arrow-left"></i> Retour au Dashboard
            </a>
        </div>
    </div>
</nav>

<div class="main-content">
    <div class="container">
        <div class="form-container fade-in">
            <form action="" method="POST" class="form-grid">
                <div class="form-section">
                    <h3 class="form-section-title">
                        <i class="fas fa-info-circle"></i> Informations de base
                    </h3>

                    <div class="form-group">
                        <label for="animation" class="form-label">Animation associée</label>
                        <select name="animation" id="animation" class="form-select" required>
                            <?php foreach ($allAnimations as $animation): ?>
                                <option value="<?= $animation['CODEANIM'] ?>"
                                    <?= ($isEditMode && $activity[0]['CODEANIM'] === $animation['CODEANIM']) ? 'selected' : '' ?>>
                                    <?= $animation['NOMANIM'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="statutAct" class="form-label">Statut de l'activité</label>
                        <select name="statutAct" id="statutAct" class="form-select" required>
                            <?php foreach ($allStatuts as $statut): ?>
                                <option value="<?= $statut['CODEETATACT'] ?>"
                                    <?= ($isEditMode && $activity[0]['CODEETATACT'] === $statut['CODEETATACT']) ? 'selected' : '' ?>>
                                    <?= $statut['NOMETATACT'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="dateAct" class="form-label">Date de l'activité</label>
                        <div class="input-with-icon">
                            <i class="fas fa-calendar"></i>
                            <input type="date" name="dateAct" id="dateAct"
                                   value="<?= $isEditMode ? $activity[0]['DATEACT'] : '' ?>"
                                   class="form-input" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="prixAct" class="form-label">Prix de l'activité (€)</label>
                        <div class="input-with-icon">
                            <i class="fas fa-euro-sign"></i>
                            <input type="number" step="0.01" name="prixAct" id="prixAct"
                                   value="<?= $isEditMode ? $activity[0]['PRIXACT'] : '' ?>"
                                   class="form-input">
                        </div>
                    </div>
                </div>

                <div class="form-section">
                    <h3 class="form-section-title">
                        <i class="fas fa-clock"></i> Horaires
                    </h3>

                    <div class="timing-grid">
                        <div class="form-group">
                            <label for="heureArrivee" class="form-label">Heure d'arrivée</label>
                            <div class="input-with-icon">
                                <i class="fas fa-user-clock"></i>
                                <input type="time" name="heureArrivee" id="heureArrivee"
                                       value="<?= $isEditMode ? $activity[0]['HRRDVACT'] : '' ?>"
                                       class="form-input">
                            </div>
                            <span class="form-help">Heure de rendez-vous des participants</span>
                        </div>

                        <div class="form-group">
                            <label for="heureDebut" class="form-label">Heure de début</label>
                            <div class="input-with-icon">
                                <i class="fas fa-play"></i>
                                <input type="time" name="heureDebut" id="heureDebut"
                                       value="<?= $isEditMode ? $activity[0]['HRDEBUTACT'] : '' ?>"
                                       class="form-input">
                            </div>
                            <span class="form-help">Démarrage de l'activité</span>
                        </div>

                        <div class="form-group">
                            <label for="heureFin" class="form-label">Heure de fin</label>
                            <div class="input-with-icon">
                                <i class="fas fa-flag-checkered"></i>
                                <input type="time" name="heureFin" id="heureFin"
                                       value="<?= $isEditMode ? $activity[0]['HRFINACT'] : '' ?>"
                                       class="form-input">
                            </div>
                            <span class="form-help">Fin prévue de l'activité</span>
                        </div>
                    </div>

                    <div class="timing-info">
                        <i class="fas fa-info-circle"></i>
                        <p>Assurez-vous que les horaires sont cohérents et permettent aux participants d'avoir suffisamment de temps pour profiter de l'activité.</p>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-<?= $isEditMode ? 'save' : 'plus-circle' ?>"></i>
                        <?= $isEditMode ? 'Modifier' : 'Ajouter' ?> l'activité
                    </button>
                    <a href="dashboard_encadrant.php" class="btn btn-danger">
                        <i class="fas fa-times-circle"></i> Annuler
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<footer class="footer">
    <div class="container footer-content">
        &copy; 2024 Association VVA - Tous droits réservés.
    </div>
</footer>

<script>
    document.querySelector('form').addEventListener('submit', function(e) {
        e.preventDefault();

        const isEditMode = new URLSearchParams(window.location.search).has('activityId');
        const animation = document.querySelector('select[name="animation"]');
        const animationName = animation.options[animation.selectedIndex].text;
        const dateAct = document.querySelector('input[name="dateAct"]').value;

        // Formater la date pour l'affichage
        const formattedDate = new Date(dateAct).toLocaleDateString('fr-FR', {
            day: 'numeric',
            month: 'long',
            year: 'numeric'
        });

        const confirmText = isEditMode
            ? `Voulez-vous vraiment modifier l'activité "${animationName}" du ${formattedDate} ?`
            : `Voulez-vous vraiment ajouter l'activité "${animationName}" pour le ${formattedDate} ?`;

        Swal.fire({
            title: isEditMode ? 'Modifier l\'activité' : 'Ajouter une activité',
            text: confirmText,
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Oui',
            cancelButtonText: 'Non'
        }).then((result) => {
            if (result.isConfirmed) {
                this.submit();
            }
        });
    });
</script>
<?php if ($showAlert): ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                title: '<?= $success ? "Succès" : "Erreur" ?>',
                text: '<?= $alertMessage ?>',
                icon: '<?= $alertType ?>',
            }).then((result) => {
                window.location.href = 'dashboard_encadrant.php';
            });
        });
    </script>
<?php endif; ?>
</body>
</html>