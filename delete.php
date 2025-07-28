<?php
require 'header.php';
session_start();
if (!isset($_SESSION['user'])) {
  header('Location: index.php'); exit;
}

$id = intval($_GET['id'] ?? 0);
$data = json_decode(file_get_contents('users.json'), true);
foreach ($data as $i => $u) {
  if ($u['id'] === $id) {
    if ($u['avatar'] && file_exists($u['avatar'])) {
      unlink($u['avatar']);
    }
    array_splice($data, $i, 1);
    file_put_contents('users.json', json_encode($data, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE));
    break;
  }
}
header('Location: dashboard.php');
require 'footer.php';
exit;
