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
      <h1><a href="index.php">筋トレメモ</a></h1>
      <ul class="nav-list">
        <li class="nav-list-item">
          <a href=" mypage.php">マイページ</a>
        </li>
        <li class="nav-list-item">
          <a href="logout.php<?php echo h($member_id); ?>">ログアウト</a>
        </li>
      </ul>
    </header>
    <p class="form-title">詳細</p>
    <div class="form-content">
      <form action=" memos_update.php" method="post">
        <div class="form-list">
          <div class="detail-picture">
            <?php if ($picture) : ?>
              <div class="picture">
                <img src="picture/<?php echo h($picture); ?>">
              </div>
            <?php else : ?>
              <div class="picture">
                <img src="empty_image/20200501_noimage.jpg">
              </div>
            <?php endif; ?>
          </div>
        </div>
        <div class="form-list">
          <label>部位</label>
          <input name="part" type="text" value="<?php echo h($part); ?>">
        </div>
        <div class="form-list">
          <label>体重</label>
          <input name="weight" type="text" value="<?php echo h($weight); ?>">
        </div>
        <div class="form-list">
          <label>メモ</label>
          <textarea name="memo" cols="50" rows="5"><?php echo h($memo) ?></textarea>
        </div>
        <div>
          <input type="hidden" name="id" value="<?php echo h($id); ?>">
        </div>
      <?php endwhile; ?>
      <div class="btn-area">
        <input type="submit" name="" value="編集する">
      </div>
      <div class="btn-area">
        <a href="delete.php?id=<?php echo h($id); ?>" class="button">削除する</a>
      </div>
      </form>
    </div>
  </body>

  </html>
