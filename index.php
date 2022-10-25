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
try {
  $stmt = $db->prepare('select count(*) as cnt from posts WHERE member_id =:member_id');
  $stmt->bindValue(':member_id', (int)$member_id, PDO::PARAM_INT);
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
  <header id="header">
    <div class="wrapper">
      <p class="logo"><a href="index.php">筋トレメモ</a></p>
      <nav>
        <ul>
          <li><a href="memo/post.php?id=<?php echo $member_id; ?>">メモする</a></li>
          <li><a href="mypage.php?id=<?php echo ($member_id); ?>">マイページ</a></li>
          <li><a href="logout.php">ログアウト</a></li>
        </ul>
      </nav>
    </div>
  </header>
  <?php
  $db = dbconnect();
  $stmt = $db->prepare('select p.id, p.member_id, p.created, p.part, p.picture from posts p where p.member_id=:member_id order by p.id desc limit :start,6');
  $stmt->bindValue(':member_id', (int)$member_id, PDO::PARAM_INT);
  $stmt->bindValue(':start', (int)$start, PDO::PARAM_INT);
  $stmt->execute();
  $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
  ?>

  <main>
    <section id="content2">
      <div class="flex-container">
        <?php foreach ($result as $memo) { ?>
          <div class="wrapper">
            <div class="img-wrapper">
              <?php if ($memo['picture']) : ?>
                <a href="detail.php?id=<?php echo $memo['id']; ?>"><img src="picture/<?php echo $memo['picture']; ?>">
                <?php else : ?>
                  <div class="img-wrapper">
                    <a href="detail.php?id=<?php echo $memo['id']; ?>"><img src="empty_image/20200501_noimage.jpg"></a>
                  </div>
                <?php endif; ?>
            </div>
            <div class="content-wrapper">
              <h3 class="heading">[部位]<?php echo $memo['part']; ?></h3>
              <p class="text">投稿日]<?php echo $memo['created']; ?></p>
            </div>

          </div>
        <?php } ?>
      </div>

      <div class="btn-area">
        <div class="pagination">
          <?php if ($page > 1) : ?>
            <a href="index.php?page=<?php echo $page - 1; ?>"><?php echo $page - 1; ?>ページ目へ</a> |
          <?php endif ?>
          <?php if ($page < $max_page) : ?>
            <a href="index.php?page=<?php echo $page + 1; ?>"><?php echo $page + 1; ?>ページ目へ</a>
          <?php endif ?>
        </div>

    </section>
  </main>




</body>

</html>
