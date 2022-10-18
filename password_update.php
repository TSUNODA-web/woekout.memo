<?php
session_start();
require('library.php');
if (isset($_SESSION['id']) && isset($_SESSION['name'])) {
  $id = $_SESSION['id'];
} else {
  header('Location: login.php');
  exit();
}


$password = ($_SESSION['new_password']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $db = dbconnect();
  $db->beginTransaction();
  try {
    $stmt = $db->prepare('update members SET password=:password where id=:id;');
    $password = password_hash($_SESSION['new_password'], PASSWORD_DEFAULT);
    $stmt->bindValue(':id', (int)$id, PDO::PARAM_INT);
    $stmt->bindValue(':password', $password, PDO::PARAM_STR);
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
  <title>Document</title>
</head>

<body>
  <?php
  //セッションを破棄し再度ログインしてもらう

  //$_SESSION = array();
  //session_destroy();
  ?>
  <p class=" thanks">編集が完了しました<br>再度ログインしてくだし</p>
  <div class="content">
    <a href="login.php" class="button">ログイン</a>
  </div>
</body>

</html>
