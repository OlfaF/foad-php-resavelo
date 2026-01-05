<?php
// Paramètres de connexion
$host = 'localhost';
$db   = 'resavelo'; // nom de la base importée
$user = 'root';     // utilisateur MySQL par défaut
$pass = '';        
$charset = 'utf8mb4';

// DSN PDO
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

// Options PDO
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // erreurs PDO en exception
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // fetch sous forme de tableau associatif
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
    
} catch (PDOException $e) {
    echo "Erreur de connexion : " . $e->getMessage();
}
