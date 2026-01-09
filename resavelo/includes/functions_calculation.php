<?php

// Calcule le prix total d'une réservation
function calculatePrice($price_per_day, $start_date, $end_date) {

    // Création d'objets DateTime
    $start = new DateTime($start_date);
    $end   = new DateTime($end_date);

    // Calcul du nombre de jours entre les dates
    $days = $start->diff($end)->days + 1;

    // Prix total = jours × prix journalier
    return $days * $price_per_day;
}
