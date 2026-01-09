<?php
require_once '../config/db_connect.php';
require_once '../includes/functions_reservation.php';

$velo_id = $_GET['id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    createReservation(
        $pdo,
        $velo_id,
        $_POST['start_date'],
        $_POST['end_date']
    );
    echo "Réservation envoyée";
}
?>

<form method="post">
    <label>Date début</label>
    <input type="date" name="start_date" required>

    <label>Date fin</label>
    <input type="date" name="end_date" required>

    <button type="submit">Valider</button>
</form>
