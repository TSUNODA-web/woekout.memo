<?php
$form = [];
$error = [];
$form['name'] = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
if ($form['name'] === '') {
  $error['name'] = 'blank';
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
        <label>名前を入力してください</label>
        <input name="name" type="text" value="">
        <?php if (isset($error['name']) && $error['name'] === 'blank') :  ?>

          <p class="error">＊名前を入力してください</p>
        <?php endif; ?>
      </div>
      <div class="form-list">
        <label>メールアドレスを入力してください</label>
        <input name="email" type="email" value="">
      </div>
      <div class="form-list">
        <label>パスワードを入力してください</label>
        <input name="password" type="password" value="">
      </div>
      <div class="form-list">
        <label>パスワードを再入力してください</label>
        <input name="password" type="password" value="">
      </div>
      <div class="btn-area">
        <input type="submit" name="" value="入力内容確認">
      </div>
    </form>
  </div>
</body>

</html>
