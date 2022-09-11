<?php
session_start();
require('library.php');

if (isset($_SESSION['id']) && isset($_SESSION['name'])) {
  $id = $_SESSION['id'];
  $form = $_POST['form'];
} else {
  header('Location: login.php');
  exit();
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $db = dbconnect();
  $db->begin_transaction();
  $stmt = $db->prepare('insert into posts(member_id,weight,part,memo) VALUES(?,?,?,?)');
  if (!$stmt) {
    die($db->error);
  }

  $stmt->bind_param('iss', $form['weight'], $form['part'], $form['memo']);
  $success = $stmt->execute();
  if (!$success) {
    die($db->error);
  }
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
  <header>
    <h1 class="headline"><a href="">筋トレメモ</a>
    </h1>
    <ul class="nav-list">
      <li class="nav-list-item">
        <a href=" mypage.php?id=<?php echo h($id); ?>"><?php echo h($name); ?>様</a>
      </li>
      <li class="nav-list-item">
        <a href="logout.php">ログアウト</a>
      </li>
    </ul>
  </header>


</body>

</html>
