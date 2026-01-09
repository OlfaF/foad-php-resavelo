<?php
// Démarrage de session si nécessaire
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Connexion à la base de données
require_once __DIR__ . '/../config/db_connect.php';

// Fonctions liées aux réservations
require_once __DIR__ . '/../includes/functions_reservation.php';

// Récupération de toutes les réservations
$reservations = getAllReservations($pdo);

// Gestion des actions admin (approve, reject, cancel)
if (isset($_GET['action']) && isset($_GET['id'])) {
    $id = intval($_GET['id']);

    switch ($_GET['action']) {
        case 'approve':
            updateReservationStatus($pdo, $id, 'approved');
            break;

        case 'reject':
            updateReservationStatus($pdo, $id, 'rejected');
            break;

        case 'cancel':
            updateReservationStatus($pdo, $id, 'cancelled');
            break;
    }

    // On recharge la page pour éviter les actions répétées
    header("Location: reservations.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Admin - Reservations</title>
    <link rel="stylesheet" href="../assets/css/admin.css">
</head>
<body>

<?php include __DIR__ . '/../includes/partials/header_admin.php'; ?>

<h1>Reservations Management</h1>

<table class="reservations-table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Bike</th>
            <th>Start date</th>
            <th>End date</th>
            <th>Total price</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($reservations as $res) : ?>
            <tr>
                <td><?= htmlspecialchars($res['id']) ?></td>
                <td><?= htmlspecialchars($res['velo_name']) ?></td>
                <td><?= htmlspecialchars($res['start_date']) ?></td>
                <td><?= htmlspecialchars($res['end_date']) ?></td>
                <td><?= htmlspecialchars($res['total_price']) ?> €</td>
                <td><?= htmlspecialchars($res['status']) ?></td>

                <td>
                    <a href="reservations.php?action=approve&id=<?= $res['id'] ?>">Approve</a> |
                    <a href="reservations.php?action=reject&id=<?= $res['id'] ?>">Reject</a> |
                    <a href="reservations.php?action=cancel&id=<?= $res['id'] ?>">Cancel</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

</body>
</html>