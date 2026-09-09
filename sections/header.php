<?php


if (session_status() === PHP_SESSION_NONE) session_start();
$current = basename($_SERVER['PHP_SELF']);

// Tan-awon kung naa ba sa sulod sa 'cart' folder
$is_in_cart = (basename(dirname($_SERVER['PHP_SELF'])) == 'cart');
$path = $is_in_cart ? '../' : '';
?>
<!-- ===== HEADER ===== -->
<nav class="navbar navbar-expand-lg navbar-light sticky-top py-3" style="background-color: rgba(248,242,231,.92); backdrop-filter: blur(8px);">
  <!-- Gi-ilisdan ang container og container-fluid ug gihatagan og parehong padding/margin sa imong wrap -->
  <div class="container-fluid px-4 px-md-5">
    <a href="<?php echo $path; ?>index.php" class="navbar-brand d-flex align-items-center gap-2 m-0">
      <img src="<?php echo $path; ?>assets/dm-wordmark-black1.png" alt="dm CAFE" style="height:52px; width:auto;">
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
        <div class="d-flex gap-2">
          <a href="<?php echo $path; ?>admin/login.php" class="btn btn-outline-dark btn-sm px-3">Admin</a>
          <a href="<?php echo $path; ?>auth/logout.php" class="btn btn-brand-primary btn-sm px-3">Log Out</a>
        </div>
      <?php else: ?>
        <div class="d-flex gap-2">
          <a href="<?php echo $path; ?>admin/login.php" class="btn btn-outline-dark btn-sm px-3">Admin</a>
          <a href="<?php echo $path; ?>auth/login.php" class="btn btn-brand-primary btn-sm px-3">Buy Online</a>
        </div>
      <?php endif; ?>
    </div>
  </div>
</nav>