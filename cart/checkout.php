<?php
require __DIR__ . '/../auth/database/config.php';
if (session_status() === PHP_SESSION_NONE) session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: ../auth/login.php");
    exit;
}

$user_id = $_SESSION["user_id"];
$pdo = getConnection();

$stmt = $pdo->prepare("SELECT * FROM cart WHERE user_id = :user_id");
$stmt->bindValue(':user_id', $user_id);
$stmt->execute();
$cart_items = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (empty($cart_items)) {
    header("Location: view-cart.php");
    exit;
}

$total = 0;
foreach ($cart_items as $item) {
    $total += $item['price'] * $item['quantity'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Checkout — dm CAFE</title>
<link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400&display=swap" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="../style.css?v=6">
</head>
<body>

<?php include __DIR__ . '/../sections/header.php'; ?>

<section class="py-5">
  <div class="container" style="max-width:720px;">
    <h1 class="mb-4" style="font-size:clamp(28px,3.4vw,36px);">Checkout</h1>

    <?php if (isset($_SESSION['checkout_message'])): ?>
      <div class="alert alert-danger">
        <?= htmlspecialchars($_SESSION['checkout_message']) ?>
      </div>
      <?php unset($_SESSION['checkout_message']); ?>
    <?php endif; ?>

    <div class="table-responsive mb-4">
      <table class="table align-middle">
        <thead>
          <tr>
            <th>Item</th>
            <th>Price</th>
            <th>Qty</th>
            <th>Subtotal</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($cart_items as $item): ?>
            <tr>
              <td><?= htmlspecialchars($item['product_name']) ?></td>
              <td>₱<?= number_format($item['price'], 2) ?></td>
              <td><?= (int)$item['quantity'] ?></td>
              <td>₱<?= number_format($item['price'] * $item['quantity'], 2) ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>

    <h3 class="mb-4">Total: ₱<?= number_format($total, 2) ?></h3>

    <div class="p-3 mb-4" style="background: var(--blush); border-radius:6px;">
      <p class="mb-1"><strong>Payment Method:</strong> Cash on Pickup</p>
      <p class="mb-0 small text-muted">Please pay in cash when you pick up your order at the store.</p>
    </div>

    <form method="POST" action="place_order.php">
      <button type="submit" class="btn btn-brand-primary px-4">Confirm Order</button>
      <a href="view-cart.php" class="btn btn-outline-dark px-4">Back to Cart</a>
    </form>
  </div>
</section>

<?php include __DIR__ . '/../sections/footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>