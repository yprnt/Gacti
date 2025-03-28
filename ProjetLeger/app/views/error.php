<?php
session_start();
?>
    <!DOCTYPE html>
    <html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Accès refusé</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        <link rel="stylesheet" href="../../assets/css/styles.css">
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
                background: linear-gradient(90deg, var(--danger), #ff9f43);
            }

            .message-title {
                font-size: 1.8rem;
                font-weight: 700;
                color: var(--danger);
                margin-bottom: 1rem;
            }

            .message-text {
                color: var(--dark);
                margin-bottom: 1.5rem;
                line-height: 1.6;
            }

            .message-link {
                display: inline-block;
                padding: 0.6rem 1.2rem;
                background-color: var(--primary);
                color: white;
                text-decoration: none;
                font-weight: 600;
                border-radius: var(--border-radius);
                transition: var(--transition);
            }

            .message-link:hover {
                background-color: var(--primary-dark);
                transform: translateY(-2px);
            }

            .message-icon {
                font-size: 3rem;
                color: var(--danger);
                margin-bottom: 1rem;
            }
        </style>
    </head>
    <body>
    <div class="message-container">
        <i class="fas fa-exclamation-triangle message-icon"></i>
        <h2 class="message-title">Accès refusé</h2>
        <p class="message-text"><?php echo $_SESSION['error']?></p>
        <a href="../../index.php" class="message-link">Retourner à l'accueil</a>
    </div>
    </body>
    </html>
<?php
session_unset();
session_destroy();
?>