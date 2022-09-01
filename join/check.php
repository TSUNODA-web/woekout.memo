<?php
session_start();
require('../library.php');

if (isset($_SESSION['form'])) {
  $form = $_SESSION['form'];
} else {
  header('Location:index.php');
  exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $db = new mysqli('localhost', 'root', 'root', 'workout_memo');
  if (!$db) {
    die($db->error);
  }
  $stmt = $db->prepare('insert into members(name,email,password) VALUES(?,?,?)');
  if (!$stmt) {
    die($db->error);
  }
  $password = password_hash($form['password'], PASSWORD_DEFAULT);
  $stmt->bind_param('sss', $form['name'], $form['email'], $password);
  $success = $stmt->execute();
  if (!$success) {
    die($db->error);
  }

  unset($_SESSION['form']);
  header('Location:thanks.php');
}
?>


<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../reset.css" />
  <link rel="stylesheet" href="../style.css" />
  <title>会員登録</title>
</head>

<body>
  <header>
    <h1><a href="">筋トレメモ</a></h1>
  </header>
  <div class="form-title">会員登録フォーム</div>
  <div class="form-content">
    <form action="" method="post">
      <div class="form-list">
        <label>お名前</label>
        <p class="check-list"><?php echo h($form['name']); ?></p>
      </div>
      <div class="form-list">
        <label>メールアドレス</label>
        <p class="check-list"><?php echo h($form['email']); ?></p>

      </div>
      <div class="form-list">
        <label>パスワード</label>
        <p class="check-list">【表示されません】</p>
      </div>
      <div class="btn-area">
        <a href="index.php?action=rewrite" class="button">書き直す</a>
        <input type="submit" value="登録する" />
      </div>
    </form>
  </div>
</body>

</html>
