<?php
require_once '../includes/partials/header_admin.php';
require_once '../config/db_connect.php';

// ==========================
// REQUÊTES DE STATISTIQUES
// ==========================

// Nombre total de vélos
$sqlVelos = "SELECT COUNT(*) AS total FROM velos";
$stmt = $pdo->query($sqlVelos);
$totalVelos = $stmt->fetchColumn();

// Nombre total de réservations
$sqlReservations = "SELECT COUNT(*) AS total FROM reservations";
$stmt = $pdo->query($sqlReservations);
$totalReservations = $stmt->fetchColumn();

// Chiffre d'affaires total (réservations validées uniquement)
$sqlCA = "SELECT SUM(total_price) AS total FROM reservations WHERE status = 'validated'";
$stmt = $pdo->query($sqlCA);
$totalCA = $stmt->fetchColumn();
if(!$totalCA) $totalCA = 0; // Évite d’afficher NULL

// Nombre de réservations en attente
$sqlPending = "SELECT COUNT(*) AS total FROM reservations WHERE status = 'pending'"; //en attente
$stmt = $pdo->query($sqlPending);
$totalPending = $stmt->fetchColumn();
?>

<h2>Tableau de bord - Administration</h2>

<div class="dashboard">
    <div class="card">
        <h3>Vélos disponibles</h3>
        <p><?= $totalVelos ?></p>
    </div>

    <div class="card">
        <h3>Réservations totales</h3>
        <p><?= $totalReservations ?></p>
    </div>

    <div class="card">
        <h3>Réservations en attente</h3>
        <p><?= $totalPending ?></p>
    </div>

    <div class="card">
        <h3>Chiffre d'affaires</h3>
        <p><?= $totalCA ?> €</p>
    </div>
</div>

<hr>

<nav>
    <a href="velos.php">Gestion des vélos</a> |
    <a href="reservations.php">Gestion des réservations</a> |
    <a href="../public/index.php">Retour au site</a>
</nav>

<?php
require_once '../includes/partials/footer.php';
?>

