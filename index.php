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

$db = dbconnect();
//ログインしているユーザーのメモの件数を取得
$stmt = $db->prepare('select count(*) as cnt from posts WHERE member_id =?');
$stmt->bind_param('i', $member_id);
$success = $stmt->execute();
if (!$success) {
  die($db->error);
}
$stmt->bind_result($cnt);
$stmt->fetch();

$max_page = floor(($cnt + 1) / 8 + 1);
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
    <h1><a href="index.php">筋トレメモ</a></h1>
    <ul class="nav-list">
      <li class="nav-list-item">
        <a href="mypage.php?id=<?php echo h($member_id); ?>">マイページ</a>
      </li>
      <li class="nav-list-item">
        <a href="logout.php">ログアウト</a>
      </li>
    </ul>
  </header>
  <?php
  $db = dbconnect();
  $stmt = $db->prepare('select p.id, p.member_id, p.created, p.part, p.picture from posts p where p.member_id=? order by p.id desc limit ?,8');
  if (!$stmt) {
    die($db->error);
  }
  $page = filter_input(INPUT_GET, 'page', FILTER_SANITIZE_NUMBER_INT);
  //変数に何も入ってこなければ１を代入
  $page = ($page ?: 1);
  $start = ($page - 1) * 8;
  $stmt->bind_param('ii', $member_id, $start);
  $result = $stmt->execute();
  ?>
  <?php if (!$result) : ?>
    <p>表示するメモがありません</p>
  <?php endif ?>
  <?php $stmt->bind_result($id, $member_id, $created, $part, $picture);
  while ($stmt->fetch()) :
  ?>
    <div id="cards">
      <div class="card">
        <?php if ($picture) : ?>
          <div class="picture"><a href="detail.php?id=<?php echo h($id); ?>"><img src="picture/<?php echo h($picture); ?>"></a>
          <?php else : ?>
            <div class="picture"><a href="detail.php?id=<?php echo h($id); ?>"><img src="empty_image/20200501_noimage.jpg"></a>
            </div>
          <?php endif; ?>
          <div class="description">
            <p>[部位]<?php echo h($part); ?></p>
            <br>
            <p class="day">[投稿日]<?php echo h($created); ?></p>
          </div>
          </div>
      </div>
    </div>
  <?php endwhile; ?>
  <div class="btn-area">
    <a href="memo/post.php?id=<?php echo h($member_id); ?>" class="button">メモする</a>
  </div>
  <?php if ($page > 1) : ?>
    <a href="index.php?page=<?php echo $page - 1; ?>"><?php echo $page - 1; ?>ページ目へ</a> |
  <?php endif ?>
  <?php if ($page < $max_page) : ?>
    <a href="index.php?page=<?php echo $page + 1; ?>"><?php echo $page + 1; ?>ページ目へ</a>
  <?php endif ?>





</body>

</html>
