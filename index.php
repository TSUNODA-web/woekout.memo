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
$stmt = $db->prepare('select count(*) as cnt from posts WHERE member_id =:member_id');
$stmt->bindValue(':member_id', (int)$member_id, PDO::PARAM_INT);
$stmt->execute();
$result = $stmt->fetch();
$page = filter_input(INPUT_GET, 'page', FILTER_SANITIZE_NUMBER_INT);
//変数に何も入ってこなければ１を代入
$page = ($page ?: 1);
$start = ($page - 1) * 8;
$max_page = floor(($result['cnt'] + 1) / 8 + 1);
if ($page > $max_page) {
  header('Location:index.php');
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
  $stmt = $db->prepare('select p.id, p.member_id, p.created, p.part, p.picture from posts p where p.member_id=:member_id order by p.id desc limit :start,8');
  $stmt->bindValue(':member_id', (int)$member_id, PDO::PARAM_INT);
  $stmt->bindValue(':start', (int)$start, PDO::PARAM_INT);
  $stmt->execute();
  $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
  ?>

  <?php foreach ($result as $memo) { ?>
    <div id="cards">
      <div class="card">
        <?php if ($memo['picture']) : ?>
          <div class="picture"><a href="detail.php?id=<?php echo $memo['id']; ?>"><img src="picture/<?php echo $memo['picture']; ?>"></a>
          <?php else : ?>
            <div class="picture"><a href="detail.php?id=<?php echo $memo['id']; ?>"><img src="empty_image/20200501_noimage.jpg"></a>
            </div>
          <?php endif; ?>
          <div class="description">
            <p>[部位]<?php echo $memo['part']; ?></p>
            <br>
            <p class="day">[投稿日]<?php echo $memo['created']; ?></p>
          </div>
          </div>
      </div>
    </div>
  <?php } ?>
  <div class="btn-area">
    <a href="memo/post.php?id=<?php echo $memo['member_id']; ?>" class="button">メモする</a>
  </div>
  <div class="pagination">
    <?php if ($page > 1) : ?>
      <a href="index.php?page=<?php echo $page - 1; ?>"><?php echo $page - 1; ?>ページ目へ</a> |
    <?php endif ?>
    <?php if ($page < $max_page) : ?>
      <a href="index.php?page=<?php echo $page + 1; ?>"><?php echo $page + 1; ?>ページ目へ</a>
    <?php endif ?>
  </div>




</body>

</html>
