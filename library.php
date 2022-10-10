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

function db()
{
  $dsn = ('mysql:dbname=workout_memo;localhost;charset=UTF8');
  $user = 'makojin';
  $password = 'Tunomako2110';
  try {
    $dbh = new PDO($dsn, $user, $password, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_EMULATE_PREPARES => false]);
  } catch (PDOException $e) {
    echo '接続失敗' . $e->getMessage();
    exit();
  }
  return $dbh;
}
