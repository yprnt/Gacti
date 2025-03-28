# 🏔️ Application de Gestion VVA (Village Vacances Alpes)

## 📋 Présentation
Application web permettant la gestion complète des animations et activités pour l'association Village Vacances Alpes (VVA). Elle offre différentes fonctionnalités selon le profil utilisateur, garantissant une expérience adaptée aux besoins de chacun.

## 🖼️ Aperçu

### Page d'accueil
![Page d'accueil](https://github.com/yprnt/Gacti/blob/master/img/Main.png)

### Dasboard Utilisateur
![Catalogue d'activités](https://github.com/yprnt/Gacti/blob/master/img/Vacancier.png)

### Dashboard Encadrant
![Espace utilisateur](https://github.com/yprnt/Gacti/blob/master/img/Encadrant.png)

## ✨ Fonctionnalités par profil utilisateur

### 👤 Utilisateur non connecté
- Consulter la liste des animations et activités disponibles
- Visualiser le planning général des activités
- Accéder à la page de connexion

### 🧑‍💼 Vacancier connecté
- Accéder à la liste détaillée des animations et activités
- S'inscrire et se désinscrire aux activités
- Consulter son planning personnel d'activités
- **Note**: Accès aux fonctionnalités d'inscription uniquement pendant la période de séjour

### 👨‍🏫 Encadrant/Animateur
- Toutes les fonctionnalités d'un vacancier connecté
- Ajouter de nouvelles animations
- Créer et planifier des activités
- Modifier ou annuler des animations et activités
- Consulter la liste des inscrits pour chaque activité

### 👨‍💻 Administrateur
- Toutes les fonctionnalités d'un encadrant
- Accéder à la liste complète des utilisateurs
- Gérer les comptes utilisateurs et leurs mots de passe

## 🔑 Connexion rapide

### Compte Vacancier (Hors séjour)
- **Login** : aa
- **Mot de passe** : aa

### Compte Vacancier (Séjour en cours)
- **Login** : tt
- **Mot de passe** : tt

### Compte Encadrant
- **Login** : yy
- **Mot de passe** : yy

### Compte Administrateur
- **Login** : admin
- **Mot de passe** : admin

## 🛠️ Configuration technique

### Prérequis
- Navigateur web moderne
- Serveur Apache
- PHP 8.3
- Base de données MySQL/MariaDB

### Installation
1. Cloner le dépôt
2. Importer le fichier SQL fourni dans votre base de données
3. Configurer les paramètres de connexion dans le fichier `config.php`
4. Lancer l'application via le serveur Apache

## 📊 Architecture

L'application a été développée selon le modèle MVC (Modèle-Vue-Contrôleur) :
- **Modèle** : Gestion des données et interactions avec la base de données
- **Vue** : Interface utilisateur adaptative selon le profil
- **Contrôleur** : Logique de traitement et de routage des requêtes

## 🔄 Schéma de la base de données

Le modèle de données comprend les entités suivantes :
- Utilisateurs (vacanciers, encadrants, administrateurs)
- Animations (descriptions des activités proposées)
- Activités (sessions planifiées des animations)
- Inscriptions (lien entre utilisateurs et activités)
- Types d'animations (catégorisation des animations)

![MCD](https://github.com/yprnt/Gacti/blob/master/img/MCD.png)

## 📝 Cahier des charges

Ce projet a été développé sur la base d'un cahier des charges précis incluant :
- La structure de la base de données
- Les schémas d'utilisation de l'application
- Les différents profils d'utilisateurs et leurs droits
- Les contraintes techniques et fonctionnelles

![UseCase](https://github.com/yprnt/Gacti/blob/master/img/UseCase.png)

---

Développé sur macOS avec Apache et PHP 8.3 - Effectué pour un BTS SIO option SLAM
