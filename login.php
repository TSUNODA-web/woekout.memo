<?php
session_start();
require('library.php');
$error = [];
$email = '';
$password = '';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
  $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
  if ($email === '' || $password === '') {
    $error['login'] = 'blank';
  } else {
    //ログインチェック
    $db = dbconnect();
    try {
      $stmt = $db->prepare('select id,name,password from members where email=:email');
      $stmt->bindValue(':email', $email, PDO::PARAM_STR);
      $stmt->execute();
      $result = $stmt->fetch();

      $stmt->execute();
      $result = $stmt->fetch();

      if (password_verify($password, $result['password'])) {
        //成功
        session_regenerate_id();
        $_SESSION['id'] = $result['id'];
        $_SESSION['name'] = $result['name'];
        $_SESSION['email'] = $email;

        header('Location: top.php');
        exit();
      } else {
        $error[('login')] = 'faild';
      }
    } catch (PDOException $e) {
      $db->rollBack();
      exit($e);
    }
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

  <title>筋トレメモ</title>
</head>

<body id="page1">
  <header id="header">
    <div class="wrapper">
      <p class="logo"><a href="top.php">筋トレメモ</a></p>
    </div>
  </header>
  <main>
    <section id="content1">
      <div class="wrapper">
        <form action="" method="post">
          <div class="form-list">
            <label>メールアドレス</label>
            <input name="email" type="email" value="<?php echo h($email); ?>">
          </div>
          <?php if (isset($error['login']) && $error['login'] === 'blank') : ?>
            <p class="error">＊メールアドレスとパスワードをご記入ください</p>
          <?php endif; ?>
          <div class="form-list">
            <label>パスワード</label>
            <input name="password" type="password" value="<?php echo h($password); ?>">
          </div>
          <?php if (isset($error['login']) && $error['login'] === 'faild') : ?>
            <p class="error">＊メールアドレスまたはパスワードが一致しません。</p>
          <?php endif; ?>
          <div class="btn-area">
            <input type="submit" name="" value="ログイン">
          </div>
        </form>
      </div>
    </section>


  </main>
</body>

</html>
