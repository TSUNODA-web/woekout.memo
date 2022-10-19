<?php
session_start();
require('library.php');
if (isset($_SESSION['id']) && isset($_SESSION['name'])) {
  $id = $_SESSION['id'];
} else {
  header('Location: login.php');
  exit();
}

//変数の初期化
$form = [
  'password' => '',
  'new_password' => '',
  'confirm_password' => ''

];
$error = [];

//バリデーション
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $form['password'] = filter_input(INPUT_POST, 'password');
  if ($form['password'] === '') {
    $error['password'] = 'blank';
  } else {
    $db = dbconnect();
    try {
      $stmt = $db->prepare('select password from members where id=:id');
      $stmt->bindValue(':id', $id, PDO::PARAM_INT);
      $stmt->execute();
      $result = $stmt->fetch();
    } catch (PDOException $e) {
      $db->rollBack();
      exit($e);
    }
    if (!password_verify($form['password'], $result['password'])) {
      $error[('password')] = 'faild';
    }
  }
  $form['new_password'] = filter_input(INPUT_POST, 'new_password');
  if ($form['new_password'] === '') {
    $error['new_password'] = 'blank';
  } elseif (strlen($form['new_password']) < 8) {
    $error['new_password'] = 'length';
  }
  $form['confirm_password'] = filter_input(INPUT_POST, 'confirm_password');
  if ($form['confirm_password'] === '') {
    $error['confirm_password'] = 'blank';
  } elseif ($form['new_password'] !== $form['confirm_password']) {
    $error['confirm_password'] = 'faild';
  }

  $form['id'] = filter_input(INPUT_POST, 'id');

  if (empty($error)) {
    $_SESSION['form'] = $form;
    header('Location: password_update.php');
    exit();
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
    <form action="" method="post">
      <div class="form-list">
        <label>現在のパスワード</label>
        <input name="password" type="password" value="">
        <?php if (isset($error['password']) && $error['password'] === 'blank') : ?>
          <p class="error">＊パスワードを入力してください</p>
        <?php endif; ?>
        <?php if (isset($error['password']) && $error['password'] === 'faild') : ?>
          <p class="error">＊パスワードが一致しません</p>
        <?php endif; ?>
      </div>
      <div class="form-list">
        <label>新しいパスワード</label>
        <input name="new_password" type="password" value="">
        <?php if (isset($error['new_password']) && $error['new_password'] === 'blank') : ?>
          <p class="error">＊パスワードを入力してください</p>
        <?php endif; ?>
        <?php if (isset($error['new_password']) && $error['new_password'] === 'length') : ?>
          <p class="error">＊パスワードは8文字以上で入力してください</p>
        <?php endif; ?>
      </div>
      <div class="form-list">
        <label>確認</label>
        <input name="confirm_password" type="password" value="">
        <?php if (isset($error['confirm_password']) && $error['confirm_password'] === 'blank') : ?>
          <p class="error">＊パスワードを入力してください</p>
        <?php endif; ?>
        <?php if (isset($error['confirm_password']) && $error['confirm_password'] === 'faild') : ?>
          <p class="error">＊パスワードが一致しません</p>
        <?php endif; ?>
      </div>
      <div>
        <input type="hidden" name="id" value="<?php echo $id; ?>">
      </div>
      <div class="btn-area">
        <input type="submit" name="" value="変更する">
      </div>
    </form>
  </div>
</body>

</html>
