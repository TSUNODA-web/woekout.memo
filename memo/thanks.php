<?php
session_start();
if (isset($_SESSION['id'])) {
  $id = $_SESSION['id'];
} else {
  header('Location: ../login.php');
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
  <title>メモ完了</title>
</head>

<body>
  <header id="header">
    <div class="wrapper">
      <p class="logo"><a href="../index.php">筋トレメモ</a></p>
      <nav>
        <ul>
          <li><a href="post.php?id=<?php echo $id; ?>">メモする</a></li>
          <li><a href="../mypage.php?id=<?php echo $id; ?>">マイページ</a></li>
          <li><a href="../logout.php">ログアウト</a></li>
        </ul>
      </nav>
    </div>
  </header>

  <div class="form-title">メモ</div>
  <p class="thanks">投稿が完了しました</p>
  <div class="content">
    <a href="../index.php" class="button">一覧へ</a>
  </div>

</body>

</html>
