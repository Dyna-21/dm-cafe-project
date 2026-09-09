<?php
require __DIR__ . '/functions.php';
if (session_status() === PHP_SESSION_NONE) session_start();

$errors = [];
$success = "";
$full_name = $email = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $full_name = sanitizeInput($_POST["full_name"]);
    $email     = sanitizeInput($_POST["email"]);
    $password  = $_POST["password"];
    $confirm   = $_POST["confirm_password"];

    $errors = validateRegisterInput($full_name, $email, $password, $confirm);

    if (empty($errors) && emailExists($email)) {
        $errors[] = "That email is already registered.";
    }

    if (empty($errors)) {
        if (registerUser($full_name, $email, $password)) {
            $success = "Account created! You can now log in.";
        } else {
            $errors[] = "Something went wrong. Please try again.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Register — dm CAFE</title>
<link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;0,700&display=swap" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="../style.css">
<link rel="stylesheet" href="auth.css">
</head>
<body class="auth-page d-flex align-items-center justify-content-center min-vh-100">

<div class="auth-card card shadow-lg border-0 p-4 p-md-5 text-center">
  <a href="../index.php" class="auth-logo d-inline-flex mx-auto mb-3">
    <img src="../assets/dm-wordmark-black1.png" alt="dm CAFE" class="brand-logo-img">
  </a>
  <h1 class="h3 mb-1">Create an Account</h1>
  <p class="auth-sub text-muted mb-4">Join dm CAFE to order online.</p>

  <?php if (!empty($errors)): ?>
    <div class="alert alert-danger text-start">
      <ul class="mb-0 ps-3">
        <?php foreach ($errors as $err): ?>
          <li><?php echo htmlspecialchars($err); ?></li>
        <?php endforeach; ?>
      </ul>
    </div>
  <?php endif; ?>

  <?php if ($success): ?>
    <div class="alert alert-success text-start"><?php echo htmlspecialchars($success); ?> <a href="login.php" class="alert-link">Log in here</a>.</div>
  <?php endif; ?>

  <?php if (!$success): ?>
  <form method="POST" action="register.php" class="text-start">
    <div class="mb-3">
      <label class="form-label fw-semibold small">Full Name</label>
      <input type="text" name="full_name" class="form-control" required value="<?php echo htmlspecialchars($full_name); ?>">
    </div>
    <div class="mb-3">
      <label class="form-label fw-semibold small">Email</label>
      <input type="email" name="email" class="form-control" required value="<?php echo htmlspecialchars($email); ?>">
    </div>
    <div class="mb-3">
      <label class="form-label fw-semibold small">Password</label>
      <input type="password" name="password" class="form-control" required minlength="6">
    </div>
    <div class="mb-3">
      <label class="form-label fw-semibold small">Confirm Password</label>
      <input type="password" name="confirm_password" class="form-control" required minlength="6">
    </div>
    <button type="submit" name="register" class="btn btn-brand-primary w-100 mt-2 py-2">Register</button>
  </form>
  <?php endif; ?>

  <p class="auth-switch mt-4 small">Already have an account? <a href="login.php">Log in</a></p>
</div>

</body>
</html>