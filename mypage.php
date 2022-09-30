<?php
session_start();
require('library.php');
if (isset($_SESSION['id']) && isset($_SESSION['name'])) {
  $id = $_SESSION['id'];
  $name = $_SESSION['name'];
  $email = $_SESSION['email'];
} else {
  header('Location: login.php');
  exit();
}

$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
if (!$id) {
  header('Location: index.php');
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
  <title>マイページ</title>
</head>

<body>
  <header>
    <h1 class="headline"><a href="index.php?id=<?php echo h($id); ?>">筋トレメモ</a>
    </h1>
    <ul class="nav-list">
      <li class="nav-list-item">
        <a href="mypage.php?id=<?php echo h($id); ?>">マイページ</a>

      </li>
      <li class="nav-list-item">
        <a href="logout.php">ログアウト</a>
      </li>
    </ul>
  </header>
  <p class="form-title">登録情報</p>
  <div class="form-content">
    <form action="members_update.php" method="post">
      <div class="form-list">
        <label>お名前</label>
        <input name="name" type="text" value="<?php echo h($name); ?>">
      </div>
      <div class="form-list">
        <label>メールアドレス</label>
        <input name="email" type="email" value="<?php echo h($email); ?>">
      </div>
      <div>
        <input type="hidden" name="id" value="<?php echo $id; ?>">
      </div>
      <div class="btn-area">
        <input type="submit" name="" value="更新する">
      </div>
    </form>
    <button onclick="location.href='password_reset.php?id=<?php echo ($id); ?>'">パスワードの変更はこちら</button>
  </div>
</body>

</html>
