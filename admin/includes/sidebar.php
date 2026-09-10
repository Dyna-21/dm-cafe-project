<?php $current = basename($_SERVER['PHP_SELF']); ?>
<div class="d-flex flex-column flex-shrink-0 p-3 text-white" style="width:240px; min-height:100vh; background: var(--espresso-black);">
  <a href="index.php" class="d-flex align-items-center mb-4 text-white text-decoration-none">
    <span class="fs-5 fw-semibold">dm CAFE Admin</span>
  </a>
  <ul class="nav nav-pills flex-column mb-auto gap-1">
    <li class="nav-item">
      <a href="index.php" class="nav-link text-white <?= $current === 'index.php' ? 'active' : '' ?>" style="<?= $current === 'index.php' ? 'background: var(--terracotta);' : '' ?>">
        Dashboard
      </a>
    </li>
    <li class="nav-item">
      <a href="orders.php" class="nav-link text-white <?= $current === 'orders.php' ? 'active' : '' ?>" style="<?= $current === 'orders.php' ? 'background: var(--terracotta);' : '' ?>">
        Orders
      </a>
    </li>
    <li class="nav-item">
      <a href="menu.php" class="nav-link text-white <?= in_array($current, ['menu.php', 'menu_form.php']) ? 'active' : '' ?>" style="<?= in_array($current, ['menu.php', 'menu_form.php']) ? 'background: var(--terracotta);' : '' ?>">
        Menu
      </a>
    </li>
    <li class="nav-item">
      <a href="inventory.php" class="nav-link text-white <?= $current === 'inventory.php' ? 'active' : '' ?>" style="<?= $current === 'inventory.php' ? 'background: var(--terracotta);' : '' ?>">
        Inventory
      </a>
    </li>
    <li class="nav-item">
      <a href="customers.php" class="nav-link text-white <?= $current === 'customers.php' ? 'active' : '' ?>" style="<?= $current === 'customers.php' ? 'background: var(--terracotta);' : '' ?>">
        Customers
      </a>
    </li>
  </ul>
  <hr>
  <a href="../auth/logout.php" class="text-white text-decoration-none small">Log Out</a>
</div>