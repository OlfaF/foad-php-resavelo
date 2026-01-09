<?php
// Connexion à la base de données
require_once '../config/db_connect.php';

// Inclusion des fonctions de réservation
require_once '../includes/functions_reservation.php';

// Récupération de toutes les réservations
$reservations = getAllReservations($pdo);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mes réservations</title>

    <!-- Lien vers la feuille de style -->
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<h1>Mes réservations</h1>

<?php
// Si aucune réservation n'existe
if (empty($reservations)) {
    echo "<p>Aucune réservation trouvée.</p>";
}
?>

<!-- Tableau HTML pour afficher les réservations -->
<table border="1" cellpadding="10">
    <tr>
        <th>Vélo</th>
        <th>Date début</th>
        <th>Date fin</th>
        <th>Prix total</th>
        <th>Statut</th>
        <th>Action</th>
    </tr>

    <?php foreach ($reservations as $reservation): ?>
        <tr>
            <!-- Nom du vélo -->
            <td><?= htmlspecialchars($reservation['name']) ?></td>

            <!-- Dates -->
            <td><?= $reservation['start_date'] ?></td>
            <td><?= $reservation['end_date'] ?></td>

            <!-- Prix -->
            <td><?= $reservation['total_price'] ?> €</td>

            <!-- Statut -->
            <td><?= $reservation['status'] ?></td>

            <!-- Bouton annulation si possible -->
            <td>
                <?php if ($reservation['status'] === 'pending'): ?>
                    <a href="?cancel=<?= $reservation['id'] ?>">Annuler</a>
                <?php else: ?>
                    -
                <?php endif; ?>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

<?php
// Gestion de l'annulation
if (isset($_GET['cancel'])) {
    cancelReservation($pdo, $_GET['cancel']);

    // Redirection pour éviter le rechargement du lien
    header("Location: mes_reservations.php");
    exit;
}
?>

</body>
</html>

