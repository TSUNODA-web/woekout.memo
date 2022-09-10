<?php
session_start();
require('library.php');

if (isset($_SESSION['id']) && isset($_SESSION['name'])) {
  $id = $_SESSION['id'];
  $name = $_SESSION['name'];
} else {
  header('Location: login.php');
  exit();
}

$db = dbconnect();

?>


<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="reset.css" />
  <link rel="stylesheet" href="style.css" />

  <title>一覧</title>
</head>

<body>
  <header>
    <h1><a href="">筋トレメモ</a></h1>
    <ul class="nav-list">
      <li class="nav-list-item">
        <a href="mypage.php?id=<?php echo h($id); ?>">マイページ</a>
      </li>
      <li class="nav-list-item">
        <a href="logout.php">ログアウト</a>
      </li>
    </ul>
  </header>
  <div id="cards">
    <div class="card">
      <div class="picture"><img src="" alt="" /></div>
      <div class="description">
        <p>
          ここにテキストが入ります。ここにテキストが入ります。ここにテキストが入ります。
        </p>
      </div>
    </div>
    <div class="card" id="card-center">
      <div class="picture"><img src="image2.jpg" alt="" /></div>
      <div class="description">
        <p>
          ここにテキストが入ります。ここにテキストが入ります。ここにテキストが入ります。
        </p>
      </div>
    </div>
    <div class="card">
      <div class="picture"><img src="image3.jpg" alt="" /></div>
      <div class="description">
        <p>
          ここにテキストが入ります。ここにテキストが入ります。ここにテキストが入ります。
        </p>
      </div>
    </div>
  </div>
  <div id="cards">
    <div class="card">
      <div class="picture"><img src="" alt="" /></div>
      <div class="description">
        <p>
          ここにテキストが入ります。ここにテキストが入ります。ここにテキストが入ります。
        </p>
      </div>
    </div>
    <div class="card" id="card-center">
      <div class="picture"><img src="image2.jpg" alt="" /></div>
      <div class="description">
        <p>
          ここにテキストが入ります。ここにテキストが入ります。ここにテキストが入ります。
        </p>
      </div>
    </div>
    <div class="card">
      <div class="picture"><img src="image3.jpg" alt="" /></div>
      <div class="description">
        <p>
          ここにテキストが入ります。ここにテキストが入ります。ここにテキストが入ります。
        </p>
      </div>
    </div>
  </div>

  <a href="memo/post.php?id=<?php echo h($id); ?>" class="button">メモする</a>




</body>

</html>
