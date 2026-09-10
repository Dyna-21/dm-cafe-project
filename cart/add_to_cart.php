<?php
require __DIR__ . '/../auth/database/config.php';
if (session_status() === PHP_SESSION_NONE) session_start();

// dili pwede mag-add to cart kung wa naka-log in
if (!isset($_SESSION["user_id"])) {
    header("Location: ../auth/login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $user_id      = $_SESSION["user_id"];
    $product_id   = filter_var($_POST["product_id"] ?? '', FILTER_VALIDATE_INT);
    $product_name = trim($_POST["product_name"]);
    $price        = filter_var($_POST["price"], FILTER_VALIDATE_FLOAT);
    $quantity     = filter_var($_POST["quantity"], FILTER_VALIDATE_INT);

    if (!$product_id || $product_name === "" || $price === false || $quantity === false || $quantity < 1 || $quantity > 20) {
        $_SESSION["cart_message"] = "Something went wrong adding that item.";
    } else {
        $pdo = getConnection();
        $sql = "INSERT INTO cart (user_id, product_id, product_name, price, quantity)
                VALUES (:user_id, :product_id, :product_name, :price, :quantity)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':user_id', $user_id);
        $stmt->bindValue(':product_id', $product_id);
        $stmt->bindValue(':product_name', $product_name);
        $stmt->bindValue(':price', $price);
        $stmt->bindValue(':quantity', $quantity);
        $stmt->execute();

        $_SESSION["cart_message"] = "$product_name added to your cart.";
    }
}

header("Location: ../menu.php");
exit;
?>