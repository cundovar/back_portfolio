<?php
require __DIR__ . '/vendor/autoload.php';

use Symfony\Component\Dotenv\Dotenv;
use Symfony\Component\PasswordHasher\Hasher\PasswordHasherFactory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasher;
use App\Entity\User;

// Charger les variables d'environnement
$dotenv = new Dotenv();
$dotenv->loadEnv(__DIR__ . '/.env');

// Créer une instance de l'utilisateur
$user = new User(); // Assurez-vous que vous avez la bonne classe User pour votre application
$user->setEmail('bk@gmail.com');

// Créer la factory des hasheurs
$factory = new PasswordHasherFactory([
    User::class => ['algorithm' => 'bcrypt'],
]);

// Instancier le hasher de mot de passe
$passwordHasher = new UserPasswordHasher($factory);

// Hasher le mot de passe
$hashedPassword = $passwordHasher->hashPassword($user, '123456');

echo "Le mot de passe hashé est : " . $hashedPassword . PHP_EOL;
