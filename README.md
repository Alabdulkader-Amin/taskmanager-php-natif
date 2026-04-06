# taskmanager-php-natif

# Gestion de tâches - PHP natif

Application web de gestion de tâches avec authentification.

## Technologies utilisées
- PHP 8.5
- MySQL
- PDO
- Laragon

## Installation
1. Importer la base de données `taskmanager.sql`
2. Copier les fichiers dans `C:\laragon\www\taskmanager\`
3. Accéder à `http://localhost:8080/taskmanager/index.php`

## Compte de test
- Identifiant : `admin`
- Mot de passe : `admin`

## Fonctionnalités
- Inscription / Connexion
- Ajout de tâche
- Modification de tâche (changement de statut)
- Suppression de tâche
- Isolation des données (chaque utilisateur ne voit que ses tâches)

## Sécurité
- Mots de passe hachés (bcrypt)
- Requêtes préparées PDO (anti-injection SQL)
- Sessions PHP
