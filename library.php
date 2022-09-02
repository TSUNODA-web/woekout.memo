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
