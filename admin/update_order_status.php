<?php
require_once __DIR__ . '/admin_auth.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: orders.php');
    exit;
}

$order_id = filter_var($_POST['order_id'] ?? '', FILTER_VALIDATE_INT);
$status   = $_POST['status'] ?? '';
$valid_statuses = ['pending', 'preparing', 'ready', 'completed', 'cancelled'];

if (!$order_id || !in_array($status, $valid_statuses, true)) {
    $_SESSION['admin_message'] = "Invalid update request.";
    header('Location: orders.php');
    exit;
}

try {
    $stmt = $pdo->prepare("UPDATE orders SET status = :status WHERE id = :id");
    $stmt->bindValue(':status', $status);
    $stmt->bindValue(':id', $order_id);
    $stmt->execute();

    $_SESSION['admin_message'] = "Order #{$order_id} updated to \"" . ucfirst($status) . "\".";
} catch (PDOException $e) {
    $_SESSION['admin_message'] = "Failed to update order.";
}

header('Location: orders.php');
exit;