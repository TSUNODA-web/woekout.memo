<?php
session_start();
require('library.php');
if (isset($_SESSION['id']) && isset($_SESSION['name'])) {
  $member_id = $_SESSION['id'];
} else {
  header('Location: login.php');
  exit();
}
$memos = array();

//サニタイズ
if (!empty($_POST)) {
  foreach ($_POST as $key => $value) {
    $memos[$key] = h($value);
  }
}
var_dump($memos);
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
  } elseif (20 < mb_strlen($memos['memo'])) {
    $err[] = "メモは200文字以内で入力してください。";
  }

  //アップデート処理
  if (count($err) === 0) {
    $db = dbconnect();
    $db->begin_transaction();
    $stmt = $db->prepare('update posts SET part=?,weight=?,memo=? where id=?;');

    if (!$stmt) {
      die($db->error);
    }

    $stmt->bind_param('sssi', $memos['part'], $memos['weight'], $memos['memo'], $memos['id']);
    $success = $stmt->execute();
    $db->commit();

    if (!$success) {
      die($db->error);
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
  <title>編集完了</title>
</head>

<body>
  <header>
    <h1 class="headline"><a href="">筋トレメモ</a>
    </h1>
    <ul class="nav-list">
      <li class="nav-list-item">
        <a href=" mypage.php?id=<?php echo h($member_id); ?>">マイページ</a>
      </li>
      <li class="nav-list-item">
        <a href="logout.php">ログアウト</a>
      </li>
    </ul>
  </header>
  <div class="form-title">フォーム</div>
  <?php if (count($err) > 0) : ?>
    <?php foreach ($err as $e) : ?>
      <p class="thanks"><?php echo $e ?></p>
    <?php endforeach ?>
    <form method="post" action="detail.php?id=<?php echo $memos['id']; ?>">
      <input type="hidden" name="part" value="<?php echo $memos['part'] ?>">
      <input type="hidden" name="weight" value="<?php echo $memos['weight'] ?>">
      <input type="hidden" name="memo" value="<?php echo $memos['memo'] ?>">
      <input type="submit" name="backbtn" value="前のページへ戻る">
    </form>
  <?php else : ?>
    <p class=" thanks">編集が完了しました</p>
    <div class="content">
      <a href="index.php" class="button">一覧へ</a>
    </div>
  <?php endif ?>

</body>

</html>
