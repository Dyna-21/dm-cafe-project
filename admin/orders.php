<?php
require_once __DIR__ . '/admin_auth.php';

if (isset($_SESSION['admin_message'])) {
    $admin_message = $_SESSION['admin_message'];
    unset($_SESSION['admin_message']);
}

$orders = $pdo->query("
    SELECT o.id, o.total, o.status, o.created_at, u.full_name, u.email
    FROM orders o
    JOIN users u ON o.user_id = u.id
    ORDER BY o.created_at DESC
")->fetchAll(PDO::FETCH_ASSOC);

$statuses = ['pending', 'preparing', 'ready', 'completed', 'cancelled'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Orders — dm CAFE Admin</title>
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="../style.css">
</head>
<body>

<div class="d-flex">
  <?php include __DIR__ . '/includes/sidebar.php'; ?>

  <div class="flex-grow-1 p-4" style="background:#f8f5f1; min-height:100vh;">
    <h1 class="h3 mb-4">Orders</h1>

    <?php if (isset($admin_message)): ?>
      <div class="alert alert-success"><?= htmlspecialchars($admin_message) ?></div>
    <?php endif; ?>

    <div class="card border-0 shadow-sm">
      <div class="card-body">
        <div class="table-responsive">
          <table class="table align-middle">
            <thead>
              <tr>
                <th>Order #</th>
                <th>Customer</th>
                <th>Email</th>
                <th>Total</th>
                <th>Status</th>
                <th>Date</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <?php if (empty($orders)): ?>
                <tr><td colspan="7" class="text-center text-muted">Wala pay orders.</td></tr>
              <?php else: ?>
                <?php foreach ($orders as $o): ?>
                  <tr>
                    <td>#<?= (int)$o['id'] ?></td>
                    <td><?= htmlspecialchars($o['full_name']) ?></td>
                    <td class="small text-muted"><?= htmlspecialchars($o['email']) ?></td>
                    <td>₱<?= number_format($o['total'], 2) ?></td>
                    <td>
                      <span class="badge
                        <?php
                          echo match($o['status']) {
                            'pending'   => 'bg-warning text-dark',
                            'preparing' => 'bg-info text-dark',
                            'ready'     => 'bg-primary',
                            'completed' => 'bg-success',
                            'cancelled' => 'bg-danger',
                            default     => 'bg-secondary',
                          };
                        ?> text-capitalize">
                        <?= htmlspecialchars($o['status']) ?>
                      </span>
                    </td>
                    <td class="small"><?= date('M d, Y g:i A', strtotime($o['created_at'])) ?></td>
                    <td>
                      <form method="POST" action="update_order_status.php" class="d-flex gap-2">
                        <input type="hidden" name="order_id" value="<?= (int)$o['id'] ?>">
                        <select name="status" class="form-select form-select-sm" style="width:130px;">
                          <?php foreach ($statuses as $s): ?>
                            <option value="<?= $s ?>" <?= $o['status'] === $s ? 'selected' : '' ?>><?= ucfirst($s) ?></option>
                          <?php endforeach; ?>
                        </select>
                        <button type="submit" class="btn btn-sm btn-brand-primary">Update</button>
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