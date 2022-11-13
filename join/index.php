<?php
session_start();
require('../library.php');

if (isset($_GET['action']) && $_GET['action'] === 'rewrite' && isset($_SESSION['form'])) {
  $form = $_SESSION['form'];
} else {
  $form = [
    'name' => '',
    'email' => '',
    'password' => ''
  ];
}


$error = [];
/*フォームの内容をチェック*/
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $form['name'] = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS);
  if ($form['name'] === '') {
    $error['name'] = 'blank';
  } //elseif (20 < mb_strlen($form['name'])) {
  //$error['name'] = 'length';


  $form['email'] = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
  if ($form['email'] === '') {
    $error['email'] = 'blank';
  } else {
    $db = dbconnect2();
    try {
      $stmt = $db->prepare('select count(*) as cnt from members where email=:email ');
      $stmt->bindValue(':email', $form['email'], PDO::PARAM_STR);
      $stmt->execute();
      $result = $stmt->fetch();

      if ($result['cnt'] > 0) {
        $error['email'] = 'duplicate';
      }
    } catch (PDOException $e) {
      echo '不具合です' . $e->getMessage();
      exit();
    }
  }
}

$form['password'] = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
if ($form['password'] === '') {
  $error['password'] = 'blank';
} elseif (strlen($form['password']) < 8) {
  $error['password'] = 'length';
}

if (empty($error)) {
  $_SESSION['form'] = $form;
  header('Location: check.php');
  exit();
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
    <section id="content">
      <div class="wrapper">
        <p class="form-title">会員登録フォーム</p>
        <form action="" method="post">
          <div class="form-list">
            <label>お名前　</label>
            <input name="name" type="text" value="<?php echo h($form['name']); ?>">
          </div>
          <?php if (isset($error['name']) && $error['name'] === 'blank') :  ?>
            <p class="error">＊名前を入力してください</p>
          <?php endif; ?>
          <?php if (isset($error['name']) && $error['name'] === 'length') : ?>
            <p class="error">＊名前は20文字以内で入力してください</p>
          <?php endif; ?>
          <div class="form-list">
            <label>メールアドレス</label>
            <input name="email" type="email" value="<?php echo h($form['email']); ?>">
          </div>
          <?php if (isset($error['email']) && $error['email'] === 'blank') : ?>
            <p class="error">＊メールアドレスを入力してください</p>
          <?php endif; ?>
          <?php if (isset($error['email']) && $error['email'] === 'duplicate') : ?>
            <p class="error">＊指定されたメールアドレスはすでに登録されています</p>
          <?php endif; ?>
          <div class="form-list">
            <label>パスワード</label>
            <input name="password" type="password" value="<?php echo h($form['password']); ?>">
          </div>
          <?php if (isset($error['password']) && $error['password'] === 'blank') : ?>
            <p class="error">＊パスワードを入力してください</p>
          <?php endif; ?>
          <?php if (isset($error['password']) && $error['password'] === 'length') : ?>
            <p class="error">＊パスワードは8文字以上で入力してください</p>
          <?php endif; ?>
          <div class="btn-area">
            <input type="submit" name="" value="入力内容確認">
          </div>
        </form>
      </div>
    </section>
  </main>
</body>

</html>
