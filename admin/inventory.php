<?php
require_once __DIR__ . '/admin_auth.php';

if (isset($_SESSION['admin_message'])) {
    $admin_message = $_SESSION['admin_message'];
    unset($_SESSION['admin_message']);
}

$LOW_STOCK_THRESHOLD = 10;

$products = $pdo->query("SELECT * FROM menu ORDER BY stock ASC, name ASC")->fetchAll(PDO::FETCH_ASSOC);

$total_products = count($products);
$low_stock_count = 0;
$out_of_stock_count = 0;
foreach ($products as $p) {
    if ($p['stock'] == 0) $out_of_stock_count++;
    elseif ($p['stock'] <= $LOW_STOCK_THRESHOLD) $low_stock_count++;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Inventory — dm CAFE Admin</title>
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="../style.css">
</head>
<body>

<div class="d-flex">
  <?php include __DIR__ . '/includes/sidebar.php'; ?>

  <div class="flex-grow-1 p-4" style="background: var(--cream); min-height:100vh;">
    <h1 class="h3 mb-4">Inventory</h1>

    <?php if (isset($admin_message)): ?>
      <div class="alert alert-success"><?= htmlspecialchars($admin_message) ?></div>
    <?php endif; ?>

    <div class="row g-4 mb-4">
      <div class="col-md-4">
        <div class="card border-0 shadow-sm p-3">
          <p class="text-muted small mb-1">Total Products</p>
          <h3 class="mb-0"><?= $total_products ?></h3>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card border-0 shadow-sm p-3">
          <p class="text-muted small mb-1">Low Stock (&le; <?= $LOW_STOCK_THRESHOLD ?>)</p>
          <h3 class="mb-0 text-warning"><?= $low_stock_count ?></h3>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card border-0 shadow-sm p-3">
          <p class="text-muted small mb-1">Out of Stock</p>
          <h3 class="mb-0 text-danger"><?= $out_of_stock_count ?></h3>
        </div>
      </div>
    </div>

    <div class="card border-0 shadow-sm">
      <div class="card-body">
        <div class="table-responsive">
          <table class="table align-middle">
            <thead>
              <tr>
                <th>Image</th>
                <th>Product</th>
                <th>Category</th>
                <th>Current Stock</th>
                <th>Status</th>
                <th>Update Stock</th>
              </tr>
            </thead>
            <tbody>
              <?php if (empty($products)): ?>
                <tr><td colspan="6" class="text-center text-muted">Wala pay products.</td></tr>
              <?php else: ?>
                <?php foreach ($products as $p): ?>
                  <?php
                    if ($p['stock'] == 0) {
                        $badge = '<span class="badge bg-danger">Out of Stock</span>';
                    } elseif ($p['stock'] <= $LOW_STOCK_THRESHOLD) {
                        $badge = '<span class="badge bg-warning text-dark">Low Stock</span>';
                    } else {
                        $badge = '<span class="badge bg-success">In Stock</span>';
                    }
                  ?>
                  <tr>
                    <td>
                      <img src="../<?= htmlspecialchars($p['image']) ?>" alt="<?= htmlspecialchars($p['name']) ?>" style="width:44px; height:44px; object-fit:cover; border-radius:4px;">
                    </td>
                    <td><?= htmlspecialchars($p['name']) ?></td>
                    <td class="text-capitalize small text-muted"><?= htmlspecialchars($p['category']) ?></td>
                    <td class="fw-semibold"><?= (int)$p['stock'] ?></td>
                    <td><?= $badge ?></td>
                    <td>
                      <form method="POST" action="update_stock.php" class="d-flex gap-2">
                        <input type="hidden" name="id" value="<?= (int)$p['id'] ?>">
                        <input type="number" name="stock" min="0" value="<?= (int)$p['stock'] ?>" class="form-control form-control-sm" style="width:80px;">
                        <button type="submit" class="btn btn-sm btn-brand-primary">Save</button>
                      </form>
                    </td>
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

</body>
</html>