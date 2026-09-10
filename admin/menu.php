<?php
require_once __DIR__ . '/admin_auth.php';

if (isset($_SESSION['admin_message'])) {
    $admin_message = $_SESSION['admin_message'];
    unset($_SESSION['admin_message']);
}

$menu_items = $pdo->query("SELECT * FROM menu ORDER BY category, name")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Menu Management — dm CAFE Admin</title>
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="../style.css">
</head>
<body>

<div class="d-flex">
  <?php include __DIR__ . '/includes/sidebar.php'; ?>

  <div class="flex-grow-1 p-4" style="background: var(--cream); min-height:100vh;">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h1 class="h3 mb-0">Menu Management</h1>
      <a href="menu_form.php" class="btn btn-brand-primary">+ Add New Item</a>
    </div>

    <?php if (isset($admin_message)): ?>
      <div class="alert alert-success"><?= htmlspecialchars($admin_message) ?></div>
    <?php endif; ?>

    <div class="card border-0 shadow-sm">
      <div class="card-body">
        <div class="table-responsive">
          <table class="table align-middle">
            <thead>
              <tr>
                <th>Image</th>
                <th>Name</th>
                <th>Category</th>
                <th>Price</th>
                <th>Status</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <?php if (empty($menu_items)): ?>
                <tr><td colspan="6" class="text-center text-muted">Wala pay menu items.</td></tr>
              <?php else: ?>
                <?php foreach ($menu_items as $item): ?>
                  <tr>
                    <td>
                      <img src="../<?= htmlspecialchars($item['image']) ?>" alt="<?= htmlspecialchars($item['name']) ?>" style="width:50px; height:50px; object-fit:cover; border-radius:4px;">
                    </td>
                    <td><?= htmlspecialchars($item['name']) ?></td>
                    <td class="text-capitalize"><?= htmlspecialchars($item['category']) ?></td>
                    <td>₱<?= number_format($item['price'], 2) ?></td>
                    <td>
                      <?php if ($item['is_available']): ?>
                        <span class="badge bg-success">Available</span>
                      <?php else: ?>
                        <span class="badge bg-secondary">Hidden</span>
                      <?php endif; ?>
                    </td>
                    <td>
                      <a href="menu_form.php?id=<?= (int)$item['id'] ?>" class="btn btn-sm btn-outline-dark">Edit</a>
                      <form method="POST" action="delete_menu.php" class="d-inline" onsubmit="return confirm('Sigurado ka nga i-delete ang <?= htmlspecialchars(addslashes($item['name'])) ?>?');">
                        <input type="hidden" name="id" value="<?= (int)$item['id'] ?>">
                        <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
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