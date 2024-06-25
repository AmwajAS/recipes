<?php
require_once "parts/header.php";

if (!is_logged_in()) {
  header('Location: login.php');
  die();
} else {
  header('Location: recipes.php');
}
