<?php


if (session_status() === PHP_SESSION_NONE) session_start();
$current = basename($_SERVER['PHP_SELF']);

// Tan-awon kung naa ba sa sulod sa 'cart' folder
$is_in_cart = (basename(dirname($_SERVER['PHP_SELF'])) == 'cart');
$path = $is_in_cart ? '../' : '';
?>
<!-- ===== HEADER ===== -->
<nav class="navbar navbar-expand-lg navbar-light sticky-top py-2" style="background-color: #f0e4d3; backdrop-filter: blur(8px);">

  <div class="container-fluid px-4 px-md-5">
    <a href="<?php echo $path; ?>index.php" class="navbar-brand d-flex align-items-center gap-2 m-0">
      <img src="<?php echo $path; ?>assets/dm-logo-circle.png" alt="dm CAFE" style="height:70px; width:70px; object-fit:contain;">
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="mainNav">
      <ul class="navbar-nav mx-auto gap-lg-4">
        <li class="nav-item"><a href="<?php echo $path; ?>index.php" class="nav-link <?php echo $current === 'index.php' ? 'active-link' : ''; ?>">Home</a></li>
        <li class="nav-item"><a href="<?php echo $path; ?>our-story.php" class="nav-link <?php echo $current === 'our-story.php' ? 'active-link' : ''; ?>">Our Story</a></li>
        <li class="nav-item"><a href="<?php echo $path; ?>menu.php" class="nav-link <?php echo $current === 'menu.php' ? 'active-link' : ''; ?>">Menu</a></li>
        <li class="nav-item"><a href="<?php echo $path; ?>gallery.php" class="nav-link <?php echo $current === 'gallery.php' ? 'active-link' : ''; ?>">Gallery</a></li>
        <li class="nav-item"><a href="<?php echo $path; ?>find-us.php" class="nav-link <?php echo $current === 'find-us.php' ? 'active-link' : ''; ?>">Find Us</a></li>
      </ul>
      <?php if (isset($_SESSION['user_id'])): ?>
        <?php
          $full_name = $_SESSION['user_name'] ?? '';
          $first_name = trim(explode(' ', $full_name)[0]);
        ?>
        <span class="navbar-text fw-semibold me-2">Hi! <?php echo htmlspecialchars($first_name); ?></span>
        <a href="<?php echo $path; ?>auth/logout.php" class="btn btn-dark btn-sm px-3">Log Out</a>
      <?php else: ?>
        <a href="<?php echo $path; ?>auth/login.php" class="btn btn-dark btn-sm px-3">Log In</a>
      <?php endif; ?>
    </div>
  </div>
</nav>