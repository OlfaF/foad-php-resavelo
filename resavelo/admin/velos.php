<?php
require_once '../config/db_connect.php';
require_once '../includes/functions_velos.php';

$velos = getAllVelos($pdo);
?>

<h1>Gestion des vélos</h1>

<?php foreach ($velos as $velo): ?>
    <p>
        <?= $velo['name'] ?> -
        <a href="?delete=<?= $velo['id'] ?>">Supprimer</a>
    </p>
<?php endforeach; ?>
