<?php
session_start();
require('library.php');


$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

$db = dbconnect2();
try {
  $stmt = $db->prepare('select p.id, p.member_id, p.picture, p.weight, p.part, p.memo,m.id from posts p, members m where p.id=:id and m.id=p.member_id');
  $stmt->bindValue(':id', (int)$id, PDO::PARAM_INT);
  $stmt->execute();
  $result = $stmt->fetch();
  $part = $result['part'];
  $weight = $result['weight'];
  $memo = $result['memo'];
  $picture = $result['picture'];
} catch (PDOException $e) {
  echo '不具合です' . $e->getMessage();
  $db->rollBack();
  exit();
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
  <title>筋トレメモ</title>
</head>



<body>
  <header id="header">
    <div class="wrapper">
      <p class="logo"><a href="top.php">筋トレメモ</a></p>
      <div class="hamburger-menu">
        <input type="checkbox" id="menu-btn-check">
        <label for="menu-btn-check" class="menu-btn"><span></span></label>
        <div class="menu-content">
          <ul>
            <li><a href="memo/post.php?id">メモする</a></li>
            <li><a href="index.php">投稿一覧</a></li>
            <li><a href="mypage.php">登録情報</a></li>
            <li><a href="logout.php">ログアウト</a></li>
          </ul>
        </div>
      </div>
    </div>
  </header>
  <main>
    <section id="content1">
      <div class="wrapper">
        <p class="form-title">詳細</p>
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
          <p class="check-list"><?php echo h($part); ?></p>
        </div>
        <div class="form-list">
          <label>体重</label>
          <p class="check-list"><?php echo h($weight); ?></p>
        </div>
        <div class="form-list">
          <label>メモ</label>
          <p class="check-list"><?php echo h($memo); ?></p>
        </div>
      </div>
    </section>
  </main>
</body>

</html>
