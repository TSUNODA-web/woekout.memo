<?php
session_start();
require('library.php');

if (isset($_SESSION['id']) && isset($_SESSION['name'])) {
  $id = $_SESSION['id'];
  $name = $_SESSION['name'];
} else {
  header('Location: login.php');
  exit();
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $db = dbconnect();
  $db->begin_transaction();
  $stmt = $db->prepare('insert into posts(weght,email,password) VALUES(?,?,?)');
}
