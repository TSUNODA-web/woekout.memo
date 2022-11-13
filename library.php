<?php
/*htmlspecialcharsを短くする*/
function h($value)
{
  return htmlspecialchars($value, ENT_QUOTES);
}

/*データベースの接続*/
/*function dbconnect()
{
  $db = new mysqli('localhost', 'root', 'root', 'workout_memo');
  if (!$db) {
    die($db->error);
  }
  return $db;
}*/

function dbconnect()
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

function dbconnect2()
{
  $db = parse_url($_SERVER['CLEARDB_DATABASE_URL']);
  $db['dbname'] = ltrim($db['path'], '/');
  $dsn = "mysql:host={$db['host']};dbname={$db['dbname']};charset=utf8";
  $user = $db['user'];
  $password = $db['pass'];
  $options = array(
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true,
  );
  $dbh = new PDO($dsn, $user, $password, $options);
  return $dbh;
}
