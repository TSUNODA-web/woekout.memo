<?php
session_start();
require('library.php');
if (isset($_SESSION['id']) && isset($_SESSION['name'])) {
  $id = $_SESSION['id'];
  $name = $_SESSION['name'];
  $email = $_SESSION['email'];
} else {
  header('Location: login.php');
  exit();
}


//確認ページから戻ってきた場合のデータの受け取り
if (isset($_POST["backbtn"])) {
  $name    = $_POST['name'];
  $email    = $_POST['email'];
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
  <title>マイページ</title>
</head>

<body>
  <header id="header">
    <div class="wrapper">
      <p class="logo"><a href="top.php">筋トレメモ</a></p>
      <nav>
        <ul>
          <li><a href="memo/post.php">メモする</a></li>
          <li><a href="index.php">投稿一覧</a></li>
          <li><a href="mypage.php">登録情報</a></li>
          <li><a href="logout.php">ログアウト</a></ </ul>
      </nav>
    </div>
  </header>
  <main>
    <section id="content1">
      <div class="wrapper">
        <p class="form-title">登録情報</p>
        <form action="members_update.php" method="post">
          <div class="form-list">
            <label>お名前</label>
            <input name="name" type="text" value="<?php echo h($name); ?>">
          </div>
          <div class="form-list">
            <label>メールアドレス</label>
            <input name="email" type="email" value="<?php echo h($email); ?>">
          </div>
          <div>
            <input type="hidden" name="id" value="<?php echo $id; ?>">
          </div>
          <div class="btn-area">
            <input type="submit" name="update" value="更新する">
          </div>
        </form>
        <button onclick="location.href='password.php?id=<?php echo ($id); ?>'">パスワードの変更はこちら</button>
      </div>
    </section>
  </main>

</body>

</html>
