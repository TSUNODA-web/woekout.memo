<?php
session_start();
require('library.php');

if (isset($_SESSION['id']) && isset($_SESSION['name'])) {
  $id = $_SESSION['id'];
} else {
  header('Location: login.php');
  exit();
}
if (!isset($_POST["delete"])) {
  header('Location: login.php');
  exit();
}

$memo_id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
if (!$id) {
  header('Location: index.php');
  exit();
}

$db = dbconnect2();
try {
  $stmt = $db->prepare('delete from posts where id=:memo_id and member_id=:id limit 1');
  if (!$stmt) {
    die($db->error);
  }
  $stmt->bindValue(':memo_id', (int)$memo_id, PDO::PARAM_INT);
  $stmt->bindValue(':id', (int)$id, PDO::PARAM_INT);
  $stmt->execute();
} catch (PDOException $_e) {
  echo '不具合です' . $e->getMessage();
  $db->rollBack();
  exit();
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

  <title>筋トレメモ</title>
</head>

<body>
  <header id="header">
    <div class="wrapper">
      <p class="logo"><a href="top.php">筋トレメモ</a></p>
      <div class="hamburger-menu">
        <input type="checkbox" id="menu-btn-check">
        <label for="menu-btn-check" class="menu-btn"><span></span></label>
        <div class="menu-content">
          <ul>
            <li><a href="memo/post.php?id">メモする</a></li>
            <li><a href="index.php">投稿一覧</a></li>
            <li><a href="mypage.php">登録情報</a></li>
            <li><a href="logout.php">ログアウト</a></li>
          </ul>
        </div>
      </div>
    </div>
  </header>
  <p class=" thanks">削除しました</p>
  <div class="btn-area">
    <a href="index.php" class="button">戻る</a>
  </div>

  </div>
</body>

</html>
