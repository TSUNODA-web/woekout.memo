<?php
session_start();
require('../library.php');




if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  $form['weight'] = filter_input(INPUT_POST, 'weight', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
  if ($form['weight'] === '') {
    $error['weight'] = 'blank';
  }
  $form['part'] = filter_input(INPUT_POST, 'part');
  if ($form['part'] === '') {
    $error['part'] = 'blank';
  }
  $form['memo'] = filter_input(INPUT_POST, 'memo');
  if ($form['memo'] === '') {
    $error['memo'] = 'blank';
  }
  $form['member_id'] = filter_input(INPUT_POST, 'member_id');

  $image = $_FILES['image'];
  if ($image['name'] !== '' && $image['error'] === 0) {
    $type = mime_content_type($image['tmp_name']);
    if ($type !== 'image/png' && $type !== 'image/jpeg') {
      $error['image'] = 'type';
    }
  }


  if (empty($error)) {
    $_SESSION['form'] = $form;

    //画像のアップロード
    /*if ($image['name'] !== '') {
      $filename = date('YmdHis') . '_' . $image['name'];
      if (!move_uploaded_file($image['tmp_name'], '../picture/' . $filename)) {
        die('アップロードに失敗しました。');
      }
      $_SESSION['form']['image'] = $filename;
    } else {
      $_SESSION['form']['image'] = '';
    }

    header('location: check.php');
    exit();*/
  }
}

if ($image['name'] != '') {
  $filename = date('YmdHis') . '_' . $image['name'];
  if (!move_uploaded_file($image['tmp_name'], '../picture/' . $filename)) {
    die('失敗しました');
  }
  $_SESSION['form']['image'] = $filename;
} else {
  $_SESSION['form']['image'] = '';
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
        <p class="form-title">メモ</p>
        <form enctype="multipart/form-data" action="" method="post">
          <div class="form-list">
            <label>体重</label>
            <input name="weight" type="number" max="100" min="0" step="0.1" value="<?php echo h($form['weight']); ?>">
          </div>
          <?php if (isset($error['weight']) && $error['weight'] === 'blank') :  ?>
            <p class="error">＊選択してください</p>
          <?php endif; ?>
          <div class="form-list">
            <label>部位</label>
            <input name="part" type="text" value="<?php echo h($form['part']); ?>">
          </div>
          <?php if (isset($error['part']) && $error['part'] === 'blank') :  ?>
            <p class="error">＊選択してください</p>
          <?php endif; ?>
          <div class="form-list">
            <label>メモ</label>
            <textarea name="memo" placeholder="150字まで" maxlength="150"><?php echo h($form['memo']); ?></textarea>
          </div>
          <?php if (isset($error['memo']) && $error['memo'] === 'blank') : ?>
            <p class="error">＊入力してください</p>
          <?php endif; ?>
          <div class="form-list">
            <label>写真</label>
            <input type="file" name="image" size="35">
          </div>
          <?php if (isset($error['image']) && $error['image'] === 'type') : ?>
            <p class="error">＊写真は「.png」または「.jpg」の画像を指定してください</p>
          <?php endif; ?>
          <div>
            <input type="hidden" name="member_id" value="<?php echo $id; ?>">
          </div>

          <div class="btn-area">
            <input type="submit" name="" value="入力内容確認">
          </div>
        </form>
      </div>
    </section>
  </main>



</body>

</html>
