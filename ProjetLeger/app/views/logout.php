<?php
session_start();
session_unset();
session_destroy();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Déconnexion - GACTI</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../../assets/css/styles.css">
    <meta http-equiv="refresh" content="3;url=../../index.php"> <!-- redirection vers la page d'accueil après 3 secondes -->
    <style>
        body {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            background: linear-gradient(135deg, #f7f9fc 0%, #e2e8f0 100%);
        }

        .message-container {
            width: 100%;
            max-width: 400px;
            background-color: white;
            border-radius: var(--border-radius);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            padding: 2.5rem;
            margin: 1.5rem;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .message-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 5px;
            background: linear-gradient(90deg, var(--success), var(--primary));
        }

        .message-title {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--success);
            margin-bottom: 1rem;
        }

        .message-text {
            color: var(--dark);
            margin-bottom: 1.5rem;
            line-height: 1.6;
        }

        .message-link {
            color: var(--primary);
            text-decoration: none;
            font-weight: 600;
            transition: var(--transition);
        }

        .message-link:hover {
            color: var(--primary-dark);
            text-decoration: underline;
        }

        .message-footer {
            font-size: 0.9rem;
            color: var(--gray);
            margin-top: 1.5rem;
        }

        .message-icon {
            font-size: 3rem;
            color: var(--success);
            margin-bottom: 1rem;
        }
    </style>
</head>
<body>
<div class="message-container">
    <i class="fas fa-check-circle message-icon"></i>
    <h2 class="message-title">Déconnexion réussie</h2>
    <p class="message-text">Vous avez bien été déconnecté. Vous allez être redirigé vers la page d'accueil dans un instant.</p>
    <p class="message-footer">Si la redirection ne fonctionne pas, <a href="../../index.php" class="message-link">cliquez ici</a>.</p>
</div>
</body>
</html>