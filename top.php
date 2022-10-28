<?php
session_start();

require('library.php');

$db = dbconnect();
//メモの件数を取得
try {
  $stmt = $db->prepare('select count(*) as cnt from posts');
  $stmt->execute();
  $result = $stmt->fetch();
} catch (PDOException $_e) {
  $db->rollBack();
  exit($e);
}

//変数に何も入ってこなければ１を代入
$page = filter_input(INPUT_GET, 'page', FILTER_SANITIZE_NUMBER_INT);
$page = ($page ?: 1);
$start = ($page - 1) * 6;
$max_page = floor(($result['cnt'] + 1) / 6 + 1);


if ($page > $max_page) {
  header('Location:top.php');
}

$stmt = $db->prepare('SELECT * FROM posts ORDER BY RAND() LIMIT 6');
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
      <nav>
        <ul>
          <?php if (isset($_SESSION['id']) && isset($_SESSION['name'])) : ?>
            <li><a href="memo/post.php">メモする</a></li>
            <li><a href="index.php">投稿一覧</a></li>
            <li><a href="mypage.php">登録情報</a></li>
            <li><a href="logout.php">ログアウト</a></li>
          <?php else : ?>
            <li><a href="login.php">ログイン</a></li>
            <li><a href="join/index.php">新規登録</a></li>
          <?php endif; ?>
        </ul>
      </nav>
    </div>
  </header>
  <main>
    <div class="bl_media_container">

      <?php foreach ($result as $memo) { ?>
        <div class="bl_media_itemWrapper">
          <?php if ($memo['picture']) : ?>
            <div class="bl_media_item"><a href="detail.php?id=<?php echo $memo['id']; ?>">
                <p class="img"><img src="picture/<?php echo h($memo['picture']); ?>" alt=""></p>
              </a>
            <?php else : ?>
              <div class="bl_media_item"><a href="detail.php?id=<?php echo h($memo['id']); ?>">
                  <p class="img"><img src="empty_image/20200501_noimage.jpg" alt=""></p>
                </a>
              <?php endif; ?>
              </div>
              <P>[部位]<?php echo h($memo['part']); ?></P>
              <p>[投稿日]<?php echo h($memo['created']); ?></p>
            </div>
          <?php } ?>
        </div>
    </div>
    <div class="btn-area">
      <div class="pagination">
        <?php if ($page > 1) : ?>
          <a href="top.php?page=<?php echo $page - 1; ?>"><?php echo $page - 1; ?>ページ目へ</a>
        <?php endif ?>
        <?php if ($page < $max_page) : ?>
          <a href="top.php?page=<?php echo $page + 1; ?>"><?php echo $page + 1; ?>ページ目へ</a>
        <?php endif ?>
      </div>


</body>

</html>
