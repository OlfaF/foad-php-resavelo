<?php
require_once __DIR__ . '/../config/db_connect.php';

// Test simple
if ($pdo) {
    echo "Connexion à la base réussie ! ✅";
} else {
    echo "Connexion échouée ❌";
}
