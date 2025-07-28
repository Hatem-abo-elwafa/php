<?php
require 'header.php';
session_start();
if (isset($_SESSION['user'])) {
  header('Location: dashboard.php');
  exit;
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $data = json_decode(file_get_contents('users.json'), true);
  $username = $_POST['username'] ?? '';
  $password = $_POST['password'] ?? '';

  foreach ($data as $user) {
    if ($user['username'] === $username && $user['password'] === $password) {
      // مصادقة ناجحة
      $_SESSION['user'] = [
        'id'       => $user['id'],
        'username' => $user['username'],
        'email'    => $user['email'],
        'avatar'   => $user['avatar']
      ];
      header('Location: dashboard.php');
      exit;
    }
  }
  $error = 'اسم المستخدم أو كلمة المرور غير صحيحة.';
}
?>
<!DOCTYPE html>
<html lang="ar">
<head>
  <meta charset="UTF-8">
  <title>تسجيل الدخول</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
  <h1>تسجيل الدخول</h1>
  <?php if ($error): ?>
    <p style="color:red;"><?php echo $error; ?></p>
  <?php endif; ?>
  <form method="post">
    <label>اسم المستخدم</label>
    <input type="text" name="username" required>
    <label>كلمة المرور</label>
    <input type="password" name="password" required>
    <button type="submit">دخول</button>
  </form>
  <?php require 'footer.php'; ?>
<nav>
  <a href="about.php">عن الموقع</a> |
  <a href="register.php">تسجيل جديد</a>
</nav>
</div>
</body>
</html>
