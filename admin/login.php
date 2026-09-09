<?php
require_once __DIR__ . '/../auth/database/config.php';
if (session_status() === PHP_SESSION_NONE) session_start();

// Kung admin naka-login na, diretso sa dashboard
if (isset($_SESSION['user_id']) && isset($_SESSION['is_admin']) && $_SESSION['is_admin'] === true) {
    header('Location: index.php');
    exit;
}

$errors = [];
$email = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email    = trim($_POST["email"] ?? '');
    $password = $_POST["password"] ?? '';

    if ($email === '') $errors[] = "Email is required.";
    if ($password === '') $errors[] = "Password is required.";

    if (empty($errors)) {
        $pdo = getConnection();
        $stmt = $pdo->prepare("SELECT id, full_name, password, role FROM users WHERE email = :email");
        $stmt->bindValue(':email', $email);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password']) && $user['role'] === 'admin') {
            $_SESSION['user_id']   = $user['id'];
            $_SESSION['user_name'] = $user['full_name'];
            $_SESSION['is_admin']  = true;
            header('Location: index.php');
            exit;
        } else {
            $errors[] = "Invalid admin credentials.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Log In — dm CAFE</title>
<link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;0,700&display=swap" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="../style.css">
<link rel="stylesheet" href="../auth/auth.css">
</head>
<body class="auth-page d-flex align-items-center justify-content-center min-vh-100" style="background: var(--espresso-black, #000);">

<div class="auth-card card shadow-lg border-0 p-4 p-md-5 text-center">
  <h1 class="h3 mb-1">Admin Login</h1>
  <p class="auth-sub text-muted mb-4">dm CAFE Admin Panel</p>

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
    <button type="submit" class="btn btn-brand-primary w-100 mt-2 py-2">Log In</button>
  </form>

  <p class="mt-4 small"><a href="../index.php">&larr; Back to site</a></p>
</div>

</body>
</html>