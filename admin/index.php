<?php
require_once __DIR__ . '/admin_auth.php';

$total_orders   = $pdo->query("SELECT COUNT(*) FROM orders")->fetchColumn();
$pending_orders = $pdo->query("SELECT COUNT(*) FROM orders WHERE status = 'pending'")->fetchColumn();
$total_revenue  = $pdo->query("SELECT COALESCE(SUM(total),0) FROM orders WHERE status != 'cancelled'")->fetchColumn();
$total_customers = $pdo->query("SELECT COUNT(*) FROM users WHERE role = 'customer'")->fetchColumn();

$recent_orders = $pdo->query("
    SELECT o.id, o.total, o.status, o.created_at, u.full_name
    FROM orders o
    JOIN users u ON o.user_id = u.id
    ORDER BY o.created_at DESC
    LIMIT 5
")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Dashboard — dm CAFE</title>
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="../style.css">
</head>
<body>

<div class="d-flex">
  <?php include __DIR__ . '/includes/sidebar.php'; ?>

  <div class="flex-grow-1 p-4" style="background:#f8f5f1; min-height:100vh;">
    <h1 class="h3 mb-4">Dashboard</h1>

    <div class="row g-4 mb-4">
      <div class="col-md-3">
        <div class="card border-0 shadow-sm p-3">
          <p class="text-muted small mb-1">Total Orders</p>
          <h3 class="mb-0"><?= (int)$total_orders ?></h3>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card border-0 shadow-sm p-3">
          <p class="text-muted small mb-1">Pending Orders</p>
          <h3 class="mb-0 text-warning"><?= (int)$pending_orders ?></h3>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card border-0 shadow-sm p-3">
          <p class="text-muted small mb-1">Total Revenue</p>
          <h3 class="mb-0" style="color:var(--terracotta);">₱<?= number_format($total_revenue, 2) ?></h3>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card border-0 shadow-sm p-3">
          <p class="text-muted small mb-1">Total Customers</p>
          <h3 class="mb-0"><?= (int)$total_customers ?></h3>
        </div>
      </div>
    </div>

    <div class="card border-0 shadow-sm">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
          <h5 class="mb-0">Recent Orders</h5>
          <a href="orders.php" class="btn btn-sm btn-outline-dark">View All</a>
        </div>
        <table class="table align-middle">
          <thead>
            <tr>
              <th>Order #</th>
              <th>Customer</th>
              <th>Total</th>
              <th>Status</th>
              <th>Date</th>
            </tr>
          </thead>
          <tbody>
            <?php if (empty($recent_orders)): ?>
              <tr><td colspan="5" class="text-center text-muted">Wala pay orders.</td></tr>
            <?php else: ?>
              <?php foreach ($recent_orders as $o): ?>
                <tr>
                  <td>#<?= (int)$o['id'] ?></td>
                  <td><?= htmlspecialchars($o['full_name']) ?></td>
                  <td>₱<?= number_format($o['total'], 2) ?></td>
                  <td><span class="badge bg-secondary text-capitalize"><?= htmlspecialchars($o['status']) ?></span></td>
                  <td><?= date('M d, Y', strtotime($o['created_at'])) ?></td>
                </tr>
              <?php endforeach; ?>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

</body>
</html>