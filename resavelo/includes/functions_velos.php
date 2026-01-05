<?php
require_once __DIR__ . '/../config/db_connect.php';

// Récupérer tous les vélos
function getAllVelos($pdo) {
    $stmt = $pdo->query("SELECT * FROM velos");
    return $stmt->fetchAll();
}

// Récupérer un vélo par son ID
function getVeloById($pdo, $id) {
    $stmt = $pdo->prepare("SELECT * FROM velos WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch();
}

// Ajouter un vélo
function addVelo($pdo, $data) {
    $stmt = $pdo->prepare("INSERT INTO velos (name, price, quantity, description, image_url, created_at) VALUES (?, ?, ?, ?, ?, NOW())");
    return $stmt->execute([$data['name'], $data['price'], $data['quantity'], $data['description'], $data['image_url']]);
}

// Modifier un vélo
function updateVelo($pdo, $id, $data) {
    $stmt = $pdo->prepare("UPDATE velos SET name=?, price=?, quantity=?, description=?, image_url=? WHERE id=?");
    return $stmt->execute([$data['name'], $data['price'], $data['quantity'], $data['description'], $data['image_url'], $id]);
}

// Supprimer un vélo
function deleteVelo($pdo, $id) {
    $stmt = $pdo->prepare("DELETE FROM velos WHERE id=?");
    return $stmt->execute([$id]);
}
