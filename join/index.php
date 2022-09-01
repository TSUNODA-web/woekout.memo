<?php
session_start();
require('../library.php');

$form = [
  'name' => '',
  'email' => '',
  'password' => '',
];
$error = [];
/*フォームの内容をチェック*/
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $form['name'] = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
  if ($form['name'] === '') {
    $error['name'] = 'blank';
  }

  $form['email'] = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
  if ($form['email'] === '') {
    $error['email'] = 'blank';
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
  <p class="form-title">会員登録フォーム</p>
  <div class="form-content">
    <form action="" method="post">
      <div class="form-list">
        <label>お名前</label>
        <input name="name" type="text" value="<?php echo h($form['name']); ?>">
        <?php if (isset($error['name']) && $error['name'] === 'blank') :  ?>
          <p class="error">＊名前を入力してください</p>
        <?php endif; ?>
      </div>
      <div class="form-list">
        <label>メールアドレス</label>
        <input name="email" type="email" value="<?php echo h($form['email']); ?>">
        <?php if (isset($error['email']) && $error['email'] === 'blank') : ?>
          <p class="error">＊メールアドレスを入力してください</p>
        <?php endif; ?>
        <p class="error">＊指定されたメールアドレスはすでに登録されています</p>
      </div>
      <div class="form-list">
        <label>パスワード</label>
        <input name="password" type="password" value="<?php echo h($form['password']); ?>">
        <?php if (isset($error['password']) && $error['password'] === 'blank') : ?>
          <p class="error">＊パスワードを入力してください</p>
        <?php endif; ?>
        <?php if (isset($error['password']) && $error['password'] === 'length') : ?>
          <p class="error">＊パスワードは8文字以上で入力してください</p>
        <?php endif; ?>

        <div class="btn-area">
          <input type="submit" name="" value="入力内容確認">
        </div>
      </div>
  </div>
  </form>
  </div>
</body>

</html>
