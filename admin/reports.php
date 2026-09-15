<?php
require_once __DIR__ . '/admin_auth.php';

// Overall totals
$total_revenue = $pdo->query("SELECT COALESCE(SUM(total),0) FROM orders WHERE status != 'cancelled'")->fetchColumn();
$total_orders  = $pdo->query("SELECT COUNT(*) FROM orders WHERE status != 'cancelled'")->fetchColumn();

// Today
$today_revenue = $pdo->query("SELECT COALESCE(SUM(total),0) FROM orders WHERE status != 'cancelled' AND DATE(created_at) = CURDATE()")->fetchColumn();

// This week
$week_revenue = $pdo->query("SELECT COALESCE(SUM(total),0) FROM orders WHERE status != 'cancelled' AND YEARWEEK(created_at,1) = YEARWEEK(CURDATE(),1)")->fetchColumn();

// This month
$month_revenue = $pdo->query("SELECT COALESCE(SUM(total),0) FROM orders WHERE status != 'cancelled' AND YEAR(created_at)=YEAR(CURDATE()) AND MONTH(created_at)=MONTH(CURDATE())")->fetchColumn();

// Top selling products
$top_products = $pdo->query("
    SELECT product_name, SUM(quantity) AS total_qty, SUM(price * quantity) AS total_sales
    FROM order_items
    GROUP BY product_name
    ORDER BY total_qty DESC
    LIMIT 5
")->fetchAll(PDO::FETCH_ASSOC);

// Sales by day (last 7 days)
$sales_by_day = $pdo->query("
    SELECT DATE(created_at) AS order_date, COALESCE(SUM(total),0) AS daily_total
    FROM orders
    WHERE status != 'cancelled' AND created_at >= DATE_SUB(CURDATE(), INTERVAL 6 DAY)
    GROUP BY DATE(created_at)
    ORDER BY order_date ASC
")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Reports — dm CAFE Admin</title>
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="../style.css">
</head>
<body>

<div class="d-flex">
  <?php include __DIR__ . '/includes/sidebar.php'; ?>

  <div class="flex-grow-1 p-4" style="background: var(--cream); min-height:100vh;">
    <h1 class="h3 mb-4">Sales Reports</h1>

    <!-- Summary cards -->
    <div class="row g-4 mb-4">
      <div class="col-md-3">
        <div class="card border-0 shadow-sm p-3">
          <p class="text-muted small mb-1">Total Revenue</p>
          <h3 class="mb-0" style="color:var(--terracotta);">₱<?= number_format($total_revenue, 2) ?></h3>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card border-0 shadow-sm p-3">
          <p class="text-muted small mb-1">Today's Sales</p>
          <h3 class="mb-0">₱<?= number_format($today_revenue, 2) ?></h3>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card border-0 shadow-sm p-3">
          <p class="text-muted small mb-1">This Week</p>
          <h3 class="mb-0">₱<?= number_format($week_revenue, 2) ?></h3>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card border-0 shadow-sm p-3">
          <p class="text-muted small mb-1">This Month</p>
          <h3 class="mb-0">₱<?= number_format($month_revenue, 2) ?></h3>
        </div>
      </div>
    </div>

    <div class="row g-4">
      <!-- Top selling products -->
      <div class="col-lg-6">
        <div class="card border-0 shadow-sm">
          <div class="card-body">
            <h5 class="mb-3">Top Selling Products</h5>
            <table class="table align-middle">
              <thead>
                <tr>
                  <th>Product</th>
                  <th>Qty Sold</th>
                  <th>Total Sales</th>
                </tr>
              </thead>
              <tbody>
                <?php if (empty($top_products)): ?>
                  <tr><td colspan="3" class="text-center text-muted">Wala pay sales data.</td></tr>
                <?php else: ?>
                  <?php foreach ($top_products as $p): ?>
                    <tr>
                      <td><?= htmlspecialchars($p['product_name']) ?></td>
                      <td><?= (int)$p['total_qty'] ?></td>
                      <td>₱<?= number_format($p['total_sales'], 2) ?></td>
                    </tr>
                  <?php endforeach; ?>
                <?php endif; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <!-- Sales by day -->
      <div class="col-lg-6">
        <div class="card border-0 shadow-sm">
          <div class="card-body">
            <h5 class="mb-3">Sales — Last 7 Days</h5>
            <table class="table align-middle">
              <thead>
                <tr>
                  <th>Date</th>
                  <th>Total Sales</th>
                </tr>
              </thead>
              <tbody>
                <?php if (empty($sales_by_day)): ?>
                  <tr><td colspan="2" class="text-center text-muted">Wala pay sales data.</td></tr>
                <?php else: ?>
                  <?php foreach ($sales_by_day as $s): ?>
                    <tr>
                      <td><?= date('M d, Y', strtotime($s['order_date'])) ?></td>
                      <td>₱<?= number_format($s['daily_total'], 2) ?></td>
                    </tr>
                  <?php endforeach; ?>
                <?php endif; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

</body>
</html>