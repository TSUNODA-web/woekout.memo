<?php
session_start();
require('/Applications/MAMP/htdocs/workout.memo/library.php');

if (isset($_SESSION['id']) && isset($_SESSION['name'])) {
  $id = $_SESSION['id'];
  $form = $_SESSION['form'];
} else {
  header('Location: login.php');
  exit();
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $db = dbconnect2();
  $db->beginTransaction();
  try {
    $stmt = $db->prepare('insert into posts(member_id,weight,part,memo,picture) VALUES(?,?,?,?,?)');

    $stmt->bindValue('1', (int)$form['member_id'], PDO::PARAM_INT);
    $stmt->bindValue('2', (int)$form['weight'], PDO::PARAM_INT);
    $stmt->bindValue('3', $form['part'], PDO::PARAM_STR);
    $stmt->bindValue('4', $form['memo'], PDO::PARAM_STR);
    $stmt->bindValue('5', $form['image'], PDO::PARAM_STR);

    $stmt->execute();
    $db->commit();
  } catch (PDOException $_e) {
    echo '不具合です' . $e->getMessage();
    $db->rollBack();
    exit($e);
  }

  header('Location:thanks.php');
}
?>
<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../reset.css" />
  <link rel="stylesheet" href="../style.css" />

  <title>筋トレメモ</title>
</head>


<body>
  <header id="header">
    <div class="wrapper">
      <p class="logo"><a href="../top.php">筋トレメモ</a></p>
      <div class="hamburger-menu">
        <input type="checkbox" id="menu-btn-check">
        <label for="menu-btn-check" class="menu-btn"><span></span></label>
        <div class="menu-content">
          <ul>
            <li><a href="./post.php">メモする</a></li>
            <li><a href="../index.php">投稿一覧</a></li>
            <li><a href="../mypage.php">登録情報</a></li>
            <li><a href="../logout.php">ログアウト</a></li>
          </ul>
        </div>
      </div>
    </div>
  </header>
  <main>
    <section id="content1">
      <div class="wrapper">
        <div class="form-title">メモ確認</div>
        <form action="" method="post">
          <div class="form-list">
            <label>体重</label>
            <p class="check-list"><?php echo h($form['weight']); ?></p>
          </div>
          <div class="form-list">
            <label>部位</label>
            <p class="check-list"><?php echo h($form['part']); ?></p>
          </div>
          <div class="form-list">
            <label>メモ</label>
            <p class="check-list"><?php echo h($form['memo']); ?></p>
          </div>
          <div class="form-list">
            <label>写真</label>
            <?php if ($form['image']) : ?>
              <p class="check-list">
                <img src="../picture/<?php echo h($form['image']); ?>" class="check" />
              </p>
            <?php else : ?>
              <p class="check-list">画像なし</p>
            <?php endif; ?>

          </div>
          <div class="btn-area">
            <a href="post.php?action=rewrite" class="button">書き直す</a>
            <input type="submit" name="submit" value="メモする" />
          </div>
        </form>
      </div>
    </section>
  </main>


</body>

</html>
