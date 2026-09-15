<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once __DIR__ . '/../auth/database/config.php';

$pdo = getConnection();
$menu_items = $pdo->query("SELECT * FROM menu WHERE is_available = 1 ORDER BY category, name")->fetchAll(PDO::FETCH_ASSOC);
?>

<!-- ===== MENU / FLAVORS ===== -->
<section id="menu" class="py-5" style="background: var(--blush); padding-top:100px !important; padding-bottom:100px !important;">
  <div class="container">
    <div class="d-flex justify-content-between align-items-end mb-5 flex-wrap gap-3">
      <div>
        <p class="eyebrow">The Flavors</p>
        <h2 style="font-size:clamp(28px,3.4vw,36px);">Crafted with Intention</h2>
      </div>
      <a href="cart/view-cart.php" class="text-dark" style="font-size: 1.6rem; text-decoration: none;">
  <i class="bi bi-cart3"></i>
</a>
    </div>

    <?php if (isset($_SESSION['cart_message'])): ?>
      <div class="alert alert-success text-center">
        <?= htmlspecialchars($_SESSION['cart_message']) ?>
      </div>
      <?php unset($_SESSION['cart_message']); ?>
    <?php endif; ?>

    <div class="row g-4">
      <?php if (empty($menu_items)): ?>
        <p class="text-center">Wala pay available nga menu items karon.</p>
      <?php else: ?>
        <?php foreach ($menu_items as $item): ?>
          <div class="col-md-6 col-lg-3">
            <article class="card h-100 border-0 menu-card-hover" style="background: var(--coffee-70); border-radius:6px; overflow:hidden;">
              <div class="menu-photo-wrap">
                <img src="<?= htmlspecialchars($item['image']) ?>" alt="<?= htmlspecialchars($item['name']) ?>" class="card-img-top" style="height:170px; object-fit:cover;">
              </div>
              <div class="card-body d-flex flex-column">
                <div class="d-flex justify-content-between align-items-baseline mb-2">
                  <h3 class="h5 mb-0 text-white"><?= htmlspecialchars($item['name']) ?></h3>
                  <span class="text-white fw-semibold" style="font-family: var(--serif);">₱<?= number_format($item['price'], 2) ?></span>
                </div>
                <p class="small" style="color: rgba(255,255,255,0.85);"><?= htmlspecialchars($item['description']) ?></p>
                <form method="POST" action="cart/add_to_cart.php" class="d-flex align-items-center gap-2 mt-auto">
                  <input type="hidden" name="product_id" value="<?= (int)$item['id'] ?>">
                  <input type="hidden" name="product_name" value="<?= htmlspecialchars($item['name']) ?>">
                  <input type="hidden" name="price" value="<?= $item['price'] ?>">
                  <input type="number" name="quantity" value="1" min="1" max="20" class="form-control form-control-sm add-cart-qty" style="width:56px;">
                  <button type="submit" class="btn btn-brand-primary btn-sm add-cart-btn">Add to Cart</button>
                </form>
              </div>
            </article>
          </div>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>
  </div>
</section>