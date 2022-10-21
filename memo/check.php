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
  $db = dbconnect();
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
    $db->rollBack();
    exit($e);
  }

  unset($_SESSION['form']);
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

  <title>Document</title>
</head>


<body>
  <header id="header">
    <div class="wrapper">
      <p class="logo"><a href="../index.php">筋トレメモ</a></p>
      <nav>
        <ul>
          <li><a href="post.php?id=<?php echo $id; ?>">メモする</a></li>
          <li><a href="../mypage.php?id=<?php echo $id; ?>">マイページ</a></li>
          <li><a href="../logout.php">ログアウト</a></li>
        </ul>
      </nav>
    </div>
  </header>
  <div class="form-title">メモ確認</div>
  <div class="form-content">
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
        <img src="../picture/<?php echo h($form['image']); ?>" width="100" alt="" />

      </div>

      <div class="btn-area">
        <a href="post.php?action=rewrite" class="button">書き直す</a>
        <input type="submit" value="メモする" />
      </div>
    </form>
  </div>

</body>

</html>
