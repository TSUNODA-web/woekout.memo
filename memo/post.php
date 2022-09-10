<?php
session_start();
require('../library.php');
if (isset($_SESSION['id']) && isset($_SESSION['name'])) {
  $id = $_SESSION['id'];
} else {
  header('Location: login.php');
  exit();
}

$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
if (!$id) {
  header('Location: index.php');
  exit();
}



?>



<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <link rel="stylesheet" href="../reset.css" />
  <link rel="stylesheet" href="../style.css" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>投稿画面</title>
</head>

<body>
  <header>
    <h1 class="headline"><a href="../index.php?id=<?php echo h($id); ?>">筋トレメモ</a>
    </h1>
    <ul class="nav-list">
      <li class="nav-list-item">
        <a href="../mypage.php?id=<?php echo h($id); ?>">マイページ</a>
      </li>
      <li class="nav-list-item">
        <a href="logout.php">ログアウト</a>
      </li>
    </ul>
  </header>
  <p class="form-title">メモ</p>
  <div class="form-content">
    <form action="" method="post">
      <div class="form-list">
        <label>体重</label>
        <input name="weight" type="number" max="100" min="0" step="0.1">
      </div>
      <p class="error">＊ニックネームを入力してください</p>
      <div class="form-list">
        <label>部位</label>
        <select name="part">
          <option value="">選択してください</option>
          <option value="胸">胸</option>
          <option value="肩">肩</option>
          <option value="腕">腕</option>
          <option value="背中">背中</option>
          <option value="足">足</option>
        </select>
      </div>
      <p class="error">＊部位を選択してください</p>
      <div class="form-list">
        <label>メモ</label>
        <textarea name="memo" cols="50" rows="5"></textarea>
      </div>
      <p class="error">＊メモを入力してください</p>
      <div class="form-list">
        <label>写真</label>
        <input type="file" name="image" size="35" value="">
      </div>
      <p class="error">＊写真などは「.png」または「.jpg」の画像を指定してください</p>


      <div class="btn-area">
        <input type="submit" name="" value="メモする">

      </div>


</body>

</html>
