<?php
session_start();
require('library.php');
if (isset($_SESSION['id']) && isset($_SESSION['name'])) {
  $id = $_SESSION['id'];
} else {
  header('Location: login.php');
  exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name = $_POST['name'];
  $email = $_POST['email'];
  $db = dbconnect();
  $db->begin_transaction();
  $stmt = $db->prepare('UPDATE members SET name = ?,email =? WHERE members.id = ?;');
  if (!$stmt) {
    die($db->error);
  }
  $stmt->bind_param('ssi', $name, $email, $id);
  $success = $stmt->execute();
  $db->commit();
  if (!$success) {
    die($db->error);
  }

  unset($_SESSION['name,email']);
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
  <title>更新完了</title>
</head>

<body>
  <header>
    <h1 class="headline"><a href="">筋トレメモ</a>
    </h1>
    <ul class="nav-list">
      <li class="nav-list-item">
        <a href=" mypage.php?id=<?php echo h($id); ?>"><?php echo h($name); ?>様</a>
      </li>
      <li class="nav-list-item">
        <a href="logout.php">ログアウト</a>
      </li>
    </ul>
  </header>
  <div class="form-title">フォーム</div>
  <p class="thanks">更新が完了しました</p>
  <p class="thanks">再度ログインしてください</p>

  <div class="content">
    <a href="login.php" class="button">ログイン</a>
  </div>

</body>

</html>
