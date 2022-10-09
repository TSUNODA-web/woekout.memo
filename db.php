<?php
require('library.php');

/*$dsn = ('mysql:dbname=workout_memo;localhost;charset=UTF8');
$user = 'makojin';
$password = 'Tunomako2110';
try {
  $dbh = new PDO($dsn, $user, $password, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

  $sql = 'select * from posts';
  $stmt = $dbh->query($sql);
  $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
  var_dump($result);

  $dbh = null;
} catch (PDOException $e) {
  echo '接続失敗' . $e->getMessage();
  exit();
}*/
$member_id = 5;
$db = db();
$stmt = $db->prepare('select * from posts WHERE member_id =:id');
$stmt->bindValue(':id', $member_id, PDO::PARAM_INT);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);
var_dump($result);
