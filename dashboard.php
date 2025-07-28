<?php
require 'header.php';
session_start();
if (!isset($_SESSION['user'])) {
  header('Location: index.php');
  exit;
}

$users = json_decode(file_get_contents('users.json'), true);
?>
<!DOCTYPE html>
<html lang="ar">
<head>
  <meta charset="UTF-8">
  <title>لوحة التحكم</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
  <h1>لوحة التحكم</h1>
  <nav>
    مرحبًا، <?php echo $_SESSION['user']['username']; ?> |
    <a href="about.php">عن الموقع</a> |
    <a href="logout.php">تسجيل خروج</a>
  </nav>

  <a class="button" href="create.php">إنشاء مستخدم جديد</a>

  <table>
    <tr>
      <th>الرقم</th>
      <th>الاسم</th>
      <th>البريد</th>
      <th>الصورة</th>
      <th>إجراءات</th>
    </tr>
    <?php foreach ($users as $u): ?>
      <tr>
        <td><?php echo $u['id']; ?></td>
        <td><?php echo htmlentities($u['username']); ?></td>
        <td><?php echo htmlentities($u['email']); ?></td>
        <td>
          <?php if ($u['avatar'] && file_exists($u['avatar'])): ?>
            <img class="avatar" src="<?php echo $u['avatar']; ?>" alt="avatar">
          <?php endif; ?>
        </td>
        <td>
          <a class="button edit" href="edit.php?id=<?php echo $u['id']; ?>">تعديل</a>
          <a class="button danger" href="delete.php?id=<?php echo $u['id']; ?>"
             onclick="return confirm('هل أنت متأكد من الحذف؟');">حذف</a>
        </td>
      </tr>
    <?php endforeach; ?>
  </table>
  <?php
  require 'footer.php';?>
</div>
</body>
</html>
