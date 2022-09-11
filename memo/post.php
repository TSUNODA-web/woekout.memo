<?php
session_start();
require('../library.php');
if (isset($_SESSION['id']) && isset($_SESSION['name'])) {
  $id = $_SESSION['id'];
} else {
  header('Location: login.php');
  exit();
}

$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
if (!$id) {
  header('Location: index.php');
  exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $form['weight'] = filter_input(INPUT_POST, 'weight', FILTER_SANITIZE_NUMBER_INT);
  if ($form['weight'] === '') {
    $error['weight'] = 'blank';
  }
  $form['part'] = filter_input(INPUT_POST, 'part');
  if ($form['part'] === '') {
    $error['part'] = 'blank';
  }
  $form['part'] = filter_input(INPUT_POST, 'memo');
  if ($form['part'] === '') {
    $error['part'] = 'blank';
  }

  /*$image = $_FILES['image'];
  if ($image['name'] !== '' && $image['error'] === 0) {
    $type = mime_content_type($image['tmp_name']);
    if ($type !== 'image/png' && $type !== 'image/jpeg') {
      $error['image'] = 'type';
    }
  }*/

  if (empty($error)) {
    $_SESSION['form'] = $form;

    //画像のアップロード
    /*if ($image['name'] !== '') {
      $filename = date('YmdHis') . '_' . $image['name'];
      if (!move_uploaded_file($image['tmp_name'], '../member_picture/' . $filename)) {
        die('失敗しました');
      }
      $_SESSION['form']['image'] = $filename;
    } else {
      $_SESSION['form']['image'] = '';
    }*/

    header('location: post_done.php');
    exit();
  }
}
?>



<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <link rel="stylesheet" href="../reset.css" />
  <link rel="stylesheet" href="../style.css" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>投稿画面</title>
</head>

<body>
  <header>
    <h1 class="headline"><a href="../index.php?id=<?php echo h($id); ?>">筋トレメモ</a>
    </h1>
    <ul class="nav-list">
      <li class="nav-list-item">
        <a href="../mypage.php?id=<?php echo h($id); ?>">マイページ</a>
      </li>
      <li class="nav-list-item">
        <a href="logout.php">ログアウト</a>
      </li>
    </ul>
  </header>
  <p class="form-title">メモ</p>
  <div class="form-content">
    <form action="" method="post">
      <div class="form-list">
        <label>体重</label>
        <input name="weight" type="number" max="100" min="0" step="0.1">
      </div>
      <?php if (isset($error['weight']) && $error['weight'] === 'blank') :  ?>
        <p class="error">＊選択してください</p>
      <?php endif; ?>
      <div class="form-list">
        <label>部位</label>
        <select name="part">
          <option value="">選択してください</option>
          <option value="胸">胸</option>
          <option value="肩">肩</option>
          <option value="腕">腕</option>
          <option value="背中">背中</option>
          <option value="足">足</option>
        </select>
      </div>
      <?php if (isset($error['part']) && $error['part'] === 'blank') :  ?>
        <p class="error">＊選択してください</p>
      <?php endif; ?>
      <div class="form-list">
        <label>メモ</label>
        <textarea name="memo" cols="50" rows="5"></textarea>
      </div>
      <?php if (isset($error['memo']) && $error['memo'] === 'blank') : ?>
        <p class="error">＊入力してください</p>
      <?php endif; ?>
      <div class="form-list">
        <label>写真</label>
        <input type="file" name="image" size="35" value="">
      </div>
      <p class="error">＊写真などは「.png」または「.jpg」の画像を指定してください</p>
      <div class="btn-area">
        <input type="submit" name="" value="メモする">
      </div>
    </form>
  </div>


</body>

</html>
