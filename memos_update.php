<?
session_start();
require('/Applications/MAMP/htdocs/workout.memo/library.php');

if (isset($_SESSION['id']) && isset($_SESSION['name'])) {
  $id = $_SESSION['id'];
  $form = $_SESSION['form'];
} else {
  header('Location: login.php');
  exit();
}
