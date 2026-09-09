<?php
require __DIR__ . '/database/config.php';
if (session_status() === PHP_SESSION_NONE) session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>My Account — dm CAFE</title>
<link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;0,700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="../style.css">
<link rel="stylesheet" href="auth.css">
</head>
<body class="auth-page">

<div class="auth-card">
  <a href="../index.php" class="auth-logo">
    <img src="../assets/dm-wordmark-black1.png" alt="dm CAFE" class="brand-logo-img">
  </a>
  <h1>Welcome, <?php echo htmlspecialchars($_SESSION["user_name"]); ?>!</h1>
  <p class="auth-sub">You're logged in. Ordering online is coming soon.</p>
  <a href="logout.php" class="btn btn-outline auth-submit">Log Out</a>
</div>

</body>
</html>