<?php
if (session_status() === PHP_SESSION_NONE) session_start();

if (!isset($_SESSION['order_success'])) {
    header("Location: ../menu.php");
    exit;
}

$order_id = $_SESSION['order_success'];
unset($_SESSION['order_success']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Order Confirmed — dm CAFE</title>
<link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400&display=swap" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="../style.css?v=6">
</head>
<body>

<?php include __DIR__ . '/../sections/header.php'; ?>

<section class="py-5 text-center">
  <div class="container" style="max-width:600px;">
    <h1 class="mb-3">Order Confirmed! 🎉</h1>
    <p class="mb-1">Your order #<?= (int)$order_id ?> has been placed.</p>
    <p class="text-muted mb-4">Please pay in cash when you pick up your order at the store.</p>
    <a href="../menu.php" class="btn btn-brand-primary px-4">Back to Menu</a>
  </div>
</section>

<?php include __DIR__ . '/../sections/footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>