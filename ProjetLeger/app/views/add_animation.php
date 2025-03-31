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

$controller = new controllers\AnimationController();
$allTypes = $controller->getAllTypes();

// Détection du mode édition
$isEditMode = isset($_GET['animationId']);
$animation = null;

if ($isEditMode) {
    $animation = $controller->getAnimationById($_GET['animationId']);
}

$pageTitle = $isEditMode ? "Modifier une Animation" : "Ajouter une Animation";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nomAnim = $_POST['nomAnim'];
    $typeAnim = $_POST['typeAnim'];
    $dureeAnim = $_POST['dureeAnim'];
    $limiteAge = $_POST['limiteAge'];
    $nbrePlaceAnim = $_POST['nbrePlaceAnim'];
    $prixAnim = $_POST['prixAnim'];
    $descriptionAnim = $_POST['descriptionAnim'];
    $commentaireAnim = $_POST['commentaireAnim'];
    $difficulteAnim = $_POST['difficulteAnim'];

    if ($isEditMode) {
        $success = $controller->updateAnimation($_GET['animationId'], $nomAnim, $typeAnim, $dureeAnim, $limiteAge, $nbrePlaceAnim, $prixAnim, $descriptionAnim, $commentaireAnim, $difficulteAnim);
        $alertMessage = $success ? "Animation modifiée avec succès." : "Erreur lors de la modification.";
    } else {
        $success = $controller->addAnimation($nomAnim, $typeAnim, $dureeAnim, $limiteAge, $nbrePlaceAnim, $prixAnim, $descriptionAnim, $commentaireAnim, $difficulteAnim);
        $alertMessage = $success ? "Animation ajoutée avec succès." : "Erreur lors de l\'ajout.";
    }

    $showAlert = true;
    $alertType = $success ? 'success' : 'error';
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
                        <i class="fas fa-info-circle"></i> Informations générales
                    </h3>

                    <div class="form-group">
                        <label for="nomAnim" class="form-label">Nom de l'animation</label>
                        <input type="text" name="nomAnim" id="nomAnim" class="form-input"
                               value="<?= $isEditMode ? $animation[0]['NOMANIM'] : '' ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="typeAnim" class="form-label">Type d'animation</label>
                        <div class="input-with-button">
                            <select name="typeAnim" id="typeAnim" class="form-select" required>
                                <?php foreach ($allTypes as $type): ?>
                                    <option value="<?= $type['CODETYPEANIM'] ?>"
                                        <?= $isEditMode && $animation[0]['CODETYPEANIM'] === $type['CODETYPEANIM'] ? 'selected' : '' ?>>
                                        <?= $type['NOMTYPEANIM'] ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <button type="button" class="form-button-addon" onclick="addType()">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="descriptionAnim" class="form-label">Description</label>
                        <textarea name="descriptionAnim" id="descriptionAnim" rows="4" class="form-textarea"><?= $isEditMode ? $animation[0]['DESCRIPTANIM'] : '' ?></textarea>
                    </div>
                </div>

                <div class="form-section">
                    <h3 class="form-section-title">
                        <i class="fas fa-cog"></i> Paramètres de l'animation
                    </h3>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="dureeAnim" class="form-label">Durée (heures)</label>
                            <input type="number" name="dureeAnim" id="dureeAnim" class="form-input"
                                   value="<?= $isEditMode ? $animation[0]['DUREEANIM'] : '' ?>">
                        </div>

                        <div class="form-group">
                            <label for="limiteAge" class="form-label">Limite d'âge</label>
                            <input type="number" name="limiteAge" id="limiteAge" class="form-input"
                                   value="<?= $isEditMode ? $animation[0]['LIMITEAGE'] : '' ?>">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="prixAnim" class="form-label">Tarif (€)</label>
                            <input type="number" step="0.01" name="prixAnim" id="prixAnim" class="form-input"
                                   value="<?= $isEditMode ? $animation[0]['TARIFANIM'] : '' ?>">
                        </div>

                        <div class="form-group">
                            <label for="nbrePlaceAnim" class="form-label">Nombre de places</label>
                            <input type="number" name="nbrePlaceAnim" id="nbrePlaceAnim" class="form-input"
                                   value="<?= $isEditMode ? $animation[0]['NBREPLACEANIM'] : '' ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="difficulteAnim" class="form-label">Difficulté</label>
                        <select name="difficulteAnim" id="difficulteAnim" class="form-select">
                            <option value="Facile" <?= $isEditMode && $animation[0]['DIFFICULTEANIM'] === 'Facile' ? 'selected' : '' ?>>Facile</option>
                            <option value="Moyen" <?= $isEditMode && $animation[0]['DIFFICULTEANIM'] === 'Moyen' ? 'selected' : '' ?>>Moyen</option>
                            <option value="Difficile" <?= $isEditMode && $animation[0]['DIFFICULTEANIM'] === 'Difficile' ? 'selected' : '' ?>>Difficile</option>
                            <option value="Expert" <?= $isEditMode && $animation[0]['DIFFICULTEANIM'] === 'Expert' ? 'selected' : '' ?>>Expert</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="commentaireAnim" class="form-label">Commentaire</label>
                        <textarea name="commentaireAnim" id="commentaireAnim" rows="4" class="form-textarea"><?= $isEditMode ? $animation[0]['COMMENTANIM'] : '' ?></textarea>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-<?= $isEditMode ? 'save' : 'plus-circle' ?>"></i>
                        <?= $isEditMode ? 'Modifier' : 'Ajouter' ?> l'animation
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
        &copy; 2025 Association VVA - Tous droits réservés.
    </div>
</footer>

<script>
    function addType() {
        Swal.fire({
            title: 'Ajouter un nouveau type',
            html: `
                <div class="form-group" style="margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 5px; text-align: left; font-weight: bold;">Code Type (max 5 caractères)</label>
                    <input type="text" id="codeType" class="swal2-input" placeholder="Code Type" maxlength="5" style="width: 100%; margin: 0;">
                </div>
                <div class="form-group">
                    <label style="display: block; margin-bottom: 5px; text-align: left; font-weight: bold;">Nom du Type</label>
                    <input type="text" id="nomType" class="swal2-input" placeholder="Nom Type" style="width: 100%; margin: 0;">
                </div>
            `,
            showCancelButton: true,
            confirmButtonText: 'Ajouter',
            cancelButtonText: 'Annuler',
            showLoaderOnConfirm: true,
            customClass: {
                popup: 'form-popup',
                confirmButton: 'swal-confirm-button',
                cancelButton: 'swal-cancel-button'
            },
            focusConfirm: false,
            preConfirm: () => {
                const codeType = Swal.getPopup().querySelector('#codeType').value;
                const nomType = Swal.getPopup().querySelector('#nomType').value;

                if (!codeType || !nomType) {
                    Swal.showValidationMessage('Veuillez remplir les deux champs.');
                    return;
                }

                // Vérification et ajout du type
                return fetch('../controllers/addType.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ codeType, nomType })
                })
                    .then(response => response.json())
                    .then(data => {
                        if (!data.success) {
                            throw new Error(data.message || 'Erreur lors de l\'ajout');
                        }
                        return data;
                    })
                    .catch(error => Swal.showValidationMessage(error.message));
            }
        }).then((result) => {
            if (result.isConfirmed) {
                const newOption = new Option(result.value.nomType, result.value.codeType);
                document.getElementById('typeAnim').add(newOption, undefined);
                document.getElementById('typeAnim').value = result.value.codeType;
                Swal.fire({
                    title: 'Succès',
                    text: 'Type ajouté avec succès.',
                    icon: 'success'
                });
            }
        });
    }

    document.querySelector('form').addEventListener('submit', function(e) {
        e.preventDefault();

        const isEditMode = new URLSearchParams(window.location.search).has('animationId');
        const nomAnimation = document.querySelector('input[name="nomAnim"]').value;
        const confirmText = isEditMode
            ? `Voulez-vous vraiment modifier l'animation "${nomAnimation}" ?`
            : `Voulez-vous vraiment ajouter l'animation "${nomAnimation}" ?`;

        Swal.fire({
            title: isEditMode ? 'Modifier l\'animation' : 'Ajouter une animation',
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