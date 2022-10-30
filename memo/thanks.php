<?php
session_start();

//submitボタン以外からアクセスしてきたら、ログインページへ飛ばす。
if (!isset($_SESSION["form"])) {
  header('Location: ../login.php');
  exit();
}
unset($_SESSION['form']);

?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../reset.css" />
  <link rel="stylesheet" href="../style.css" />
  <title>筋トレメモ</title>
</head>

<body>
  <header id="header">
    <div class="wrapper">
      <p class="logo"><a href="../top.php">筋トレメモ</a></p>
      <div class="hamburger-menu">
        <input type="checkbox" id="menu-btn-check">
        <label for="menu-btn-check" class="menu-btn"><span></span></label>
        <div class="menu-content">
          <ul>
            <li><a href="./post.php">メモする</a></li>
            <li><a href="../index.php">投稿一覧</a></li>
            <li><a href="../mypage.php>">登録情報</a></li>
            <li><a href="../logout.php">ログアウト</a></li>
          </ul>
        </div>
      </div>

    </div>
  </header>

  <div class="form-title">メモ</div>
  <p class="thanks">投稿が完了しました</p>
  <div class="content">
    <a href="../index.php" class="button">一覧へ</a>
  </div>

</body>

</html>
