<?php
/*htmlspecialcharsを短くする*/
function h($value)
{
  return htmlspecialchars($value, ENT_QUOTES);
}

/*データベースの接続*/
function dbconnect()
{
  $db = new mysqli('localhost', 'root', 'root', 'workout_memo');
  if (!$db) {
    die($db->error);
  }
  return $db;
}

function memos_validate($memos)
{
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
  }

  return $memos;
}

function memos_picture($memos)
{
  $image = $_FILES['image'];
  if ($image['name'] !== '' && $image['error'] === 0) {
    $type = mime_content_type($image['tmp_name']);
    if ($type !== 'image/png' && $type !== 'image/jpeg') {
      $error['image'] = 'type';
    }
  }
  if ($image['name'] !== '') {
    $filename = date('YmdHis') . '_' . $image['name'];
    if (!move_uploaded_file($image['tmp_name'], '../picture/' . $filename)) {
      die('失敗しました');
    }
    $_POST['image'] = $filename;
  } else {
    $_POST['image'] = '';
  }
}
