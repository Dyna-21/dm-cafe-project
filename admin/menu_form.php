<?php
require_once __DIR__ . '/admin_auth.php';

$is_edit = isset($_GET['id']);
$item = [
    'id' => '', 'name' => '', 'description' => '', 'price' => '',
    'image' => '', 'category' => 'coffee', 'is_available' => 1,
];
$errors = [];

if ($is_edit) {
    $stmt = $pdo->prepare("SELECT * FROM menu WHERE id = :id");
    $stmt->bindValue(':id', $_GET['id']);
    $stmt->execute();
    $found = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($found) {
        $item = $found;
    } else {
        header('Location: menu.php');
        exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $item['name']        = trim($_POST['name'] ?? '');
    $item['description'] = trim($_POST['description'] ?? '');
    $item['price']        = $_POST['price'] ?? '';
    $item['image']        = trim($_POST['image'] ?? '');
    $item['category']     = $_POST['category'] ?? 'coffee';
    $item['is_available'] = isset($_POST['is_available']) ? 1 : 0;
    $edit_id = $_POST['id'] ?? null;

    if ($item['name'] === '') $errors[] = "Product name is required.";
    if (!is_numeric($item['price']) || $item['price'] <= 0) $errors[] = "Enter a valid price.";
    if ($item['image'] === '') $errors[] = "Image path is required (e.g. assets/menu-item.png).";

    if (empty($errors)) {
        if ($edit_id) {
            // UPDATE
            $stmt = $pdo->prepare("UPDATE menu SET name=:name, description=:description, price=:price, image=:image, category=:category, is_available=:is_available WHERE id=:id");
            $stmt->bindValue(':id', $edit_id);
        } else {
            // INSERT
            $stmt = $pdo->prepare("INSERT INTO menu (name, description, price, image, category, is_available) VALUES (:name, :description, :price, :image, :category, :is_available)");
        }
        $stmt->bindValue(':name', $item['name']);
        $stmt->bindValue(':description', $item['description']);
        $stmt->bindValue(':price', $item['price']);
        $stmt->bindValue(':image', $item['image']);
        $stmt->bindValue(':category', $item['category']);
        $stmt->bindValue(':is_available', $item['is_available']);
        $stmt->execute();

        $_SESSION['admin_message'] = $edit_id ? "Menu item updated." : "Menu item added.";
        header('Location: menu.php');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= $is_edit ? 'Edit' : 'Add' ?> Menu Item — dm CAFE Admin</title>
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="../style.css">
</head>
<body>

<div class="d-flex">
  <?php include __DIR__ . '/includes/sidebar.php'; ?>

  <div class="flex-grow-1 p-4" style="background:#f8f5f1; min-height:100vh;">
    <h1 class="h3 mb-4"><?= $is_edit ? 'Edit' : 'Add New' ?> Menu Item</h1>

    <?php if (!empty($errors)): ?>
      <div class="alert alert-danger">
        <ul class="mb-0 ps-3">
          <?php foreach ($errors as $err): ?><li><?= htmlspecialchars($err) ?></li><?php endforeach; ?>
        </ul>
      </div>
    <?php endif; ?>

    <div class="card border-0 shadow-sm" style="max-width:600px;">
      <div class="card-body p-4">
        <form method="POST">
          <?php if ($is_edit): ?>
            <input type="hidden" name="id" value="<?= (int)$item['id'] ?>">
          <?php endif; ?>

          <div class="mb-3">
            <label class="form-label fw-semibold small">Product Name</label>
            <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($item['name']) ?>" required>
          </div>

          <div class="mb-3">
            <label class="form-label fw-semibold small">Description</label>
            <textarea name="description" class="form-control" rows="3"><?= htmlspecialchars($item['description']) ?></textarea>
          </div>

          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="form-label fw-semibold small">Price (₱)</label>
              <input type="number" step="0.01" min="0" name="price" class="form-control" value="<?= htmlspecialchars($item['price']) ?>" required>
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label fw-semibold small">Category</label>
              <select name="category" class="form-select">
                <option value="coffee" <?= $item['category'] === 'coffee' ? 'selected' : '' ?>>Coffee</option>
                <option value="pastry" <?= $item['category'] === 'pastry' ? 'selected' : '' ?>>Pastry</option>
                <option value="cold-drink" <?= $item['category'] === 'cold-drink' ? 'selected' : '' ?>>Cold Drink</option>
              </select>
            </div>
          </div>

          <div class="mb-3">
            <label class="form-label fw-semibold small">Image Path</label>
            <input type="text" name="image" class="form-control" placeholder="assets/menu-item.png" value="<?= htmlspecialchars($item['image']) ?>" required>
            <div class="form-text">I-type ang relative path sa image (e.g. assets/espresso.png). I-upload usa ang image sa assets folder.</div>
          </div>

          <div class="form-check mb-4">
            <input type="checkbox" name="is_available" id="is_available" class="form-check-input" <?= $item['is_available'] ? 'checked' : '' ?>>
            <label class="form-check-label small" for="is_available">Available (makita sa customer menu)</label>
          </div>

          <div class="d-flex gap-2">
            <button type="submit" class="btn btn-brand-primary px-4"><?= $is_edit ? 'Update' : 'Add' ?> Item</button>
            <a href="menu.php" class="btn btn-outline-dark px-4">Cancel</a>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

</body>
</html>