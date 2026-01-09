<?php
require_once 'functions_calculation.php';

// Vérifie si un vélo est disponible sur une période donnée
function checkAvailability($pdo, $velo_id, $start_date, $end_date) {

    // Compte le nombre de réservations qui se chevauchent
    $sql = "
        SELECT COUNT(*) FROM reservations
        WHERE velo_id = ?
        AND status = 'validated'
        AND NOT (end_date < ? OR start_date > ?)
    ";

    $stmt = $pdo->prepare($sql);

    // Exécution avec les dates fournies
    $stmt->execute([$velo_id, $start_date, $end_date]);

    // Retourne le nombre de réservations existantes
    return $stmt->fetchColumn();
}

// Création d'une réservation
function createReservation($pdo, $velo_id, $start_date, $end_date) {

    // Récupère les informations du vélo
    $velo = getVeloById($pdo, $velo_id);

    // Vérifie le nombre de vélos déjà réservés
    $reserved = checkAvailability($pdo, $velo_id, $start_date, $end_date);

    // Si le stock est atteint → réservation impossible
    if ($reserved >= $velo['quantity']) {
        return false;
    }

    // Calcul du prix total
    $total_price = calculatePrice(
        $velo['price'],
        $start_date,
        $end_date
    );

    // Insertion de la réservation
    $sql = "INSERT INTO reservations
            (velo_id, start_date, end_date, total_price)
            VALUES (?, ?, ?, ?)";

    $stmt = $pdo->prepare($sql);

    return $stmt->execute([
        $velo_id,
        $start_date,
        $end_date,
        $total_price
    ]);
}

// Récupère toutes les réservations (admin)
function getAllReservations($pdo) {
    $sql = "
        SELECT r.*, v.name
        FROM reservations r
        JOIN velos v ON r.velo_id = v.id
        ORDER BY r.created_at DESC
    ";

    return $pdo->query($sql)
               ->fetchAll(PDO::FETCH_ASSOC);
}

// Met à jour le statut d'une réservation
function updateReservationStatus($pdo, $id, $status) {
    $stmt = $pdo->prepare(
        "UPDATE reservations SET status=? WHERE id=?"
    );

    return $stmt->execute([$status, $id]);
}

// Annule une réservation
function cancelReservation($pdo, $id) {
    return updateReservationStatus($pdo, $id, 'cancelled');
}
