<?php
require __DIR__ . '/../auth/database/config.php';
if (session_status() === PHP_SESSION_NONE) session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: ../auth/login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: checkout.php");
    exit;
}

$user_id = $_SESSION["user_id"];
$pdo = getConnection();

$stmt = $pdo->prepare("SELECT * FROM cart WHERE user_id = :user_id");
$stmt->bindValue(':user_id', $user_id);
$stmt->execute();
$cart_items = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (empty($cart_items)) {
    $_SESSION['checkout_message'] = "Your cart is empty.";
    header("Location: view-cart.php");
    exit;
}

$total = 0;
foreach ($cart_items as $item) {
    $total += $item['price'] * $item['quantity'];
}

try {
    $pdo->beginTransaction();

    // 1. Create order
    $stmt = $pdo->prepare("INSERT INTO orders (user_id, total, status) VALUES (:user_id, :total, 'pending')");
    $stmt->bindValue(':user_id', $user_id);
    $stmt->bindValue(':total', $total);
    $stmt->execute();
    $order_id = $pdo->lastInsertId();

    // 2. Copy cart items to order_items
    $stmt = $pdo->prepare("INSERT INTO order_items (order_id, product_name, price, quantity) VALUES (:order_id, :product_name, :price, :quantity)");
    foreach ($cart_items as $item) {
        $stmt->bindValue(':order_id', $order_id);
        $stmt->bindValue(':product_name', $item['product_name']);
        $stmt->bindValue(':price', $item['price']);
        $stmt->bindValue(':quantity', $item['quantity']);
        $stmt->execute();
    }

    // 3. Clear the user's cart
    $stmt = $pdo->prepare("DELETE FROM cart WHERE user_id = :user_id");
    $stmt->bindValue(':user_id', $user_id);
    $stmt->execute();

    $pdo->commit();

    $_SESSION['order_success'] = $order_id;
    header("Location: order_success.php");
    exit;

} catch (PDOException $e) {
    $pdo->rollBack();
    $_SESSION['checkout_message'] = "Something went wrong placing your order. Please try again.";
    header("Location: checkout.php");
    exit;
}