<?php
require 'header.php';
session_start();
if (!isset($_SESSION['user'])) {
  header('Location: index.php'); exit;
}

$id = intval($_GET['id'] ?? 0);
$data = json_decode(file_get_contents('users.json'), true);
$index = null;
foreach ($data as $i => $u) {
  if ($u['id'] === $id) { $index = $i; break; }
}
if ($index === null) {
  die('المستخدم غير موجود');
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $data[$index]['username'] = $_POST['username'];
  $data[$index]['email']    = $_POST['email'];
  if (!empty($_POST['password'])) {
    $data[$index]['password'] = $_POST['password'];
  }

  // تحديث الصورة إن تم رفعها
  if (!empty($_FILES['avatar']['name'])) {
    $ext = pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION);
    $avatar = 'uploads/' . uniqid('u'.$id.'_') . '.' . $ext;
    move_uploaded_file($_FILES['avatar']['tmp_name'], $avatar);
    // إزالة القديمة (اختياري)
    if ($data[$index]['avatar'] && file_exists($data[$index]['avatar'])) {
      unlink($data[$index]['avatar']);
    }
    $data[$index]['avatar'] = $avatar;
  }

  file_put_contents('users.json', json_encode($data, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE));
  header('Location: dashboard.php');
  exit;
}

$user = $data[$index];
?>
<!DOCTYPE html>
<html lang="ar">
<head>
  <meta charset="UTF-8">
  <title>تعديل المستخدم</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
  <h1>تعديل المستخدم #<?php echo $id; ?></h1>
  <form method="post" enctype="multipart/form-data">
    <label>اسم المستخدم</label>
    <input type="text" name="username" value="<?php echo htmlentities($user['username']); ?>" required>
    <label>البريد الإلكتروني</label>
    <input type="email" name="email" value="<?php echo htmlentities($user['email']); ?>" required>
    <label>كلمة المرور (اتركه فارغًا إذا لم ترغب بالتغيير)</label>
    <input type="password" name="password">
    <label>تغيير صورة الملف الشخصي</label><br>
    <?php if ($user['avatar'] && file_exists($user['avatar'])): ?>
      <img class="avatar" src="<?php echo $user['avatar']; ?>" alt="">
    <?php endif; ?><br>
    <input type="file" name="avatar" accept="image/*">
    <button type="submit">تحديث</button>
  </form>
  <?php require 'footer.php';?>
  <nav><a href="dashboard.php">« الرجوع للوحة التحكم</a></nav>
</div>
</body>
</html>
