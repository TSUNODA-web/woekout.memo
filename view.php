<?php
session_start();
require('library.php');

if (isset($_SESSION['id']) && isset($_SESSION['name'])) {
  $member_id = $_SESSION['id'];
  $name = $_SESSION['name'];
} else {
  header('Location: login.php');
  exit();
}

$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
if (!$id) {
  header('Location: index.php');
  exit();
}
$db = dbconnect();
$stmt = $db->prepare('select p.id, p.member_id, p.created, p.picture, p.weight, p.part, p.memo,m.id from posts p, members m where p.id=? and m.id=p.member_id');
if (!$stmt) {
  die($db->error);
}
$stmt->bind_param('i', $id);
$success = $stmt->execute();
if (!$success) {
  die($db->error);
}
$stmt->bind_result($id, $member_id, $created, $picture, $weight, $part, $memo, $member_id);
var_dump($id, $member_id, $created, $picture, $weight, $part, $memo, $member_id);
while ($stmt->fetch()) :

?>




  <!DOCTYPE html>
  <html lang="ja">

  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="reset.css" />
    <link rel="stylesheet" href="style.css" />
    <title>メモ詳細</title>
  </head>



  <body>
    <header>
      <h1><a href="">筋トレメモ</a></h1>
      <ul class="nav-list">
        <li class="nav-list-item">
          <a href=" mypage.php">マイページ</a>
        </li>
        <li class="nav-list-item">
          <a href="logout.php">ログアウト</a>
        </li>
      </ul>
    </header>
    <div id="cards">
      <div class="card">
        <?php if ($picture) : ?>
          <div class="picture"><a href="view.php?id=<?php echo h($id); ?>"><img src="picture/<?php echo h($picture); ?>"></a>
          </div>
        <?php endif; ?>
        <div class="description">
          <p>[部位]<?php echo h($part); ?></p>
          <br>
          <p class="day">[投稿日]<?php echo h($created); ?></p>
        </div>
      </div>
    </div>
  <?php endwhile; ?>
  <div class="btn-area">
    <?php if ($_SESSION['id'] === $member_id) : ?>
      <a href="delete.php?id=<?php echo h($member_id); ?>" class="button">削除する</a>
    <?php endif; ?>

  </div>

  </body>

  </html>
