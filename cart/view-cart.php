VIEW CART

<?php
require __DIR__ . '/../auth/database/config.php';
if (session_status() === PHP_SESSION_NONE) session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: ../auth/login.php");
    exit;
}

$pdo = getConnection();

// Logic para i-delete ang item gikan sa database
if (isset($_GET['remove'])) {
    $cart_id = $_GET['remove'];
    $del_stmt = $pdo->prepare("DELETE FROM cart WHERE id = :id AND user_id = :user_id");
    $del_stmt->execute([
        ':id' => $cart_id,
        ':user_id' => $_SESSION["user_id"]
    ]);
    
    // I-refresh ang pahina aron ma-update ang listahan
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM cart WHERE user_id = :user_id ORDER BY created_at DESC");
$stmt->bindValue(':user_id', $_SESSION["user_id"]);
$stmt->execute();
$items = $stmt->fetchAll(PDO::FETCH_ASSOC);

$total = 0;
foreach ($items as $item) {
    $total += $item['price'] * $item['quantity'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Your Cart — dm CAFE</title>
<link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;0,700&display=swap" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="../style.css?v=6">
</head>
<body>

<?php include __DIR__ . '/../sections/header.php'; ?>

<section class="wrap" style="padding:60px 32px; min-height:50vh;">
    <h1>Your Cart</h1>

    <?php if (isset($_SESSION['cart_message'])): ?>
        <p style="color:#1E7B34; background:#E6F4EA; padding:10px 14px; border-radius:4px; display:inline-block;">
            <?php echo htmlspecialchars($_SESSION['cart_message']); unset($_SESSION['cart_message']); ?>
        </p>
    <?php endif; ?>

    <?php if (empty($items)): ?>
        <p>Your cart is empty. <a href="../menu.php">Browse the menu</a>.</p>
    <?php else: ?>
        <table style="width:100%; border-collapse:collapse; margin-top:24px;">
            <thead>
                <tr style="text-align:left; border-bottom:2px solid var(--line);">
                    <th style="padding:10px 0;">Item</th>
                    <th>Price</th>
                    <th>Qty</th>
                    <th>Subtotal</th>
                    <th>Action</th> <!-- Bag-ong column heading -->
                </tr>
            </thead>
            <tbody>
                <?php foreach ($items as $item): ?>
                    <tr style="border-bottom:1px solid var(--line);">
                        <td style="padding:10px 0;"><?php echo htmlspecialchars($item['product_name']); ?></td>
                        <td>₱<?php echo number_format($item['price'], 2); ?></td>
                        <td><?php echo $item['quantity']; ?></td>
                        <td>₱<?php echo number_format($item['price'] * $item['quantity'], 2); ?></td>
                        <td>
                            <!-- Delete button uban ang JavaScript confirmation -->
                            <a href="?remove=<?php echo $item['id']; ?>" onclick="return confirm('Are you sure you want to delete it?');" style="color:#d9534f; text-decoration:none; font-weight:600;">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <h3 style="margin-top:24px;">Total: ₱<?php echo number_format($total, 2); ?></h3>
        <a href="checkout.php" class="btn btn-primary" style="margin-top:16px;">Proceed to Checkout</a>
    <?php endif; ?>
</section>

<?php include __DIR__ . '/../sections/footer.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>