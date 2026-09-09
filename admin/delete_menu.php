<?php
require_once __DIR__ . '/admin_auth.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: menu.php');
    exit;
}

$id = filter_var($_POST['id'] ?? '', FILTER_VALIDATE_INT);

if ($id) {
    $stmt = $pdo->prepare("DELETE FROM menu WHERE id = :id");
    $stmt->bindValue(':id', $id);
    $stmt->execute();
    $_SESSION['admin_message'] = "Menu item deleted.";
} else {
    $_SESSION['admin_message'] = "Invalid delete request.";
}

header('Location: menu.php');
exit;