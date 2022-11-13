<?php
session_start();
require('library.php');
if (isset($_SESSION['id']) && isset($_SESSION['name'])) {
  $member_id = $_SESSION['id'];
} else {
  header('Location: login.php');
  exit();
}

if (!isset($_POST["post"])) {
  header('Location: login.php');
  exit();
}

//POSTで送信してきた値を代入するため、初期化。
$memos = array();
//サニタイズ
if (!empty($_POST)) {
  foreach ($_POST as $key => $value) {
    $memos[$key] = h($value);
  }
}
//エラーメッセージ
$err = array();

//バリデーション
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $memos['part'] = filter_input(INPUT_POST, 'part');
  if ($memos['part'] === '') {
    $err[] = '部位を入力してください';
  } elseif (20 < mb_strlen($memos['part'])) {
    $err[] = "部位は20文字以内で入力してください。";
  }
  $memos['weight'] = filter_input(INPUT_POST, 'weight', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
  if ($memos['weight'] === '') {
    $err[] = '体重を入力してください';
  }
  $memos['memo'] = filter_input(INPUT_POST, 'memo');
  if ($memos['memo'] === '') {
    $err[] = 'メモを入力してください';
  } elseif (200 < mb_strlen($memos['memo'])) {
    $err[] = "メモは200文字以内で入力してください。";
  }

  //アップデート処理
  if (count($err) === 0) {
    $db = dbconnect2();
    $db->beginTransaction();
    try {
      $stmt = $db->prepare('update posts SET part=:part,weight=:weight,memo=:memo where id=:id;');

      $stmt->bindValue(':part', $memos['part'], PDO::PARAM_STR);
      $stmt->bindValue(':weight', (int)$memos['weight'], PDO::PARAM_INT);
      $stmt->bindValue(':memo', $memos['memo'], PDO::PARAM_STR);
      $stmt->bindValue(':id', (int)$memos['id'], PDO::PARAM_INT);
      $stmt->execute();
      $db->commit();
    } catch (PDOException $e) {
      echo '不具合です' . $e->getMessage();
      $db->rollBack();
      exit();
    }
  }
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
  <div class="form-title">フォーム</div>
  <?php if (count($err) > 0) : ?>
    <?php foreach ($err as $e) : ?>
      <p class="thanks"><?php echo $e ?></p>
    <?php endforeach ?>
    <div class="form-content">
      <form method="post" action="detail.php?id=<?php echo $memos['id']; ?>">
        <input type="hidden" name="part" value="<?php echo $memos['part'] ?>">
        <input type="hidden" name="weight" value="<?php echo $memos['weight'] ?>">
        <input type="hidden" name="memo" value="<?php echo $memos['memo'] ?>">
        <input type="submit" name="backbtn" value="前のページへ戻る">
      </form>
    </div>
  <?php else : ?>
    <p class=" thanks">編集が完了しました</p>
    <div class="content">
      <a href="index.php" class="button">一覧へ</a>
    </div>
  <?php endif ?>

</body>

</html>
