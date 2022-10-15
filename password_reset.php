<?php
session_start();
require('library.php');
if (isset($_SESSION['id']) && isset($_SESSION['name'])) {
  $id = $_SESSION['id'];
} else {
  header('Location: login.php');
  exit();
}
$db = dbconnect();
$stmt = $db->prepare('select password from members where id=:id');
$stmt->bindValue(':id', (int)$id, PDO::PARAM_INT);
$stmt->execute();
$result = $stmt->fetch();

if (password_verify($password, $result['password'])) {
  $db->beginTransaction();
  try {
    $stmt = $db->prepare('update members SET password where id=:id;');
    $password = password_hash($form['password'], PASSWORD_DEFAULT);
    $stmt->bindValue(':id', (int)$id, PDO::PARAM_INT);
    $stmt->execute();
    $db->commit();
  } catch (PDOException $e) {
    $db->rollBack();
    exit($e);
  }
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
  <title>パスワード変更</title>
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
  <p class="form-title">パスワード変更</p>
  <div class="form-content">
    <form action="members_update.php" method="post">
      <div class="form-list">
        <label>現在のパスワード</label>
        <input name="password" type="password" value="">
        <?php if (isset($error['password']) && $error['password'] === 'blank') : ?>
          <p class="error">＊パスワードが一致しません</p>
        <?php endif; ?>

      </div>
      <div class="form-list">
        <label>新しいパスワード</label>
        <input name="password" type="password" value="">
      </div>
      <div class="form-list">
        <label>確認</label>
        <input name="password" type="password" value="">
      </div>
      <div class="btn-area">
        <input type="submit" name="" value="変更する">
      </div>
  </div>

  </form>
  </div>


</body>

</html>
