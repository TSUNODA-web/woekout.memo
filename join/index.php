<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>会員登録</title>
</head>

<body>
  <div id="wrap">
    <div id="head">
      <h1>会員登録</h1>
    </div>

    <div id="content">
      <p>次のフォームに必要事項をご記入ください。</p>
      <form action="" method="post" enctype="multipart/form-data">
        <dl>
          <dt>ニックネーム<span class="required">必須</span></dt>
          <dd>
            <input type="text" name="name" size="35" maxlength="255" value="" />
            <p class="error">* ニックネームを入力してください</p>
          </dd>
          <dt>メールアドレス<span class="required">必須</span></dt>
          <dd>
            <input type="text" name="email" size="35" maxlength="255" value="" />
            <p class="error">* メールアドレスを入力してください</p>
            <p class="error">* 指定されたメールアドレスはすでに登録されています</p>
          <dt>パスワード<span class="required">必須</span></dt>
          <dd>
            <input type="password" name="password" size="10" maxlength="20" value="" />
            <p class="error">* パスワードを入力してください</p>
            <p class="error">* パスワードは4文字以上で入力してください</p>
          </dd>
        </dl>
        <div><input type="submit" value="入力内容を確認する" /></div>
      </form>
    </div>
</body>

</html>
