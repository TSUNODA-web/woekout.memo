<?php
session_start();
require('library.php');
if (isset($_SESSION['id']) && isset($_SESSION['name'])) {
  $member_id = $_SESSION['id'];
} else {
  header('Location: login.php');
  exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  //$part = $_POST['part'];
  /*$db = dbconnect();
  $db->begin_transaction();
  $stmt = $db->prepare('update posts set(part,weight,memo,id) VALUES(?,?,?,?)');
  if (!$stmt) {
    die($db->error);
  }*/
}
var_dump($_SESSION);
?>



<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="reset.css" />
  <link rel="stylesheet" href="style.css" />
  <title>編集完了</title>
</head>

<body>
  <header>
    <h1 class="headline"><a href="">筋トレメモ</a>
    </h1>
    <ul class="nav-list">
      <li class="nav-list-item">
        <a href=" mypage.php?id=<?php echo h($member_id); ?>">マイページ</a>
      </li>
      <li class="nav-list-item">
        <a href="logout.php">ログアウト</a>
      </li>
    </ul>
  </header>
  <div class="form-title">フォーム</div>
  <p class="thanks">編集が完了しました</p>

  <div class="content">
    <a href="index.php" class="button">一覧へ</a>
  </div>

</body>

</html>
