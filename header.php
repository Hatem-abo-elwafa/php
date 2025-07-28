<?php
// بدء الجلسة لضبط حالة الدخول
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="ar">
<head>
  <meta charset="UTF-8">
  <title>My App</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
<header>
  <div class="navbar container">
    <div class="logo">
      <a href="dashboard.php">MyApp</a>
    </div>
    <nav>
      <ul>
        <?php if (isset($_SESSION['user'])): ?>
          <li><a href="dashboard.php">لوحة التحكم</a></li>
          <li><a href="create.php">إنشاء مستخدم</a></li>
          <li><a href="about.php">عن الموقع</a></li>
          <li><a href="logout.php" class="btn-logout">تسجيل خروج</a></li>
        <?php else: ?>
          <li><a href="index.php">تسجيل دخول</a></li>
          <li><a href="register.php">تسجيل جديد</a></li>
          <li><a href="about.php">عن الموقع</a></li>
        <?php endif; ?>
      </ul>
    </nav>
  </div>
</header>
<main class="container">
