<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - GACTI</title>
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

        .login-container {
            width: 100%;
            max-width: 400px;
            background-color: white;
            border-radius: var(--border-radius);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            padding: 2.5rem;
            margin: 1.5rem;
            position: relative;
            overflow: hidden;
        }

        .login-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 5px;
            background: linear-gradient(90deg, var(--primary), var(--secondary));
        }

        .login-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .login-title {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--primary-dark);
            margin-bottom: 0.5rem;
        }

        .login-subtitle {
            color: var(--gray);
            font-size: 0.95rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: var(--dark);
            font-size: 0.9rem;
        }

        .input-group {
            display: flex;
            border: 1px solid var(--gray-light);
            border-radius: var(--border-radius);
            overflow: hidden;
            transition: var(--transition);
        }

        .input-group:focus-within {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(58, 110, 165, 0.2);
        }

        .input-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 48px;
            background-color: var(--gray-light);
            color: var(--primary);
        }

        .input-field {
            flex: 1;
            padding: 0.8rem 1rem;
            border: none;
            outline: none;
            font-size: 1rem;
            color: var(--dark);
        }

        .login-button {
            width: 100%;
            padding: 0.8rem;
            background: linear-gradient(90deg, var(--primary), var(--primary-dark));
            color: white;
            border: none;
            border-radius: var(--border-radius);
            font-weight: 700;
            font-size: 1rem;
            cursor: pointer;
            transition: var(--transition);
            margin-top: 1rem;
        }

        .login-button:hover {
            background: linear-gradient(90deg, var(--primary-dark), var(--primary));
            transform: translateY(-2px);
        }

        .back-link {
            display: block;
            text-align: center;
            margin-top: 1.5rem;
            color: var(--primary);
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 600;
            transition: var(--transition);
        }

        .back-link:hover {
            color: var(--primary-dark);
        }
    </style>
</head>
<body>
<div class="login-container">
    <div class="login-header">
        <h2 class="login-title">Bienvenue sur GACTI</h2>
        <p class="login-subtitle">Connectez-vous pour accéder à vos activités</p>
    </div>

    <form action="../controllers/LoginController.php" method="POST">
        <div class="form-group">
            <label for="username" class="form-label">Nom d'utilisateur</label>
            <div class="input-group">
                <div class="input-icon">
                    <i class="fas fa-user"></i>
                </div>
                <input type="text" name="username" id="username" class="input-field"
                       placeholder="Entrez votre identifiant" required>
            </div>
        </div>

        <div class="form-group">
            <label for="password" class="form-label">Mot de passe</label>
            <div class="input-group">
                <div class="input-icon">
                    <i class="fas fa-lock"></i>
                </div>
                <input type="password" name="password" id="password" class="input-field"
                       placeholder="Entrez votre mot de passe" required>
            </div>
        </div>

        <button type="submit" class="login-button">
            <i class="fas fa-sign-in-alt"></i> Se connecter
        </button>
    </form>

    <a href="../../index.php" class="back-link">
        <i class="fas fa-arrow-left"></i> Retour à l'accueil
    </a>
</div>
</body>
</html>