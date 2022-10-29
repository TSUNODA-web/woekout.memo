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

$db = dbconnect();
try {
  $stmt = $db->prepare('delete from posts where id=:memo_id and member_id=:id limit 1');
  if (!$stmt) {
    die($db->error);
  }
  $stmt->bindValue(':memo_id', (int)$memo_id, PDO::PARAM_INT);
  $stmt->bindValue(':id', (int)$id, PDO::PARAM_INT);
  $stmt->execute();
} catch (PDOException $_e) {
  $db->rollBack();
  exit($e);
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
  <header id="header">
    <div class="wrapper">
      <p class="logo"><a href="top.php">筋トレメモ</a></p>
      <nav>
        <ul>
          <li><a href="memo/post.php?id=<?php echo h($id); ?>">メモする</a></li>
          <li><a href="mypage.php?id=<?php echo h($id); ?>">マイページ</a></li>
          <li><a href="logout.php">ログアウト</a></li>
        </ul>
      </nav>
    </div>
  </header>
  <p class=" thanks">削除しました</p>
  <div class="btn-area">
    <a href="index.php" class="button">戻る</a>
  </div>

  </div>
</body>

</html>
