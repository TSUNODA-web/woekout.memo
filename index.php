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

$stmt = $db->prepare('select p.id, p.member_id,p.weight, p.created, p.part, p.memo, p.picture, m.name from posts p, members m where m.id=p.member_id order by id desc');

if (!$stmt) {
  die($db->error);
}
$success = $stmt->execute();
$stmt->bind_result($id, $member_id, $weight, $created, $part, $memo, $picture, $name);
while ($stmt->fetch());
var_dump($id, $memo, $part, $picture);




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
      <?php if ($picture) : ?>
        <div class="picture"><img src="picture/<?php echo h($picture); ?>" />
        </div>
      <?php endif; ?>
      <div class="description">
        <p><?php echo h($memo); ?></p>
      </div>
    </div>
    <div class="card" id="card-center">
      <?php if ($picture) : ?>
        <div class="picture"><img src="picuture" <?php echo h($picture); ?>></div>
      <?php endif; ?>
      <div class="description">
        <p><?php echo h($memo); ?></p>
      </div>
    </div>
    <div class="card">
      <?php if ($picture) : ?>
        <div class="picture"><img src="picuture" <?php echo h($picture); ?>></div>
      <?php endif; ?>
      <div class="description">
        <p><?php echo h($memo); ?></p>
      </div>
    </div>
  </div>
  <div id="cards">
    <div class="card">
      <?php if ($picture) : ?>
        <div class="picture"><img src="picuture" <?php echo h($picture); ?>></div>
      <?php endif; ?>
      <div class="description">
        <p><?php echo h($memo); ?></p>
      </div>
    </div>
    <div class="card" id="card-center">
      <?php if ($picture) : ?>
        <div class="picture"><img src="picuture/" <?php echo h($picture); ?>></div>
      <?php endif; ?>
      <div class="description">
        <p><?php echo h($memo); ?></p>
      </div>
    </div>
    <div class="card">
      <?php if ($picture) : ?>
        <div class="picture"><img src="picuture" <?php echo h($picture); ?>></div>
      <?php endif; ?>
      <div class="description">
        <p><?php echo h($memo); ?></p>
      </div>
    </div>
  </div>

  <a href="memo/post.php?id=<?php echo h($id); ?>" class="button">メモする</a>




</body>

</html>
