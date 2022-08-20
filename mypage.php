<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>マイページ</title>
</head>

<body>
  <header>
    <h1><a href="">筋トレメモ</a></h1>
    <ul class="nav-list">
      <li class="nav-list-item">
        <a href="mypage.php">ログイン中のユーザー名</a>
      </li>
      <li class="nav-list-item">
        <a href="logout.php">ログアウト</a>
      </li>
    </ul>
  </header>
  <div class="form">
    <div class="form_title">登録情報</div>
    <div class="form_content">
      <form action="" method="post">
        <div class="form_list">
          <label>お名前</label>
          <!-- <p>データベースから名前を取得</p> -->
          <label>メールアドレス</label>
          <!-- <p>データベースからアドレスを取得</p> -->
          <label>パスワードは表示されません</label>
          <input type="submit" value="変更する" />
        </div>
    </div>
    </form>
  </div>
</body>

</html>
