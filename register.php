<?php
require 'header.php';
session_start();
// إذا كان المستخدم مسجلاً بالفعل، نرسلُه للوحة التحكم
if (isset($_SESSION['user'])) {
  header('Location: dashboard.php');
  exit;
}

$error = '';
$success = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // قراءة بيانات المستخدمين المسجلين
  $users = json_decode(file_get_contents('users.json'), true);

  $username = trim($_POST['username']);
  $email    = trim($_POST['email']);
  $password = $_POST['password'];
  $avatar   = '';

  // تحقق من عدم وجود اسم المستخدم أو البريد مسبقًا
  foreach ($users as $u) {
    if ($u['username'] === $username) {
      $error = 'اسم المستخدم هذا مُستخدم بالفعل.';
      break;
    }
    if ($u['email'] === $email) {
      $error = 'هذا البريد الإلكتروني مُسجّل بالفعل.';
      break;
    }
  }

  if (!$error) {
    // رقم ID جديد
    $newId = empty($users) ? 1 : end($users)['id'] + 1;

    // معالجة رفع الصورة (اختياري)
    if (!empty($_FILES['avatar']['name'])) {
      $ext = pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION);
      $avatar = 'uploads/' . uniqid('u'.$newId.'_') . '.' . $ext;
      if (!move_uploaded_file($_FILES['avatar']['tmp_name'], $avatar)) {
        $avatar = ''; // إذا فشل الرفع
      }
    }

    // إضافة المستخدم الجديد
    $users[] = [
      'id'       => $newId,
      'username' => $username,
      'email'    => $email,
      'password' => $password,
      'avatar'   => $avatar
    ];

    // حفظ في JSON
    file_put_contents('users.json', json_encode($users, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE));
    $success = 'تمّ التسجيل بنجاح! يمكنك الآن تسجيل الدخول.';
  }
}
?>
<!DOCTYPE html>
<html lang="ar">
<head>
  <meta charset="UTF-8">
  <title>تسجيل مستخدم جديد</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
  <h1>تسجيل مستخدم جديد</h1>

  <?php if ($error): ?>
    <p style="color:red;"><?php echo $error; ?></p>
  <?php elseif ($success): ?>
    <p style="color:green;"><?php echo $success; ?></p>
  <?php endif; ?>

  <form method="post" enctype="multipart/form-data">
    <label>اسم المستخدم</label>
    <input type="text" name="username" required>

    <label>البريد الإلكتروني</label>
    <input type="email" name="email" required>

    <label>كلمة المرور</label>
    <input type="password" name="password" required>

    <label>اختياري: صورة الملف الشخصي</label>
    <input type="file" name="avatar" accept="image/*">

    <button type="submit">تسجيل</button>
  </form>
<?php
require 'footer.php';?>
  <nav>
    <a href="index.php">لديك حساب؟ تسجيل الدخول</a> |
    <a href="about.php">عن الموقع</a>
  </nav>
</div>
</body>
</html>
