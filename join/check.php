<?php
session_start();
require('../library.php');

if (isset($_SESSION['form'])) {
  $form = $_SESSION['form'];
} else {
  header('Location:index.php');
  exit();
}
$password = password_hash($form['password'], PASSWORD_DEFAULT);

var_dump($form);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $db = dbconnect2();
  $db->beginTransaction();
  try {
    $stmt = $db->prepare('insert into members (name,email,password) VALUES(?,?,?)');
    $stmt->bindValue('1', $form['name'], PDO::PARAM_STR);
    $stmt->bindValue('2', $form['email'], PDO::PARAM_STR);
    $stmt->bindValue('3', $password, PDO::PARAM_STR);

    $stmt->execute();
    $db->commit();

    unset($_SESSION['form']);
    header('Location:thanks.php');
  } catch (PDOException $e) {
    echo '不具合です' . $e->getMessage();
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
  <link rel="stylesheet" href="../reset.css" />
  <link rel="stylesheet" href="../style.css" />
  <title>会員登録</title>
</head>

<body id="page1">
  <header id="header">
    <div class="wrapper">
      <p class="logo"><a href="../top.php">筋トレメモ</a></p>
    </div>
  </header>
  <main>
    <section id="content1">
      <div class="wrapper">
        <div class="form-title">会員登録フォーム</div>
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
    </section>
  </main>
</body>

</html>
