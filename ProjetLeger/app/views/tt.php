<?php
session_start();
// Logique pour gérer les mois
$month = isset($_GET['month']) ? (int)$_GET['month'] : date('m');
$year = isset($_GET['year']) ? (int)$_GET['year'] : date('Y');
$daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);
$firstDayOfMonth = date('N', strtotime("$year-$month-01"));
$today = date('Y-m-d');

// Navigation mois suivant et précédent
$prevMonth = $month - 1 > 0 ? $month - 1 : 12;
$prevYear = $month - 1 > 0 ? $year : $year - 1;
$nextMonth = $month + 1 <= 12 ? $month + 1 : 1;
$nextYear = $month + 1 <= 12 ? $year : $year + 1;

include_once '../controllers/ActivityController.php';
include_once '../controllers/InscriptionController.php';

$act = new controllers\ActivityController();
$inscriptionController = new controllers\InscriptionController();

// Récupérer les activités auxquelles l'utilisateur est inscrit et celles disponibles
$inscritActivities = $inscriptionController->getInscriptionById($_SESSION['user']);
$availableActivities = $act->getActivityUnRegister($_SESSION['user']);

// Récupérer toutes les activités dans un tableau associatif basé sur les dates
$events = [];
foreach ($inscritActivities as $activity) {
    $events[$activity['DATEACT']][] = [
        'nom' => $activity['NOMANIM'],
        'inscrit' => true,
        'details' => $activity['DESCRIPTANIM']
    ];
}
foreach ($availableActivities as $activity) {
    $events[$activity['DATEACT']][] = [
        'nom' => $activity['NOMANIM'],
        'inscrit' => false,
        'details' => $activity['DESCRIPTANIM']
    ];
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendrier des activités</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 min-h-screen flex flex-col justify-center">

<div class="container mx-auto px-4 py-6">
    <!-- Conteneur avec ombre pour tout le calendrier -->
    <div class="shadow-lg p-6 bg-white rounded-lg">

        <!-- Navigation du calendrier -->
        <div class="flex justify-between items-center mb-4 bg-indigo-600 text-white p-4 rounded-lg">
            <a href="?month=<?= $prevMonth ?>&year=<?= $prevYear ?>" class="text-white hover:text-gray-300">&larr; Mois précédent</a>
            <h2 class="text-2xl font-bold"><?= date('F Y', strtotime("$year-$month-01")) ?></h2>
            <a href="?month=<?= $nextMonth ?>&year=<?= $nextYear ?>" class="text-white hover:text-gray-300">Mois suivant &rarr;</a>
        </div>

        <!-- Entêtes des jours de la semaine avec bordure entourée -->
        <div class="grid grid-cols-7 text-center text-gray-700 font-semibold mb-0 border border-gray-300">
            <div class="py-2 border-r border-gray-300">Lundi</div>
            <div class="py-2 border-r border-gray-300">Mardi</div>
            <div class="py-2 border-r border-gray-300">Mercredi</div>
            <div class="py-2 border-r border-gray-300">Jeudi</div>
            <div class="py-2 border-r border-gray-300">Vendredi</div>
            <div class="py-2 border-r border-gray-300">Samedi</div>
            <div class="py-2">Dimanche</div>
        </div>

        <!-- Grille du calendrier avec bordures plus fines -->
        <div class="grid grid-cols-7 text-center text-sm">
            <?php
            // Espaces avant le début du mois
            for ($i = 1; $i < $firstDayOfMonth; $i++) {
                echo '<div class="h-24 bg-gray-100 border border-gray-200"></div>';
            }

            // Afficher les jours du mois
            for ($day = 1; $day <= $daysInMonth; $day++) {
                $currentDate = sprintf('%04d-%02d-%02d', $year, $month, $day);
                $isToday = ($currentDate == $today);
                $borderClass = $isToday ? 'border-4 border-indigo-500' : 'border border-gray-200';
                $textColor = $isToday ? 'text-indigo-700' : 'text-gray-400';

                echo "<div class='relative h-24 bg-white $borderClass'>";
                echo "<div class='absolute top-2 right-2 $textColor'>$day</div>";
                echo "<br>";

                // Vérifier s'il y a des activités pour cette date
                if (isset($events[$currentDate])) {
                    echo '<ul class="mt-4 space-y-1">';
                    foreach ($events[$currentDate] as $event) {
                        // Utiliser des couleurs différentes pour les activités inscrites et non-inscrites
                        $colorClass = $event['inscrit'] ? 'bg-green-100 text-green-700 hover:bg-green-200' : 'bg-indigo-100 text-indigo-700 hover:bg-indigo-200';
                        $details = htmlspecialchars($event['details'], ENT_QUOTES, 'UTF-8');
                        echo "<li><button class='event-btn w-full flex items-center justify-center rounded-lg px-1 py-1 text-xs font-medium $colorClass' data-details='$details'>{$event['nom']}</button></li>";
                    }
                    echo '</ul>';
                }

                echo '</div>';
            }

            $lastDayOfWeek = ($firstDayOfMonth + $daysInMonth - 1) % 7;
            if ($lastDayOfWeek != 0) {
                for ($i = $lastDayOfWeek; $i < 7; $i++) {
                    echo '<div class="h-24 bg-gray-100 border border-gray-200"></div>';
                }
            }
            ?>
        </div>
    </div>
</div>

<script>
    document.querySelectorAll('.event-btn').forEach(button => {
        button.addEventListener('click', () => {
            let eventDetails = button.getAttribute('data-details');
            Swal.fire({
                title: 'Détails de l\'événement',
                text: eventDetails,
                icon: 'info',
                confirmButtonText: 'Fermer'
            });
        });
    });
</script>

</body>
</html>