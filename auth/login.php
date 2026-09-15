
<?php
require __DIR__ . '/functions.php';
if (session_status() === PHP_SESSION_NONE) session_start();

$errors = [];
$email = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email    = sanitizeInput($_POST["email"]);
    $password = $_POST["password"];

    if ($e = validateRequired($email, "Email")) $errors[] = $e;
    if ($e = validateRequired($password, "Password")) $errors[] = $e;

    if (empty($errors)) {
        $user = findUserByEmail($email);
        if ($user && password_verify($password, $user["password"])) {
            $_SESSION["user_id"]   = $user["id"];
            $_SESSION["user_name"] = $user["full_name"];

            // I-check kung admin ba o customer, unya i-redirect sa tarong nga lugar
            if (isset($user["role"]) && $user["role"] === "admin") {
                $_SESSION["is_admin"] = true;
                header("Location: ../admin/index.php");
            } else {
                header("Location: ../index.php");
            }
            exit;
        } else {
            $errors[] = "Incorrect email or password.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Log In — dm CAFE</title>
<link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;0,700&display=swap" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="../style.css">
<link rel="stylesheet" href="auth.css">
</head>
<body class="auth-page d-flex align-items-center justify-content-center min-vh-100">

<div class="auth-card card shadow-lg border-0 p-4 p-md-5 text-center">
  <a href="../index.php" class="auth-logo d-inline-flex mx-auto mb-3">
    <img src="../assets/dm-logo-circle.png" alt="dm CAFE" style="height:70px; width:70px; object-fit:contain;">
  </a>
  <h1 class="h3 mb-1">Welcome Back</h1>
  <p class="auth-sub text-muted mb-4">Log in to order from dm CAFE.</p>

  <?php if (!empty($errors)): ?>
    <div class="alert alert-danger text-start">
      <ul class="mb-0 ps-3">
        <?php foreach ($errors as $err): ?>
          <li><?php echo htmlspecialchars($err); ?></li>
        <?php endforeach; ?>
      </ul>
    </div>
  <?php endif; ?>

  <form method="POST" action="login.php" class="text-start">
    <div class="mb-3">
      <label class="form-label fw-semibold small">Email</label>
      <input type="email" name="email" class="form-control" required value="<?php echo htmlspecialchars($email); ?>">
    </div>
    <div class="mb-3">
      <label class="form-label fw-semibold small">Password</label>
      <input type="password" name="password" class="form-control" required>
    </div>
    <button type="submit" name="login" class="btn btn-brand-primary w-100 mt-2 py-2">Log In</button>
  </form>

  <p class="auth-switch mt-4 small">Don't have an account? <a href="register.php">Register</a></p>
</div>
</body>
</html>
