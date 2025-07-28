<?php
require 'header.php';
session_start();
if (!isset($_SESSION['user'])) {
  header('Location: index.php'); exit;
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $data = json_decode(file_get_contents('users.json'), true);

  // إعداد بيانات المستخدم الجديد
  $newId = empty($data) ? 1 : end($data)['id'] + 1;
  $username = $_POST['username'];
  $email    = $_POST['email'];
  $password = $_POST['password'];
  $avatar   = '';

  // معالجة رفع الصورة
  if (!empty($_FILES['avatar']['name'])) {
    $ext = pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION);
    $avatar = 'uploads/' . uniqid('u'.$newId.'_') . '.' . $ext;
    move_uploaded_file($_FILES['avatar']['tmp_name'], $avatar);
  }

  // إضافة المستخدم إلى المصفوفة ثم حفظها
  $data[] = [
    'id'       => $newId,
    'username' => $username,
    'email'    => $email,
    'password' => $password,
    'avatar'   => $avatar
  ];
  file_put_contents('users.json', json_encode($data, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE));

  header('Location: dashboard.php');
  exit;
}
?>
<!DOCTYPE html>
<html lang="ar">
<head>
  <meta charset="UTF-8">
  <title>إنشاء مستخدم جديد</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
  <h1>إنشاء مستخدم جديد</h1>
  <?php if ($error): ?><p style="color:red;"><?php echo $error; ?></p><?php endif; ?>
  <form method="post" enctype="multipart/form-data">
    <label>اسم المستخدم</label>
    <input type="text" name="username" required>
    <label>البريد الإلكتروني</label>
    <input type="email" name="email" required>
    <label>كلمة المرور</label>
    <input type="password" name="password" required>
    <label>صورة الملف الشخصي</label>
    <input type="file" name="avatar" accept="image/*">
    <button type="submit">حفظ</button>
  </form>
  <?php
require 'footer.php';?>
  <nav><a href="dashboard.php">« الرجوع للوحة التحكم</a></nav>
</div>
</body>
</html>
