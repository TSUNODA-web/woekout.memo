<?php
session_start();
require('library.php');
if (isset($_SESSION['id']) && isset($_SESSION['name'])) {
  $id = $_SESSION['id'];
} else {
  header('Location: login.php');
  exit();
}

/*if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $form['password'] = filter_input(INPUT_POST, 'password');

}


$password = $_POST;

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

$_SESSION = array();
session_destroy();*/
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
