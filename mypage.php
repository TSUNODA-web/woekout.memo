<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="reset.css" />
  <link rel="stylesheet" href="style.css" />

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
  <p class="form-title">登録情報</p>
  <div class="form-content">
    <form action="" method="post">
      <div class="form-list">
        <label>お名前</label>
        <input name="name" type="text" value="">
      </div>
      <div class="form-list">
        <label>メールアドレス</label>
        <input name="email" type="email" value="">
      </div>
      <div class="form-list">
        <label>パスワードは表示されません</label>
        <input name="password" type="password" value="">
      </div>
      <div class="btn-area">
        <input type="submit" name="" value="編集する">
      </div>
    </form>
  </div>
</body>

</html>
