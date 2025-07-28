<?php 
require 'header.php';
session_start(); ?>
<!DOCTYPE html>
<html lang="ar">
<head>
  <meta charset="UTF-8">
  <title>عن الموقع</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
  <h1>عن الموقع</h1>
  <p>هذا تطبيق تجريبي لإدارة المستخدمين باستخدام PHP و JSON فقط.</p>
  <nav>
    <?php if (isset($_SESSION['user'])): ?>
      <a href="dashboard.php">العودة للوحة التحكم</a> |
      <a href="logout.php">تسجيل خروج</a>
    <?php else: ?>
      <a href="index.php">تسجيل دخول</a>
    <?php endif; ?>
  </nav>
  <?php require 'footer.php'; ?>
</div>
</body>
</html>
