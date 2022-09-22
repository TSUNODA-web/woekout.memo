<?php
session_start();
require('library.php');

if (isset($_SESSION['id']) && isset($_SESSION['name'])) {
  $id = $_SESSION['id'];
  $name = $_SESSION['name'];
} else {
  header('Location: login.php');
  exit();
}

$memo_id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
if (!$id) {
  header('Location: index.php');
  exit();
}

$db = dbconnect();
$stmt = $db->prepare('delete from posts where id=? and member_id=? limit 1');
if (!$stmt) {
  die($db->error);
}
$stmt->bind_param('ii', $memo_id, $id);
$success = $stmt->execute();
if (!$success) {
  die($db->error);
}

?>


<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="reset.css" />
  <link rel="stylesheet" href="style.css" />

  <title>削除</title>
</head>

<body>
  <header>
    <h1><a href="">筋トレメモ</a></h1>
    <ul class="nav-list">
      <li class="nav-list-item">
        <a href="mypage.php">マイページ</a></a>
      </li>
      <li class="nav-list-item">
        <a href="logout.php">ログアウト</a>
      </li>
    </ul>
  </header>
  <div class="content">
    <h1>削除しました</h1>
    <a href="index.php" class="button">戻る</a>

  </div>
</body>

</html>
