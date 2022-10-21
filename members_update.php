<?php
session_start();
require('library.php');
if (isset($_SESSION['id']) && isset($_SESSION['name'])) {
  $id = $_SESSION['id'];
  $email = $_SESSION['email'];
} else {
  header('Location: login.php');
  exit();
}
//サニタイズ
$member = array();
if (!empty($_POST)) {
  foreach ($_POST as $key => $value) {
    $member[$key] = h($value);
  }
}

//エラーメッセージ
$err = array();

//バリデーション
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $member['name'] = filter_input(INPUT_POST, 'name');
  if ($member['name'] === '') {
    $err[] = '名前を入力してください';
  } elseif (20 < mb_strlen($member['name'])) {
    $err[] = "名前は20文字以内で入力してください。";
  }
  $member['email'] = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
  if ($member['email'] === '') {
    $err[] = 'メールアドレスを入力してください';
  } elseif ($email == $member['email']) {
    $email = $member['email'];
  } else {
    $db = dbconnect();
    try {
      $stmt = $db->prepare('select count(*) as cnt from members where email=:email ');
      $stmt->bindValue(':email', $member['email'], PDO::PARAM_STR);
      $stmt->execute();
      $result = $stmt->fetch();
      if ($result['cnt'] > 0) {
        $err[] = "指定されたメールアドレスはすでに登録されています";
      }
    } catch (PDOException $e) {
      $db->rollBack();
      exit($e);
    }
  }

  //アップデート処理
  if (count($err) === 0) {
    $db = dbconnect();
    $db->beginTransaction();
    try {
      $stmt = $db->prepare('update members SET name=:name,email=:email where id=:member_id;');

      $stmt->bindValue(':name', $member['name'], PDO::PARAM_STR);
      $stmt->bindValue(':email', $member['email'], PDO::PARAM_STR);
      $stmt->bindValue(':member_id', (int)$member['id'], PDO::PARAM_INT);
      $stmt->execute();
      $db->commit();
    } catch (PDOException $e) {
      $db->rollBack();
      exit($e);
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
  <title>更新完了</title>
</head>

<body>
  <header id="header">
    <div class="wrapper">
      <p class="logo"><a href="index.php">筋トレメモ</a></p>
      <nav>
        <ul>
          <li><a href="memo/post.php?id=<?php echo $id; ?>">メモする</a></li>
          <li><a href="mypage.php?id=<?php echo $id; ?>">マイページ</a></li>
          <li><a href="logout.php">ログアウト</a></li>
        </ul>
      </nav>
    </div>
  </header>
  <div class="form-title">フォーム</div>
  <?php if (count($err) > 0) : ?>
    <?php foreach ($err as $e) : ?>
      <p class="thanks"><?php echo $e ?></p>
    <?php endforeach ?>
    <div class="form-content">
      <form method="post" action="mypage.php?id=<?php echo $member['id']; ?>">
        <input type="hidden" name="name" value="<?php echo $member['name'] ?>">
        <input type="hidden" name="email" value="<?php echo $member['email'] ?>">
        <input type="submit" name="backbtn" value="前のページへ戻る">
      </form>
    </div>
  <?php else : ?>
    <?php
    //セッションを破棄し再度ログインしてもらう

    $_SESSION = array();
    session_destroy();
    ?>
    <p class=" thanks">編集が完了しました<br>再度ログインしてくだし</p>
    <div class="content">
      <a href="login.php" class="button">ログイン</a>
    </div>
  <?php endif ?>

</body>

</html>
