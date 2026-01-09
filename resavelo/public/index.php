<?php
// Connexion à la base
require_once __DIR__ . '/../config/db_connect.php';

// Fonctions pour gérer les vélos
require_once __DIR__ . '/../includes/functions_velos.php';


// Inclusion du header commun (navigation, logo, etc.)
include_once __DIR__ . '/../includes/partials/header_public.php';


// Récupérer tous les vélos
$velos = getAllVelos($pdo);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Catalogue des vélos</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <h1>Catalogue des vélos</h1>

    <?php foreach($velos as $velo): ?>
        <div class="velo">
            <h2><?= htmlspecialchars($velo['name']); ?></h2>
            <p>Prix : <?= htmlspecialchars($velo['price']); ?> €/jour</p>
            <p>Quantité disponible : <?= htmlspecialchars($velo['quantity']); ?></p>
            <p>Description : <?= htmlspecialchars($velo['description']); ?></p>
            <?php if($velo['image_url']): ?>
                <img src="../assets/imgs/<?= htmlspecialchars($velo['image_url']); ?>" alt="<?= htmlspecialchars($velo['name']); ?>" width="200">
            <?php endif; ?>
        </div>
        <hr>
    <?php endforeach; ?>
</body>
</html>

