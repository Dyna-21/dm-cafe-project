<?php
require_once __DIR__ . '/admin_auth.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: inventory.php');
    exit;
}

$id    = filter_var($_POST['id'] ?? '', FILTER_VALIDATE_INT);
$stock = filter_var($_POST['stock'] ?? '', FILTER_VALIDATE_INT);

if (!$id || $stock === false || $stock < 0) {
    $_SESSION['admin_message'] = "Invalid stock update.";
    header('Location: inventory.php');
    exit;
}

try {
    $stmt = $pdo->prepare("UPDATE menu SET stock = :stock WHERE id = :id");
    $stmt->bindValue(':stock', $stock);
    $stmt->bindValue(':id', $id);
    $stmt->execute();

    $_SESSION['admin_message'] = "Stock updated successfully.";
} catch (PDOException $e) {
    $_SESSION['admin_message'] = "Failed to update stock.";
}

header('Location: inventory.php');
exit;